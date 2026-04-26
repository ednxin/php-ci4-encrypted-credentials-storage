<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Secure Client Manager') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-1: #0f766e;
            --brand-2: #155e75;
            --accent: #f59e0b;
            --bg-soft: #f5f7fb;
            --ink: #0b1220;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Manrope', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            color: var(--ink);
            background: var(--bg-soft);
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            background: linear-gradient(120deg, var(--brand-2) 0%, var(--brand-1) 100%);
            box-shadow: 0 6px 18px rgba(2,6,23,0.12);
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff !important;
        }

        .navbar .nav-link:hover {
            color: rgba(255,255,255,0.9) !important;
        }

        .btn-warning {
            background: var(--accent);
            border-color: rgba(0,0,0,0.06);
            color: #0b1220;
        }

        .card-soft {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.06);
            background: #fff;
        }

        .content-wrap {
            padding-top: 1rem;
        }
    </style>
</head>
<body>
<?php if (session()->get('logged_in')): ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container py-1">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('/dashboard') ?>">
                 <img src="<?= base_url('public/images/round-logo.png') ?>" alt="logo" class="me-2" style="width:36px;height:36px;object-fit:cover;border-radius:50%;" />
                Encrypted Credential Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-2 mt-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/clients') ?>">Clients</a></li>
                    <?php if (session()->get('role') === 'super_admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('/users') ?>">Users</a></li>
                    <?php endif; ?>
                    <li class="nav-item text-white-50 small px-lg-2">
                        <?= esc((string) session()->get('username')) ?> (<?= esc((string) session()->get('role')) ?>)
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/account/password') ?>">Change Password</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-warning" href="<?= site_url('/logout') ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>

<main class="container my-4 my-md-5 content-wrap">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc((string) session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc((string) session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
