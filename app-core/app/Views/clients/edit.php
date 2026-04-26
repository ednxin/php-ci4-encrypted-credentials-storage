<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4 p-md-5">
    <h1 class="h4 fw-bold mb-4">Edit Client</h1>
    <p class="text-muted">You may load the existing encrypted data by providing the master key, then edit and re-encrypt.</p>

    <div class="mb-3">
        <form method="post" action="<?= site_url('/clients/load/' . $client['id']) ?>" class="d-flex gap-2">
            <?= csrf_field() ?>
            <input type="password" id="load_master_key" name="master_key" class="form-control" placeholder="Enter master key to load existing data" minlength="12" required>
            <button class="btn btn-outline-primary" type="submit">Load Existing</button>
        </form>
    </div>

    <?php $hasDecrypted = (old('client_data') !== null) || (isset($decryptedData) && $decryptedData !== null); ?>

    <?php if ($hasDecrypted): ?>
    <form method="post" action="<?= site_url('/clients/update/' . $client['id']) ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label" for="client_name">Client Name</label>
            <input id="client_name" name="client_name" class="form-control" maxlength="191" value="<?= esc(old('client_name', $client['client_name'])) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="client_data">Updated Client Data</label>
            <textarea id="client_data" name="client_data" class="form-control" rows="10" required><?php if (old('client_data') !== null) { echo old('client_data'); } elseif (isset($decryptedData) && $decryptedData !== null) { echo $decryptedData; } ?></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label" for="master_key">Master Key (not stored)</label>
            <input type="password" id="master_key" name="master_key" class="form-control" minlength="12" required>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Re-encrypt & Save</button>
            <a class="btn btn-outline-secondary" href="<?= site_url('/clients') ?>">Cancel</a>
        </div>
    </form>
    <?php else: ?>
    <div class="alert alert-info">Provide the master key above to load the existing encrypted client data before editing.</div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    if (document.getElementById('client_data')) {
        CKEDITOR.replace('client_data', {
            height: 320,
            removePlugins: 'elementspath',
            toolbar: [
                { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                { name: 'styles', items: [ 'Format' ] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
                { name: 'paragraph', items: [ 'NumberedList','BulletedList' ] },
                { name: 'links', items: [ 'Link','Unlink' ] },
                { name: 'insert', items: [ 'Table' ] },
                { name: 'tools', items: [ 'Maximize' ] }
            ],
        });
    }
</script>
<?= $this->endSection() ?>
