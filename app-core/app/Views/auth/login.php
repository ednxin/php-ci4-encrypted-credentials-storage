<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card card-soft p-4 p-md-5">
            <div class="text-center mb-3">
                 <img src="<?= base_url('public/images/rect-logo.png') ?>" alt="logo" class="img-fluid" style="max-width:260px; height:auto; object-fit:contain;"/>
                <h1 class="h3 fw-bold mb-3">Sign In</h1>
            </div>
            

            <form method="post" action="<?= base_url('/login') ?>" novalidate>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= esc(old('username')) ?>"
                        class="form-control"
                        maxlength="100"
                        required
                    >
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
