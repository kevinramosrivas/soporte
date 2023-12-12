<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Gestor de contraseñas
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?php
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
    <section class="section password-manager">
        <div class="d-none" id="dateExpire">
            <?php echo $session->getTempdata('dateExpire') ?>
        </div>
        <div class="row clock">
            <div class="col-12 col-md-6">
                <h5>
                <span class="badge bg-secondary"><i class="bi bi-hourglass-top"></i> Tiempo restante: <p id="MyClockDisplay" class="d-inline"></p></span>
                </h5>
            </div>
        </div>
        <div class="row table-container mt-3 p-3">
            <div class="col-12 table-responsive">
                <?php 
                //inicio de sesion
                $session = session();
                if(session()->getFlashdata('error') || !isset($registerEntryLab)):?>
                    <div class="alert alert-danger" role="alert">
                        <?=session()->getFlashdata('error')?>
                    </div>
                <?php else :?>
                <table class="table table-hover table-striped" id="table-register-entry-lab">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"># doc</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Laboratorio</th>
                            <th scope="col">Entrada</th>
                            <th scope="col">Salida</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($registerEntryLab as $registerEntryLab) : ?>
                            <tr>
                                <td><?=$registerEntryLab['num_doc']?></td>
                                <td><?=$registerEntryLab['type_doc']?></td>
                                <td><?=$registerEntryLab['num_lab']?></td>
                                <td>
                                    <span class="badge text-bg-primary"><?='🗓️ '.date('d-m-Y', strtotime($registerEntryLab['hour_entry']))?></span>
                                    <br>
                                    <span class="badge text-bg-primary"><?='🕛'.date('h:i:s a', strtotime($registerEntryLab['hour_entry']))?></span>
                                </td>
                                <td>
                                <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">No ha salido</span>' : '<span class="badge bg-secondary">🗓️ '.date('d-m-Y', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                                    <br>
                                    <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">No ha salido</span>' : '<span class="badge bg-secondary">🕛 '.date('h:i:s a', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Registrado por: <?=$registerEntryLab['username']?>">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </button>
                                    <?php //si el usuario es de tipo admin mostrale un bton para eliminar el registro
                                    if($session->type == 'ADMINISTRADOR'):?>
                                        <form action="<?=base_url('admin/deleteRegisterEntryLab')?>" method="post" class="d-inline form-delete-register-lab" id="<?=$registerEntryLab['id_prestamo']?>">
                                            <input type="hidden" name="id_prestamo" value="<?=$registerEntryLab['id_prestamo']?>">
                                            <button type="submit" class="btn btn-danger"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Eliminar registro">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach; ?>     
                    </tbody>
                </table>
                <?php endif;?>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="<?=base_url('assets/js/user/password_manager.js')?>">
</script>
<?=$this->endSection()?>