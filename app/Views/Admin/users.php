<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/home.css')?>">
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_admin')?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center p-3">Usuarios</h1>
        </div>
    </div>
    <div class="row p-4">
        <div class="col-6 d-flex justify-content-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNewUser">
            Crear usuario
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
                                <option value="admin">Administrador</option>
                                <option value="user">Bolsista</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" id="name_id">Nombre y Apellido</label>
                            <input type="text" name="username" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" id="email_id">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" id="password_id">Contraseña</label>
                            <!-- hacer un input con un boton para revelar la contraseña -->
                            <div class="input-group">
                                <input type="password" name="password" id="input_password" class="form-control" required>
                                <button class="btn btn-primary btn_toggle_input_password" type="button" id="button_password" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar contraseña">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
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
            <table class="table table-striped table-hover text-start">
                <thead>
                    <tr>
                        <th scope="col" class="d-none">ID</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) : ?>
                        <tr id="user_<?= $user['id_user'] ?>">
                            <form id="deleteUser_<?= $user['id_user'] ?>" action="<?= base_url('admin/userDelete') ?>" method="post" class="delete_form">
                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                            </form>
                            <td>
                                <?php if ($user['type'] == 'admin') : ?>
                                    <button class="btn btn-dark">
                                    <i class="bi bi-person-fill-gear"></i>
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-primary">
                                        <i class="bi bi-person-circle"></i>
                                    </button>
                                <?php endif; ?>
                            <td><?= $user['username'] ?></td>
                            <!-- separar la fecha y hora -->
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDateDetails<?= $user['id_user'] ?>">
                                    <i class="bi bi-plus-lg"></i>
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
                                        <h6>Tipo de usuario: <?php if ($user['type'] == 'admin') : ?>
                                            <span class="badge bg-dark">Administrador</span>
                                        <?php else : ?>
                                            <span class="badge bg-primary">Bolsista</span>
                                        <?php endif; ?></h6>
                                        <h6>Correo electronico: <span class="badge text-bg-dark"><?= $user['email'] ?></span></h6>
                                        <h6>Fecha de creación: <span class="badge text-bg-dark"><?= date('d/m/Y h:i:s a', strtotime($user['created_at'])) ?></span></h6>
                                        <h6>Fecha de actualización: <span class="badge text-bg-success"><?= date('d/m/Y h:i:s a', strtotime($user['updated_at'])) ?></span></h6>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td>
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
                                                    <label for="type_user" class="form-label">Tipo de usuario</label>
                                                    <select name="type" id="type_user" class="form-select" required>
                                                        <option value="admin" <?php if ($user['type'] == 'admin') : ?> selected <?php endif; ?>>Administrador</option>
                                                        <option value="user" <?php if ($user['type'] == 'user') : ?> selected <?php endif; ?>>Bolsista</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" id="name_id" class="form-label">Nombre y Apellido</label>
                                                    <input type="text" name="username" id="name" class="form-control" value="<?= $user['username'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" id="email_id" class="form-label">Correo</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" id="password_id" class="form-label">Nueva Contraseña</label>
                                                    <!-- hacer un input con un boton para revelar la contraseña -->
                                                    <div class="input-group">
                                                        <input type="password" name="password" id="input_password<?= $user['id_user']?>" class="form-control">
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
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="<?=base_url('assets/js/admin/users.js')?>"></script>
<?=$this->endSection()?>