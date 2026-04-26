<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 fw-bold mb-0">User Management</h1>
        <a href="<?= site_url('/users/create') ?>" class="btn btn-primary">Create User</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Assigned Clients</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <?php
                    $assignedNames = [];
                    $ids = $accessMap[(int) $user['id']] ?? [];
                    foreach ($clients as $client) {
                        if (in_array((int) $client['id'], $ids, true)) {
                            $assignedNames[] = $client['client_name'];
                        }
                    }
                ?>
                <tr>
                    <td><?= esc((string) $user['id']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td><span class="badge text-bg-secondary"><?= esc($user['role']) ?></span></td>
                    <td><?= (int) $user['is_active'] === 1 ? 'Active' : 'Disabled' ?></td>
                    <td><?= esc($assignedNames !== [] ? implode(', ', $assignedNames) : 'No assignments') ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="<?= site_url('/users/edit/' . $user['id']) ?>">Edit</a>
                        <form class="d-inline" method="post" action="<?= site_url('/users/delete/' . $user['id']) ?>" onsubmit="return confirm('Delete this user?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
