#!/bin/bash
set -e

########################################
# Install required packages
########################################
apt update -y
apt install -y \
  apache2 samba dovecot-pop3d zip qpdf john poppler-utils \
  enscript ghostscript

########################################
# Create simple black webpage
########################################
cat >/var/www/html/index.html <<'EOF'
<!DOCTYPE html>
<html>
<head>
<title>CyberGryffin Blogs</title>
<style>
body { background-color: black; color: white; font-family: Arial; }
</style>
</head>
<body>
<h2><center>CyberGryffin Blogs</center></h2>
<p><center>Oops! Website under construction</center></p>
</body>
</html>
EOF

########################################
# Create backups directory (web-accessible)
########################################
mkdir -p /var/www/html/backups
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

########################################
# Create POP3 user
########################################
useradd -m popuser
echo "popuser:EmailPassword123" | chpasswd

########################################
# Configure Dovecot (POP3)
########################################
sed -i 's/#disable_plaintext_auth = yes/disable_plaintext_auth = no/' \
    /etc/dovecot/conf.d/10-auth.conf

echo "mail_location = maildir:~/Maildir" \
    > /etc/dovecot/conf.d/99-maildir.conf

systemctl restart dovecot

########################################
# Create email with ZIP password
########################################
MAILDIR=/home/popuser/Maildir
mkdir -p $MAILDIR/{cur,new,tmp}
chown -R popuser:popuser $MAILDIR

BACKUP_PASS="SuperSafeBackup321"

cat > $MAILDIR/new/$(date +%s).eml <<EOF
From: admin@ctf.local
To: popuser@ctf.local
Subject: Backup Password

The password for the backup file is:

$BACKUP_PASS
EOF

chown popuser:popuser $MAILDIR/new/*

########################################
# Ensure root SSH key exists
########################################
ROOT_KEY="/root/.ssh/id_rsa"

if [ ! -f "$ROOT_KEY" ]; then
    echo "[!] Root SSH private key missing. Aborting."
    exit 1
fi

########################################
# Create PDF containing root SSH key
########################################
cat >/tmp/backup.txt <<EOF
Confidential Root Access Material

$(cat "$ROOT_KEY")
EOF

enscript /tmp/backup.txt -o - | ps2pdf - /tmp/root_key_unencrypted.pdf

########################################
# Encrypt PDF (forces pdf2john usage)
########################################
qpdf --encrypt "$BACKUP_PASS" "$BACKUP_PASS" 256 \
     /tmp/root_key_unencrypted.pdf /tmp/root_key.pdf

########################################
# ZIP creation (KNOWN WORKING METHOD)
########################################
zip -j -P "$BACKUP_PASS" \
    /var/www/html/backups/backup.zip \
    /tmp/root_key.pdf

########################################
# Configure SMB Guest Share
########################################
cat >/etc/samba/smb.conf <<EOF
[global]
   workgroup = WORKGROUP
   security = user
   map to guest = Bad User

[guestshare]
   path = /srv/guestshare
   browsable = yes
   read only = yes
   guest ok = yes
EOF

mkdir -p /srv/guestshare
chmod 755 /srv/guestshare

########################################
# POP3 credentials in guest SMB share
########################################
cat >/srv/guestshare/imap_creds.txt <<EOF
POP3 Username: popuser
POP3 Password: EmailPassword123
POP3 Server: <machine-ip>
Port: 110
EOF

systemctl restart smbd

########################################
# Restart Apache
########################################
systemctl restart apache2

########################################
# Final confirmation
########################################
echo "[+] Setup complete"
echo "[+] Backup ZIP located at: http://<machine-ip>/backups/backup.zip"
