#!/usr/bin/env bash
#
# Runner praktis untuk suite k6 Projek BUBA.
#
# Contoh:
#   ./tests/k6/run.sh smoke
#   ./tests/k6/run.sh load
#   BASE_URL=http://localhost:8080 ./tests/k6/run.sh soak
#   ./tests/k6/run.sh load --out json=reports/load.json
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROFILE="${1:-smoke}"

if [[ "${PROFILE}" == "-h" || "${PROFILE}" == "--help" ]]; then
  cat <<'EOF'
Penggunaan: tests/k6/run.sh <profil> [opsi k6...]

Profil:
  smoke    Cek cepat seluruh halaman/endpoint (1 VU, 1 iterasi)
  load     Beban normal (publik + siswa + admin + API)
  stress   Naik bertahap sampai titik jenuh
  spike    Lonjakan trafik mendadak
  soak     Beban sedang dalam durasi lama
  write    Alur tulis (login, submit kuis, logout) - merusak data!

Environment:
  BASE_URL       default http://localhost:8000
  ADMIN_EMAIL    default admin@example.com
  ADMIN_PASSWORD default admin123
  STUDENT_EMAIL  default siswa.3206095003@example.test
  STUDENT_PASSWORD default siswa123

Contoh:
  ./tests/k6/run.sh smoke
  PUBLIC_VUS=10 API_VUS=20 ./tests/k6/run.sh load
  SOAK_DURATION=30m ./tests/k6/run.sh soak
  ./tests/k6/run.sh load --out json=reports/load.json
EOF
  exit 0
fi

if [[ ! -f "${SCRIPT_DIR}/${PROFILE}.js" ]]; then
  echo "Profil '${PROFILE}' tidak ditemukan di ${SCRIPT_DIR}" >&2
  echo "Pilihan: smoke, load, stress, spike, soak, write" >&2
  exit 1
fi

shift || true

BASE_URL="${BASE_URL:-http://localhost:8000}"

if ! command -v k6 >/dev/null 2>&1; then
  echo "k6 tidak ditemukan. Install dulu: https://grafana.com/docs/k6/latest/set-up/install-k6/" >&2
  exit 1
fi

echo ">> k6 profile : ${PROFILE}"
echo ">> target     : ${BASE_URL}"
echo

exec k6 run \
  -e BASE_URL="${BASE_URL}" \
  "$@" \
  "${SCRIPT_DIR}/${PROFILE}.js"
