<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card card-soft p-4 p-md-5">
    <h1 class="h4 fw-bold mb-4">Create Client</h1>

    <form method="post" action="<?= site_url('/clients/store') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label" for="client_name">Client Name</label>
            <input id="client_name" name="client_name" class="form-control" maxlength="191" value="<?= esc(old('client_name')) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="client_data">Client Data</label>
            <textarea id="client_data" name="client_data" class="form-control" rows="10" required><?= esc(old('client_data')) ?></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label" for="master_key">Master Key (not stored)</label>
            <input type="password" id="master_key" name="master_key" class="form-control" minlength="12" required>
            <div class="form-text">This key is used only for runtime encryption and is never persisted.</div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Encrypt & Save</button>
            <a class="btn btn-outline-secondary" href="<?= site_url('/clients') ?>">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
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
</script>
<?= $this->endSection() ?>
