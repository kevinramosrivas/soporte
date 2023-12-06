<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Mi perfil
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
        <h1>Gestor de contraseñas</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
            <?php if($session->type == 'ADMINISTRADOR'): ?>
                <?=base_url('admin/home')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('student/home')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Gestor de contraseñas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php $session = session(); ?>
    <section class="section profile">
    <div class="row p-3">
    </div>
    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/user/profile.js')?>"></script>
<?=$this->endSection()?>