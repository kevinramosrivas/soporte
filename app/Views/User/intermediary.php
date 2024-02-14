<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Verificación de identidad
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
                <?=base_url('dashboard/admin')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('dashboard/user')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Gestor de contraseñas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php $session = session(); ?>
    <section class="section profile">
    <div class="row">
        <h2 class="text-center col-12">Verificación de identidad</h2>
    </div>
    <div class="row p-3 d-flex justify-content-center align-items-center">
        <!-- formulario de verificacion de contraseña antes de entrar al gestor de contraseñas -->
        <form class="col-12 col-md-6  text-center" id="formPassword" method="POST" action="<?=base_url('passwords/verifyIdentity')?>">
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Verificar</button>
        </form>
        <div class="col-12 col-md-6 p-4 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="#FFD700" class="bi bi-lock-fill" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
        </svg>
        </div>
        <?php 
        $session = session();
        if(isset($session->error_password_manager)): ?>
            <div class="alert alert-danger" role="alert">
                <?=$session->error_password_manager?>
            </div>
        <?php endif;?>
    </div>
    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
