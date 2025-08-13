#!/bin/bash

# Create player user
useradd -m -s /bin/bash hotelmanager
echo "hotelmanager:itsmystr0ngp4ssw0rd" | chpasswd

# Allow vim privilege escalation
echo "hotelmanager ALL=(ALL) NOPASSWD: /usr/bin/vim" >> /etc/sudoers

# Configure SSH
mkdir /var/run/sshd
