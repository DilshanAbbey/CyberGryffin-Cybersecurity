import sys

ALPHABET = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_{}"

def encrypt(message):
    encrypted = ""
    for i, char in enumerate(message):
        if char not in ALPHABET:
            raise ValueError(f"Character '{char}' not in ALPHABET.")
        idx = ALPHABET.index(char)
        new_idx = (idx + i) % len(ALPHABET)
        encrypted += ALPHABET[new_idx]
    return encrypted

if len(sys.argv) != 2:
    print(f"Usage: python3 {sys.argv[0]} <input_file>")
    sys.exit(1)

filename = sys.argv[1]

try:
    with open(filename, 'r') as f:
        message = f.read().strip()
except FileNotFoundError:
    print(f"[!] File '{filename}' not found.")
    sys.exit(1)

try:
    encrypted = encrypt(message)
    print("Encrypted Message:", encrypted)
except ValueError as ve:
    print(f"[!] Encryption error: {ve}")
