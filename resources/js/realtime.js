const page = document.body?.dataset?.realtimePage || '';
const role = document.body?.dataset?.realtimeRole || '';
const userId = document.body?.dataset?.realtimeUserId || '';
const resourceId = document.body?.dataset?.realtimeResourceId || '';
const isStudent = role === 'siswa';

/**
 * Jika entity berubah, halaman admin apa saja yang perlu dimuat ulang.
 */
const ADMIN_RELATED_PAGES = {
    kelas: ['kelas', 'dashboard', 'kategori', 'siswa', 'materi', 'kuis', 'reward'],
    kategori: ['kategori', 'dashboard', 'materi', 'kuis', 'reward'],
    materi: ['materi', 'dashboard'],
    quis: ['kuis', 'dashboard', 'reward'],
    reward: ['reward', 'dashboard'],
    siswa: ['siswa', 'dashboard', 'kelas', 'reward'],
};

/**
 * Jika entity berubah, halaman siswa apa saja yang perlu dimuat ulang.
 * Halaman kuis yang sedang dikerjakan sengaja tidak dimasukkan.
 */
const STUDENT_RELATED_PAGES = {
    kelas: ['kelas-siswa', 'kategori-siswa', 'materi-siswa', 'materi-detail', 'kuis-siswa', 'reward-siswa'],
    kategori: ['kategori-siswa', 'materi-siswa', 'materi-detail', 'kuis-siswa', 'reward-siswa'],
    materi: ['materi-siswa', 'materi-detail'],
    quis: ['kuis-siswa', 'reward-siswa'],
    reward: ['reward-siswa'],
    siswa: ['kelas-siswa', 'kategori-siswa', 'materi-siswa', 'materi-detail', 'kuis-siswa', 'reward-siswa'],
};

const RELATED_PAGES = isStudent ? STUDENT_RELATED_PAGES : ADMIN_RELATED_PAGES;

let reloadTimer = null;
let pendingReload = false;
let firstPendingAt = null;

function isTyping() {
    const element = document.activeElement;

    return element && ['INPUT', 'TEXTAREA', 'SELECT'].includes(element.tagName);
}

function isRecentSubmit() {
    try {
        const at = Number(sessionStorage.getItem('realtime:last-submit') || 0);

        return at > 0 && Date.now() - at < 3000;
    } catch {
        return false;
    }
}

function showToast(message, { withButton = true, duration = 0 } = {}) {
    let toast = document.getElementById('realtime-toast');

    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'realtime-toast';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.style.cssText = [
            'position:fixed',
            'right:20px',
            'bottom:20px',
            'z-index:99999',
            'display:flex',
            'align-items:center',
            'gap:12px',
            'padding:12px 16px',
            'border-radius:12px',
            'background:#0f172a',
            'color:#fff',
            'font-size:14px',
            'box-shadow:0 10px 30px rgba(15,23,42,.28)',
            'font-family:ui-sans-serif,system-ui,sans-serif',
            'max-width:calc(100vw - 40px)',
        ].join(';');

        document.body.appendChild(toast);
    }

    toast.replaceChildren();

    const text = document.createElement('span');
    text.textContent = message;
    toast.appendChild(text);

    if (withButton) {
        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = 'Muat ulang';
        button.style.cssText = [
            'border:0',
            'border-radius:8px',
            'padding:6px 10px',
            'background:#2563eb',
            'color:#fff',
            'font-size:13px',
            'font-weight:600',
            'cursor:pointer',
        ].join(';');

        button.addEventListener('click', reloadPage);
        toast.appendChild(button);
    }

    if (duration > 0) {
        window.setTimeout(() => toast.remove(), duration);
    }
}

function reloadPage() {
    if (document.visibilityState === 'hidden') {
        pendingReload = true;
        return;
    }

    pendingReload = false;
    firstPendingAt = null;
    clearTimeout(reloadTimer);

    showToast('Data berubah. Memuat ulang...', { withButton: false });

    window.setTimeout(() => window.location.reload(), 250);
}

function handleChange(payload) {
    if (!page) {
        return;
    }

    const affected = RELATED_PAGES[payload.entity] ?? [payload.entity];

    if (!affected.includes(page)) {
        return;
    }

    // Di halaman detail materi, reload hanya jika materi yang berubah
    // adalah materi yang sedang dibuka.
    if (
        page === 'materi-detail' &&
        payload.entity === 'materi' &&
        resourceId &&
        payload.id &&
        String(payload.id) !== String(resourceId)
    ) {
        return;
    }

    // Hindari reload ganda di tab yang barusan submit form.
    if (isRecentSubmit()) {
        return;
    }

    if (!pendingReload) {
        pendingReload = true;
        firstPendingAt = Date.now();
    }

    clearTimeout(reloadTimer);

    if (document.visibilityState === 'hidden') {
        return;
    }

    if (isTyping()) {
        showToast('Data berubah. Selesai mengetik, halaman akan dimuat ulang.');
        return;
    }

    const waited = Date.now() - (firstPendingAt ?? Date.now());

    // Walaupun event datang terus-menerus, tetap reload maksimal tiap 3 detik.
    if (waited >= 3000) {
        reloadPage();
        return;
    }

    reloadTimer = window.setTimeout(reloadPage, 800);
}

// Tandai tab ini sedang submit form, supaya tidak reload dua kali.
document.addEventListener('submit', () => {
    try {
        sessionStorage.setItem('realtime:last-submit', String(Date.now()));
    } catch {
        // abaikan
    }
}, true);

// Jika tadi user sedang mengetik, reload setelah selesai mengetik.
document.addEventListener('focusout', (event) => {
    if (!pendingReload) {
        return;
    }

    if (!['INPUT', 'TEXTAREA', 'SELECT'].includes(event.target.tagName)) {
        return;
    }

    window.setTimeout(() => {
        if (!isTyping()) {
            reloadPage();
        }
    }, 400);
});

// Reload saat tab kembali aktif.
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible' && pendingReload) {
        reloadPage();
    }
});

if (window.Echo && page) {
    if (role === 'guru') {
        window.Echo
            .private('admin.data')
            .listen('.data.changed', handleChange);
    }

    if (isStudent) {
        // Perubahan kelas, kategori, materi, dan kuis.
        window.Echo
            .private('siswa.data')
            .listen('.data.changed', handleChange);

        // Event khusus siswa ini: reward miliknya dan perubahan data akunnya.
        if (userId) {
            window.Echo
                .private(`App.Models.User.${userId}`)
                .listen('.data.changed', handleChange);
        }
    }
}
