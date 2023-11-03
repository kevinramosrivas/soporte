<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/home.css')?>">
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_admin')?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Bienvenido al sistema de soporte de la FISI</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
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
                            <input type="password" name="password" id="password" class="form-control" required>
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
        <div class="col-6">
            <button type="button" class="btn btn-danger">Eliminar usuarios</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 container-table">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Seleccionar</th>
                        <th scope="col">Tipo de usuario</th>
                        <th scope="col">Nombre y Apellido</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Actualizado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $user) : ?>
                        <tr id="user_<?= $user['id_user'] ?>">
                            <td><input type="checkbox" name="user_<?= $user['id_user'] ?>" id="user_<?= $user['id_user'] ?>"></td>
                            <td class="d-none"><?= $user['id_user'] ?></td>
                            <td><?= $user['type'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td><?= $user['updated_at'] ?></td>
                            <td>
							    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?=$this->endSection()?>