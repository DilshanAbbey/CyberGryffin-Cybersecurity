#!/usr/bin/env python3

import hashlib
import time

# Store hashed password (original = "STARLIGHTGODACCESS")
correct_hash = "fced79eaeae43997959173f6cc4c61a6e3e854a627d85e58f93fca9d96381e5d"
flag = "CSC{SATTEl1te_C0mmun1c4t10N_En4bld}"

# Satellite ASCII Art
art = r"""
.                                    .                          .              .
⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠃⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀.⠀⠀
⠀⠀⠀.⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣴⣷⣶⣤⣀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣴⣻⣹⣿⣿⣿⣿⣿⣿⣶⣦⣤⣀⡀⠀⠀⠀⠀⠀⠀⢀⠄⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠙⠻⠶⣛⡛⠿⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⠄⠀⣠⠴⠀⡀⡬⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.
⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠙⠲⠬⢙⣛⡃⣞⣫⠿⠟⠃⠁⣀⡜⠁⠀⠀⢱⠃⠀⢀⠀⠀⠀⠤⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀
⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠉⠒⠀⠀⠒⠀⠢⣌⠉⠀⡀⠀⠀⠀⣴⣿⣿⣶⡶⣤⣀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠰⠀⠀⠀⢀⠀⢠⡀⡇⠀⣠⣾⣿⣿⣿⣿⣿⣿⣿⡿⣿⣴⣦⣤⣀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⢂⠐⣦⡀⠙⠃⣷⠀⠘⠻⠿⣽⣩⠽⢾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣾⣷⣶⣤⡀⠀
⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠐⠄⢀⠀⣀⡿⠀⠀⠀⠀⠀⠉⠑⠂⠬⢟⣛⠿⣯⣙⡿⣿⣿⣽⣏⡿⡿⠁⠀
⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠙⠛⠾⢥⠛⠿⢿⡟⡇⠃⠀⠀.
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠁⠒⠧⠁⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀     .
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀.
.
___________________________                                 ______________________________
                           _________________________________                     
"""

# Fake options
menu = [
    "1. Ping Mars Communication Relay",
    "2. Scan Local Asteroid Field",
    "3. Open Captain’s Logbook",
    "4. Initiate Starboard Diagnostics"
]

# Display interface
print("\n" + art)
print(" 🛰️  Sector-17 Cosmic Command Terminal v1.0")
print("==============================================")
for opt in menu:
    print(" " + opt)
print("==============================================")
print("❗Enter an action number or authorized access key:\n")

# Input attempts
max_attempts = 3
attempts = 0

while attempts < max_attempts:
    choice = input(">> ").strip()

    # Check if input matches password
    if hashlib.sha256(choice.encode()).hexdigest() == correct_hash:
        print("\n✅ Command recognized.")
        print(f"🚀 Uplink Granted — FLAG: {flag}")
        break
    elif choice in ["1", "2", "3", "4"]:
        responses = {
            "1": "📡 Ping sent to Mars Relay... Response time: 73 light-minutes.",
            "2": "🪨 Scanning... No hostile asteroids detected.",
            "3": "📓 Log Entry 4421-A: 'Something’s out there... watching.'",
            "4": "⚙️ Diagnostics nominal. Starboard thrusters fully operational."
        }
        print(responses[choice])
        print()
    else:
        print("❌ Invalid input. Try again.\n")
        attempts += 1

if attempts >= max_attempts:
    print("🚨 Cosmic Anomaly Detected!")
    time.sleep(1)
    print("🛑 Security Override Activated. Locking terminal...")
    time.sleep(1)
    print("🔒 Session Terminated.")
