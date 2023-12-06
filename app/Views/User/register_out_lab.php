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
        <h1>Registro de salida laboratorio</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
            <?php if($session->type == 'ADMINISTRADOR'): ?>
                <?=base_url('admin/home')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('student/home')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Registro de salida</li>
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
                    <div id="reader">

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
            <form action="<?=site_url('user/registerNewExitLab')?>" method="post" id="form_register_entry_lab">
                <div class="row mb-3">
                    <label for="num_doc" class="col-sm-2 col-form-label">Número de documento 🔢</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="num_doc" name="num_doc" placeholder="Número de documento" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- si existe un mensaje de error o exito mostrarlo -->
                    <?php if(session()->getFlashdata('error_num_doc')):?>
                        <div class="alert alert-danger" role="alert">
                            <?=session()->getFlashdata('error_num_doc')?>
                        </div>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('success')):?>
                        <div class="alert alert-success" role="alert">
                            <?=session()->getFlashdata('success')?>
                        </div>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('alert_num_doc')):?>
                        <div class="alert alert-warning" role="alert">
                            <?=session()->getFlashdata('alert_num_doc')?>
                        </div>
                    <?php endif;?>
                <div class="row mb-3 text-center mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Registrar salida</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </section>
</main>
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/user/register_lab.js')?>"></script>
<?=$this->endSection()?>

