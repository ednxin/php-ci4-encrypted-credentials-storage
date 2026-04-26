<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4 p-md-5">
    <h1 class="h4 fw-bold mb-4">Create User</h1>

    <form method="post" action="<?= site_url('/users/store') ?>">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="username">Username</label>
                <input id="username" name="username" class="form-control" maxlength="100" value="<?= esc(old('username')) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="role">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="super_admin" <?= old('role') === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="viewer_user" <?= old('role') === 'viewer_user' ? 'selected' : '' ?>>Viewer User</option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Active account</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label" for="client_ids">Client Access Assignments</label>
                <select id="client_ids" name="client_ids[]" class="form-select" multiple size="8">
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc((string) $client['id']) ?>"><?= esc($client['client_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Hold Ctrl/Cmd to select multiple clients.</div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Create User</button>
            <a class="btn btn-outline-secondary" href="<?= site_url('/users') ?>">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
