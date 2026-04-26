<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 fw-bold mb-0">Clients</h1>
        <?php if ($role === 'super_admin'): ?>
            <a href="<?= site_url('/clients/create') ?>" class="btn btn-primary">Create Client</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Last Updated</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= esc((string) $client['id']) ?></td>
                    <td><?= esc($client['client_name']) ?></td>
                    <td><?= esc((string) ($client['updated_at'] ?? 'N/A')) ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="<?= site_url('/clients/view/' . $client['id']) ?>">View</a>
                        <?php if ($role === 'super_admin'): ?>
                            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('/clients/edit/' . $client['id']) ?>">Edit</a>
                            <form class="d-inline" method="post" action="<?= site_url('/clients/delete/' . $client['id']) ?>" onsubmit="return confirm('Delete this client?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
