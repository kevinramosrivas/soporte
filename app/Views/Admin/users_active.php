<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Usuarios
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_admin')?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Usuarios</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/home')?>">Inicio</a></li>
            <li class="breadcrumb-item inactive">Usuarios</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="row p-4">
        <div class="col-12 d-flex justify-content-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNewUser">
            Crear usuario <i class="bi bi-person-plus-fill"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalNewUser" tabindex="-1" aria-labelledby="modalNewUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Creción de usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?=base_url('admin/registerUser')?>" method="post" id="formNewUser">
                        <div class="mb-3">
                            <label for="type_user" class="form-label">Tipo de usuario</label>
                            <select name="type" id="type_user" class="form-select" required>
                                <option value="ADMINISTRADOR">Administrador</option>
                                <option value="BOLSISTA">Bolsista</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_username_create" id="name_id" class="form-label">Nombre y Apellido</label>
                            <input type="text" name="username" id="id_username_create" class="form-control" required autocomplete="on">
                        </div>
                        <div class="mb-3">
                            <label for="id_email_create" id="email_id" class="form-label">Correo</label>
                            <div class="input-group">
                                <input type="text" name="email" id="id_email_create" class="form-control" required autocomplete="on">
                                <!-- añadir el @unmsm.edu.pe -->
                                <span class="input-group-text">@unmsm.edu.pe</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="id_password_create" id="password_id">Contraseña</label>
                            <!-- hacer un input con un boton para revelar la contraseña -->
                            <div class="input-group">
                                <input type="password" name="password" id="id_password_create" class="form-control" required autocomplete="on">
                                <button class="btn btn-primary btn_toggle_input_password" type="button" id="button_password" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar contraseña">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <?php 
                        //iniciar la sesion para mostrar los errores de validacion
                        $sesion = session();
                        if ($sesion->getFlashdata('error')) : ?>
                        <div class="mb-3">
                            <div class="alert alert-danger">
                                <?= $sesion->getFlashdata('error') ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Registrar" form="formNewUser">
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 container-table table-responsive">
        <?php if(empty($users)): ?>
                <div class="alert alert-warning" role="alert">
                    No hay usuarios activos
                </div>
            <?php else: ?>	
            <table class="table table-striped table-hover text-start" id="table_users">
                <thead>
                    <tr>
                        <th scope="col">Estado</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Correo electronico</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) : ?>
                        <tr id="user_<?= $user['id_user'] ?>">
                            <td>
                                <?php if ($user['user_status'] == 1) : ?>
                                    <span class="badge bg-primary">Activo</span>
                                <?php else : ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            <td>
                                <?= $user['username'] ?>
                            </td>
                            <td>
                                <?php if ($user['type'] == 'ADMINISTRADOR') : ?>
                                    <span class="badge bg-dark">Administrador</span>
                                <?php else : ?>
                                    <span class="badge bg-primary">Bolsista</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $user['email'] ?>
                            </td>
                            <!-- separar la fecha y hora -->
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#modalDateDetails<?= $user['id_user'] ?>">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="modalDateDetails<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="modalDateDetailsLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalDateDetailsLabel">Detalles del usuario</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>Estado: <span class="badge bg-primary"><?= $user['user_status'] == 1 ? 'Activo' : 'Inactivo' ?></span></h6>
                                            <h6>Fecha de creación: <span class="badge text-bg-dark"><?= date('d/m/Y h:i:s a', strtotime($user['created_at'])) ?></span></h6>
                                            <h6>Fecha de actualización: <span class="badge text-bg-success"><?= date('d/m/Y h:i:s a', strtotime($user['updated_at'])) ?></span></h6>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editUser_<?= $user['id_user'] ?>">
                                    <i class="bi bi-pencil-square"></i>     
                                </button>
                                <!-- Modal for edit user -->
                                <div class="modal fade" id="editUser_<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="editUser_<?= $user['id_user'] ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar usuario</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                                <form action="<?=base_url('admin/editUser')?>" method="post" id="formEditUser_<?= $user['id_user'] ?>" class="edit_user_form">
                                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                    <div class="mb-3">
                                                        <label for="type_user_<?= $user['id_user']?>" class="form-label">Tipo de usuario</label>
                                                        <select name="type" id="type_user_<?= $user['id_user']?>" class="form-select" required>
                                                            <option value="ADMINISTRADOR" <?php if ($user['type'] == 'ADMINISTRADOR') : ?> selected <?php endif; ?>>Administrador</option>
                                                            <option value="BOLSISTA" <?php if ($user['type'] == 'BOLSISTA') : ?> selected <?php endif; ?>>Bolsista</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="estado_id_<?= $user['id_user']?>" class="form-label">Estado</label>
                                                        <select name="user_status" id="estado_id_<?= $user['id_user']?>" class="form-select" required>
                                                            <option value="1" <?php if ($user['user_status'] == 1) : ?> selected <?php endif; ?>>Activo</option>
                                                            <option value="0" <?php if ($user['user_status'] == 0) : ?> selected <?php endif; ?>>Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name_id_<?= $user['id_user']?>" class="form-label">Nombre y Apellido</label>
                                                        <input type="text" name="username" id="name_id_<?= $user['id_user']?>" class="form-control" value="<?= $user['username'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email_id_<?= $user['id_user']?>" class="form-label">Correo</label>
                                                        <input type="email" name="email" id="email_id_<?= $user['id_user']?>" class="form-control" value="<?= $user['email'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="input_password_<?= $user['id_user']?>">Contraseña</label>
                                                        <!-- hacer un input con un boton para revelar la contraseña -->
                                                        <div class="input-group">
                                                            <input type="password" name="password" id="input_password_<?= $user['id_user']?>" class="form-control">
                                                            <button class="btn btn-primary btn_toggle_input_password" type="button" id="button_password<?= $user['id_user']?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar contraseña">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary" form="formEditUser_<?= $user['id_user'] ?>">Guardar cambios</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-danger btn-delete m-1" form="deleteUser_<?= $user['id_user'] ?>"><i class="bi bi-trash"></i></button>
                                <form id="deleteUser_<?= $user['id_user'] ?>" action="<?= base_url('admin/userDelete') ?>" method="post" class="delete_form d-inline">
                                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                </form>      
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
<script src="<?=base_url('assets/js/admin/users.js')?>"></script>
<?=$this->endSection()?>