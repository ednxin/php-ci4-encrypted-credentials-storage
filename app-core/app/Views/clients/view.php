<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-12 col-lg-5">
        <div class="card card-soft p-4 h-100">
            <h1 class="h4 fw-bold mb-3">Client Record</h1>
            <p class="mb-2"><strong>ID:</strong> <?= esc((string) $client['id']) ?></p>
            <p class="mb-3"><strong>Name:</strong> <?= esc($client['client_name']) ?></p>

            <form method="post" action="<?= site_url('/clients/view/' . $client['id'] . '/decrypt') ?>">
                <?= csrf_field() ?>
                <label class="form-label" for="master_key">Master Key Required for Decryption</label>
                <input type="password" id="master_key" name="master_key" class="form-control mb-3" minlength="12" required>
                <button type="submit" class="btn btn-primary">Decrypt Now</button>
                <a class="btn btn-outline-secondary" href="<?= site_url('/clients') ?>">Back</a>
            </form>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card card-soft p-4 h-100">
            <h2 class="h5 fw-bold">Decrypted Data</h2>
            <?php if ($decryptedData !== null): ?>
                <div class="border rounded p-3 bg-white" style="min-height: 220px;">
                    <?= (string) $decryptedData ?>
                </div>
            <?php else: ?>
                <div class="text-muted">No decrypted content yet. Enter a valid master key to view data.</div>
            <?php endif; ?>

            <hr>
            <h3 class="h6 fw-bold">Encrypted Payload (stored)</h3>
            <div class="small text-muted text-break">
                <strong>IV:</strong> <?= esc((string) $client['iv']) ?><br>
                <strong>Data:</strong> <?= esc((string) $client['encrypted_client_data']) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
