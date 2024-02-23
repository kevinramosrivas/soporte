<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">
<?=$this->endSection()?>
<?=$this->section('title')?>
Consultar Seguimiento
<?=$this->endSection()?>

<?=$this->section('content')?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="container">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <span class="d-lg-block d-xl-block text-white ms-2"><?=APP_NAME;?></span>
                    </div>
                </div><!-- End Logo -->
        <div class="row">
                <div class="col-12">

                    <div class="card">
                        <!-- formulario para buscar tareas -->
                        <div class="card-body p-4">
                            <form action="<?=base_url('tasks/searchMyUuid')?>" method="post">
                                <label for="taskCode" class="form-label">Código de seguimiento</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="taskCode" name="taskCode" required>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </form>
                        </div>           
                    </div>

                    <?php 
                    $session = session();
                    $error = $session->getFlashdata('error');
                    if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$error?>
                        </div>
                    <?php endif; ?>

                    <div class="credits text-white text-center ms-2">
                        <p>© UEI FISI - UNMSM 2023</p>
                        <p>v 1.0</p>
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
