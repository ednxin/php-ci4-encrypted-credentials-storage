<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-soft p-4">
            <h1 class="h4 fw-bold mb-3">Change Password</h1>
            <p class="text-muted">Use a strong password (minimum 10 characters).</p>

            <form method="post" action="<?= site_url('/account/password') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" minlength="10" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="new_password_confirm">Confirm New Password</label>
                    <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" minlength="10" required>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Change Password</button>
                    <a class="btn btn-outline-secondary" href="<?= site_url('/dashboard') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
