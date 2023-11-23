<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">
<?=$this->endSection()?>
<?=$this->section('title')?>
Iniciar sesión
<?=$this->endSection()?>

<?=$this->section('content')?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <span class="d-lg-block d-xl-block text-white ms-2">Sistema de soporte - FISI</span>
                    </div>
                </div><!-- End Logo -->

                <div class="card mb-3">

                <div class="card-body">

                    <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Iniciar sesión</h5>
                    <p class="text-center small">Ingrese sus datos para iniciar sesión</p>
                    </div>

                    <form class="row g-3 needs-validation" action="<?=site_url('login/login')?>" method="post">

                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Email</label>
                        <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Ingrese su email por favor</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                            <!-- un boton con id btn-show-password que muestre la contraseña -->
                            <button type="button" class="btn btn-outline-secondary" id="btn-show-password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="invalid-feedback">Ingrese su contraseña por favor!</div>
                    </div>

                    <div class="col-12 d-none">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                    </div>
                    <div class="col-12 d-none">
                        <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div>
                    <div class="col-12">
                        <?php if(session()->getFlashdata('login_error')):?>
                            <div class="alert alert-danger" role="alert">
                                <?=session()->getFlashdata('login_error')?>
                            </div>
                        <?php endif;?>
                    </div>
                    </form>

                </div>
                </div>

                <div class="credits text-white ms-2">
                    <p>Made by Team soporte FISI © 2023 with <i class="bi bi-heart-fill text-danger"></i></p>
                </div>

            </div>
            </div>
        </div>

        </section>

    </div>
</main><!-- End #main -->

<?=$this->endSection()?>

<?=$this->section('js')?>
    <script src="<?=base_url('assets/js/login/login.js')?>"></script>
<?=$this->endSection()?>
