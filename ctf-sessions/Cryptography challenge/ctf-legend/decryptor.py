# decryptor.py
ALPHABET = "abcdefghijklmnopqrstuvwxyz_{}"

def decrypt(encrypted):
    decrypted = ""
    for i, char in enumerate(encrypted):
        if char not in ALPHABET:
            raise ValueError(f"Character '{char}' not in ALPHABET.")
        idx = ALPHABET.index(char)
        orig_idx = (idx - i) % len(ALPHABET)
        decrypted += ALPHABET[orig_idx]
    return decrypted

# Example usage
encrypted = "cte{ig_yitmeq}"
print("Decrypted Message:", decrypt(encrypted))
