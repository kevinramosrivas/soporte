<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<div class="container container-login">
    <div class="row row-title">
        <h1>FISI Support</h1>
        <h2 class="text-center">💻🪛🔧</h2>
    </div>
    <div class="row">
        <div class="col-12 col-form">
            <h2 class="text-center">Iniciar Sesión</h1>
            <form action="<?=site_url('login/login')?>" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="bolsista1@unmsm.edu.pe">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="unmsm1234">
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary btn-login">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="footer">
        <p>© 2023 FISI Support</p>
</div>
<?=$this->endSection()?>
