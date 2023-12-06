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
        <h1>Mi perfil</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
            <?php if($session->type == 'ADMINISTRADOR'): ?>
                <?=base_url('admin/home')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('student/home')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Mi perfil</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php $session = session(); ?>
    <section class="section profile">
    <div class="row p-3">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Información</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambiar contraseña</button>
                    </li>
                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Detalles de la cuenta</h5>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Nombre de usuario</div>
                            <div class="col-lg-9 col-md-8"><?=$session->username;?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Tipo de usuario</div>
                            <div class="col-lg-9 col-md-8"><?=$session->type;?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8"><?=$session->email;?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Estado</div>
                            <div class="col-lg-9 col-md-8">
                                <?php if($session->user_status == 1): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form action="<?=base_url('user/updateProfile')?>" method="post" id="formChangePassword">

                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña actual</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="password" type="password" class="form-control" id="currentPassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva contraseña</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar nueva contraseña</label>
                            <div class="col-md-8 col-lg-9">
                            <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                        </div>
                        </form><!-- End Change Password Form -->
                    </div>

                </div><!-- End Bordered Tabs -->

            </div>
        </div>
        <?php if(isset($session->error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?=$session->error?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif(isset($session->success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?=$session->success?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/user/profile.js')?>"></script>
<?=$this->endSection()?>

