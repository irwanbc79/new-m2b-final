#!/bin/bash

# Configuration for remote Hostinger server
SERVER_IP="31.97.104.23"
SERVER_PORT="65002"
SERVER_USER="u301249154"
SERVER_PASS="sshFawFaq34*"
ENV_PATH="domains/m2b.co.id/public_html/new-m2b/.env"
LARAVEL_DIR="domains/m2b.co.id/public_html/new-m2b"

echo "================================================="
echo "   MORA AI API Key Updater (m2b.co.id)"
echo "================================================="
echo "Pilih API Key yang ingin diperbarui:"
echo "1) Gemini API Key (MORA_GEMINI_KEY)"
echo "2) Claude API Key (MORA_CLAUDE_KEY)"
read -p "Masukkan pilihan (1 atau 2): " PILIHAN

if [ "$PILIHAN" == "1" ]; then
    VAR_NAME="MORA_GEMINI_KEY"
elif [ "$PILIHAN" == "2" ]; then
    VAR_NAME="MORA_CLAUDE_KEY"
else
    echo "Pilihan tidak valid!"
    exit 1
fi

read -p "Masukkan API Key baru Anda: " NEW_KEY

if [ -z "$NEW_KEY" ]; then
    echo "API Key tidak boleh kosong!"
    exit 1
fi

echo "-------------------------------------------------"
echo "Sedang memperbarui $VAR_NAME di server..."

# Command to update the key using Python on the server to avoid escape character issues
SSH_CMD="python3 -c \"
path = '$ENV_PATH'
var_name = '$VAR_NAME'
new_key = '$NEW_KEY'
with open(path, 'r') as f:
    lines = f.readlines()
updated = False
for i, line in enumerate(lines):
    if line.startswith(var_name + '='):
        lines[i] = f'{var_name}={new_key}\n'
        updated = True
        break
if not updated:
    lines.append(f'{var_name}={new_key}\n')
with open(path, 'w') as f:
    f.writelines(lines)
print('Berhasil memperbarui .env!')
\""

sshpass -p "$SERVER_PASS" ssh -o StrictHostKeyChecking=no -p "$SERVER_PORT" "$SERVER_USER@$SERVER_IP" "$SSH_CMD"

if [ $? -eq 0 ]; then
    echo "Membersihkan cache Laravel di server..."
    sshpass -p "$SERVER_PASS" ssh -o StrictHostKeyChecking=no -p "$SERVER_PORT" "$SERVER_USER@$SERVER_IP" "cd $LARAVEL_DIR && php artisan config:clear && php artisan cache:clear && php artisan config:cache"
    echo "================================================="
    echo " Sukses! API Key $VAR_NAME telah diperbarui."
    echo "================================================="
else
    echo "Gagal memperbarui API Key di server. Periksa koneksi internet Anda."
fi
