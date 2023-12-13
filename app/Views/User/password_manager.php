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
        <div class="row">
            <div class="col-12 col-md-6">
                <!-- boton para crear una nueva contraseña -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAccountPasswordModal">
                <i class="bi bi-key-fill"></i>
                    Crear nueva contraseña
                </button>

                <!-- Modal -->
                <div class="modal fade" id="newAccountPasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Crear nueva contraseña</h1>
                    </div>
                    <div class="modal-body">
                        <form action="<?=base_url('user/createNewAccountPassword')?>" method="post">
                            <label for="account" class="form-label">Tipo de cuenta</label>
                            <div class="mb-3 input-group">
                                <i class="bi input-group-text bg-primary text-white d-none" id="iconTypeAccountSelect">
                                </i>
                                <select class="form-select" name="typeAccount"required onchange="selectAccount()" id ="accountType">
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="DATABASE" data-icon="bi bi-database">Base de datos de prueba</option>
                                    <option value="EMAIL">Correo electrónico</option>
                                    <option value="WIFI">Wifi</option>
                                    <option value="DOMAIN">Dominio</option>
                                    <option value="OTHER">Otro</option>
                                    <option data-content="<i class='fa fa-address-book-o' aria-hidden='true'></i>Option1"></option>
                                </select>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="username" class="form-label" id ="labelCountName">
                                    Descripción de la cuenta
                                </label>
                                <input type="text" class="form-control" name="acountname" id="inputCountName" required>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="username" class="form-label" id ="labelUsername">
                                    Usuario
                                </label>
                                <input type="text" class="form-control" name="username" id="inputUsername" required>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="password" class="form-label" id ="labelPassword">
                                    Contraseña
                                </label>
                                <input type="text" class="form-control" name="password" id="inputPassword" placeholder="********" required>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <input type="submit" class="btn btn-primary" value="Crear">
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-md-6">
                <a type="button" class="btn btn-danger" href="<?=base_url('user/closeTemporarySession')?>">
                    <i class="bi bi-lock-fill"></i> Bloquear gestor
                </a>
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