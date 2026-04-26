# Contributing

Thanks for your interest in contributing. Please follow these guidelines to keep the project healthy and reviewable.

Process

1. Fork the repository and create a topic branch.
2. Run tests and linters (if present) locally.
3. Keep commits focused and well-described.
4. Open a pull request describing the problem and your proposed solution.

Code style

- Follow existing coding conventions in the repo (PSR-12 for PHP code where applicable).
- Keep templates and front-end assets readable and accessible.

Tests

- Add unit or integration tests when touching encryption, key derivation routines, or access-control checks.

Security-sensitive changes

- Any change that affects encryption, key handling, persistence, or authentication MUST include a security rationale and tests demonstrating behavior.
