<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Reg. ingreso lab.
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?php
    $session = session(); 
if($session->type == 'ADMINISTRADOR'): ?>
    <?=$this->include('Layouts/navbar_admin')?>
<?php  elseif($session->type == 'BOLSISTA'): ?>
    <?=$this->include('Layouts/navbar_user')?>
<?php  endif; ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Registro de ingreso laboratorio</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
            <?php if($session->type == 'ADMINISTRADOR'): ?>
                <?=base_url('admin/home')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('student/home')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Registro de ingreso</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section register-entry-lab">
    <div class="row p-3">
            <div class="col-12 text-center pb-3 mt-3">
                <!-- modal -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#modalLectorQRBarcodes">
                Abrir lector <i class="bi bi-upc-scan"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalLectorQRBarcodes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Lector</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="reader" width="400px">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-12">
                <form action="<?=site_url('user/registerNewEntryLab')?>" method="post" id="form_register_entry_lab">
                    <div class="row mb-3">
                        <label for="num_laboratorio" class="col-sm-2 col-form-label">Número de laboratorio 💻</label>
                        <div class="col-sm-10">
                            <select name="num_laboratorio" id="num_laboratorio" class="form-select">
                                <option value="1">Laboratorio 1</option>
                                <option value="2">Laboratorio 2</option>
                                <option value="3">Laboratorio 3</option>
                                <option value="4">Laboratorio 4</option>
                                <option value="5">Laboratorio 5</option>
                                <option value="6" selected>Laboratorio 6</option>
                                <option value="7">Laboratorio 7</option>
                                <option value="8">Laboratorio 8</option>
                                <option value="9">Laboratorio 9</option>
                                <option value="10">Laboratorio 10</option>
                                <option value="11">Laboratorio 11</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo de documento 🪪</label>
                        <div class="col-sm-10">
                            <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                <option value="1">DNI</option>
                                <option value="2">Carnet de biblioteca</option>
                                <option value="3" selected>Carnet universitario</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="num_doc" id="documento_id" class="col-sm-2 col-form-label">Número de documento 🔢</label>
                        <div class="col-sm-10">
                            <input type="text" name="numero_documento" id="num_doc" class="form-control" required>
                        </div>
                        <!-- si existen errores mostrarlos -->
                    </div>
                    <?php if (isset(session()->error_num_doc)): ?>
                        <div class="row mb-3">
                            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                <?=session()->error_num_doc?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if (isset(session()->success)): ?>
                        <div class="row mb-3">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?=session()->success?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php endif;?>
                    <div class="row mb-3 text-center mt-3">
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="Registrar">
                        </div>
                    </div>
                </form>
            </div>
    </div>
    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/user/register_lab.js')?>"></script>
<?=$this->endSection()?>

