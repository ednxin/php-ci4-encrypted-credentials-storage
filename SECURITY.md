# Security Policy

Responsible disclosure

If you discover a security vulnerability, please open a private issue or contact the repository owner directly. Provide a step-by-step reproduction and the impact.

What we will never do

- Store or transmit master keys. The application is explicitly designed so master keys are not persisted.

Encryption details

- Cipher: AES-256-CBC (OpenSSL)
- Key derivation: PBKDF2 (`hash_pbkdf2('sha256')`) with a high iteration count and per-record salt

Hardening recommendations

- Run the app behind HTTPS
- Use secure cookie flags and appropriate `SameSite` attributes
- Rotate server credentials and limit DB access to the app user
