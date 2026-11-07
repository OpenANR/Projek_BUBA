/**
 * Efek suara saat tombol ditekan di halaman siswa.
 *
 * Suara dibuat langsung dengan Web Audio API sehingga tidak memerlukan file
 * audio tambahan. Modul ini hanya aktif ketika pengguna berada di area siswa,
 * jadi tombol di halaman admin tidak ikut berbunyi.
 */
const isStudentArea =
    document.body?.dataset?.realtimeRole === 'siswa' ||
    window.location.pathname.startsWith('/siswa');

const CLICKABLE_SELECTOR = [
    'button',
    'a[href]',
    '[role="button"]',
    'input[type="button"]',
    'input[type="submit"]',
    'input[type="reset"]',
    'summary',
].join(', ');

let audioContext = null;
let lastPlayedAt = 0;

function getAudioContext() {
    const AudioContextClass = window.AudioContext || window.webkitAudioContext;

    if (!AudioContextClass) {
        return null;
    }

    if (!audioContext) {
        audioContext = new AudioContextClass();
    }

    // Safari/iOS menangguhkan audio sampai ada interaksi pengguna.
    if (audioContext.state === 'suspended') {
        audioContext.resume();
    }

    return audioContext;
}

function playClickSound() {
    const context = getAudioContext();

    if (!context) {
        return;
    }

    const now = context.currentTime;
    const oscillator = context.createOscillator();
    const gain = context.createGain();

    // Bunyi "pop" pendek: nada turun cepat supaya terdengar ramah anak.
    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(760, now);
    oscillator.frequency.exponentialRampToValueAtTime(320, now + 0.09);

    gain.gain.setValueAtTime(0.0001, now);
    gain.gain.exponentialRampToValueAtTime(0.18, now + 0.012);
    gain.gain.exponentialRampToValueAtTime(0.0001, now + 0.12);

    oscillator.connect(gain);
    gain.connect(context.destination);
    oscillator.start(now);
    oscillator.stop(now + 0.13);
}

function findClickable(target) {
    return target instanceof Element ? target.closest(CLICKABLE_SELECTOR) : null;
}

function shouldPlay(element, event) {
    if (!element) {
        return false;
    }

    // Elemen bisa diberi atribut data-silent untuk tidak berbunyi.
    if (element.hasAttribute('data-silent')) {
        return false;
    }

    if (element.matches(':disabled') || element.getAttribute('aria-disabled') === 'true') {
        return false;
    }

    // Abaikan klik selain tombol kiri mouse.
    if (event?.type === 'pointerdown' && event.button > 0) {
        return false;
    }

    // Cegah suara bertumpuk saat tombol diklik sangat cepat.
    const now = Date.now();

    if (now - lastPlayedAt < 40) {
        return false;
    }

    lastPlayedAt = now;

    return true;
}

if (isStudentArea) {
    // pointerdown membuat suara langsung terdengar, bahkan sebelum halaman
    // berpindah saat tombol berupa link.
    document.addEventListener(
        'pointerdown',
        (event) => {
            if (shouldPlay(findClickable(event.target), event)) {
                playClickSound();
            }
        },
        { passive: true },
    );

    // Tetap berbunyi saat tombol diaktifkan lewat keyboard (Enter / Spasi).
    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' && event.key !== ' ') {
            return;
        }

        if (shouldPlay(findClickable(event.target), event)) {
            playClickSound();
        }
    });
}
