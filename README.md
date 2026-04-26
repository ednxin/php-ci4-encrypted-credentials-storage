# Credentials Storage Portal

Secure, minimal CodeIgniter 4 application to store highly sensitive client data encrypted at rest. Data is encrypted client-side with a user-provided master key (AES-256-CBC + PBKDF2) and decrypted only when the correct master key is provided at view/edit time.

Key points
- AES-256-CBC encryption via OpenSSL
- PBKDF2 (`hash_pbkdf2('sha256')`) to derive a 256-bit key with strong iteration counts
- Master keys are never persisted
- Role-based access: `super_admin` and regular viewer users
- CSRF/XSS protections enabled; encrypted payloads stored in the database

See the full installation and usage instructions in `INSTALL.md` and `USAGE.md`.

Database schema
- A SQL schema is included at `/db/credentials.sql` for quick import if you prefer to skip migrations.

Typical use cases
- Securely store client records that can contain HTML-rich notes
- Limit which users can access which clients
- Require an ephemeral master key to decrypt sensitive client content

Where to look in the codebase
- Controllers: `app/Controllers/ClientsController.php`, `app/Controllers/UsersController.php`
- Services: `app/Services/EncryptionService.php`
- Models: `app/Models/ClientModel.php`, `app/Models/UserModel.php`, `app/Models/UserClientAccessModel.php`
- Views: `app/Views/clients/*`, `app/Views/auth/*`
- Migrations/Seeders: `app/Database/Migrations/`, `app/Database/Seeds/`

License
See `LICENSE` for license terms.

Questions or issues
Please open an issue on the repository with a clear description and steps to reproduce.
