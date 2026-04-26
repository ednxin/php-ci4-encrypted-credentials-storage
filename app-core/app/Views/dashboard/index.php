<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4 p-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Security Dashboard</h1>
            <p class="text-muted mb-0">Role: <?= esc((string) $role) ?></p>
        </div>
        <a href="<?= site_url('/clients') ?>" class="btn btn-outline-primary">Open Client Module</a>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <div class="small text-muted">Total Users</div>
                <div class="display-6 fw-bold"><?= esc((string) $stats['totalUsers']) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <div class="small text-muted">Total Clients</div>
                <div class="display-6 fw-bold"><?= esc((string) $stats['totalClients']) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <div class="small text-muted">Assigned to You</div>
                <div class="display-6 fw-bold"><?= esc((string) $stats['assigned']) ?></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
