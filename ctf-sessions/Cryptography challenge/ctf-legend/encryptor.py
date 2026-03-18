# encryptor.py
ALPHABET = "abcdefghijklmnopqrstuvwxyz_{}"

def encrypt(message):
    encrypted = ""
    for i, char in enumerate(message):
        if char not in ALPHABET:
            raise ValueError(f"Character '{char}' not in ALPHABET.")
        idx = ALPHABET.index(char)
        new_idx = (idx + i) % len(ALPHABET)
        encrypted += ALPHABET[new_idx]
    return encrypted

# Example usage
message = "csc{easy_flag}"
encrypted = encrypt(message)
print("Encrypted Message:", encrypted)
