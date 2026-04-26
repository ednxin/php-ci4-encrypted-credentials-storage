<?php

namespace App\Services;

use RuntimeException;

class EncryptionService
{
    private const CIPHER = 'AES-256-CBC';
    private const PBKDF2_ITERATIONS = 150000;

    public function deriveKey(string $masterKey, string $salt): string
    {
        if ($masterKey === '') {
            throw new RuntimeException('Master key is required.');
        }

        if ($salt === '') {
            throw new RuntimeException('Salt is required for key derivation.');
        }

        return hash_pbkdf2(
            'sha256',
            $masterKey,
            $salt,
            self::PBKDF2_ITERATIONS,
            32,
            true
        );
    }

    public function encrypt(string $plainText, string $masterKey): array
    {
        if ($plainText === '') {
            throw new RuntimeException('Client data cannot be empty.');
        }

        $salt   = random_bytes(32);
        $ivSize = openssl_cipher_iv_length(self::CIPHER);

        if ($ivSize === false || $ivSize <= 0) {
            throw new RuntimeException('Unable to determine IV length for cipher.');
        }

        $iv  = random_bytes($ivSize);
        $key = $this->deriveKey($masterKey, $salt);

        $cipherRaw = openssl_encrypt($plainText, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

        if ($cipherRaw === false) {
            throw new RuntimeException('Encryption failed.');
        }

        return [
            'ciphertext' => base64_encode($cipherRaw),
            'iv'         => base64_encode($iv),
            'salt'       => base64_encode($salt),
        ];
    }

    public function decrypt(string $cipherText, string $masterKey, string $iv, ?string $salt = null): string
    {
        $decodedIv         = base64_decode($iv, true);
        $decodedCipherText = base64_decode($cipherText, true);

        if ($decodedIv === false || $decodedCipherText === false) {
            throw new RuntimeException('Stored encrypted data is invalid.');
        }

        // Backward-safe fallback for records encrypted with application-level salt.
        $resolvedSalt = $salt !== null ? base64_decode($salt, true) : false;
        if ($resolvedSalt === false || $resolvedSalt === null) {
            $resolvedSalt = (string) env('encryption.salt', 'change-this-global-salt');
        }

        $key = $this->deriveKey($masterKey, $resolvedSalt);
        $raw = openssl_decrypt($decodedCipherText, self::CIPHER, $key, OPENSSL_RAW_DATA, $decodedIv);

        if ($raw === false) {
            throw new RuntimeException('Decryption failed. Invalid master key or corrupted data.');
        }

        return $raw;
    }
}
