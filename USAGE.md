# Usage Guide

Overview

This app protects sensitive client data by encrypting content before it is stored. Decryption requires the original master key used to encrypt the client's data.

Common workflows

- Login: Visit `/login`. Use a seeded developer account or create a user via the UI (if enabled).
- List clients: `/clients`
- Create client: `/clients/create` — enter client name, paste or type the client data (supports HTML), supply a master key (not stored), and save.
- Edit client: `/clients/edit/{id}` — you must first `Load Existing` by supplying the correct master key used when the client was created. Only when the server successfully decrypts the stored payload will the edit form appear (the app will not show the edit interface without a verified master key).
- View/decrypt: `/clients/view/{id}` — supply master key to decrypt for viewing.

Roles

- `super_admin`: can manage users and clients
- `viewer` (or other non-admin): limited access according to `user_client_access` mappings

Security notes

- The master key is never logged nor persisted. Always treat master keys as highly sensitive secrets.
- Only provide master keys to the app in trusted environments (do not paste master keys on public terminals).

Troubleshooting

- If you receive a CSRF or SecurityException on POST requests, ensure cookies are enabled in your browser and that `app.baseURL` is correct in `app-core/.env`.
- If decryption fails, confirm you are using the exact master key used to encrypt the client record.
