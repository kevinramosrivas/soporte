<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<div class="container container-login">
    <div class="row row-title">
        <h1>SGST FISI 💻🪛🔧</h1>
    </div>
    <div class="row">
        <div class="col-12 col-form">
            <h2 class="text-center">Iniciar Sesión</h1>
            <form action="<?=site_url('login/login')?>" method="post" id="form-login">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="bolsista1@unmsm.edu.pe" required autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="unmsm1234" required autocomplete="current-password">
                        <button type="button" class="btn btn-outline-secondary" id="btn-show-password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <div class="mb-3">
                    <!-- alerta de usuario si existe login_error -->
                    <?php if(session()->getFlashdata('login_error')):?>
                        <div class="alert alert-danger" role="alert">
                            <?=session()->getFlashdata('login_error')?>
                        </div>
                    <?php endif;?>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary btn-login">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="footer text-center">
        <p>Made by Team soporte FISI © 2023 with ❤️</p>
</div>
<?=$this->endSection()?>

<?=$this->section('js')?>
    <script src="<?=base_url('assets/js/login/login.js')?>"></script>
<?=$this->endSection()?>
