<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Usuarios
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_admin')?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Usuarios inactivos</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/home')?>">Inicio</a></li>
            <li class="breadcrumb-item inactive">Usuarios inactivos</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="row">
        <div class="col-12 container-table table-responsive">
            <?php if(empty($users)): ?>
                <div class="alert alert-warning" role="alert">
                    No hay usuarios inactivos
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
                        <?php foreach ($users as $user) : ?>

                                <tr id="user_<?= $user['id_user'] ?>">
                                    <td>
                                        <span class="badge bg-danger">Inactivo</span>
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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDateDetails<?= $user['id_user'] ?>">
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
                                        <form action="<?=base_url('admin/restoreUser')?>" method="POST" class="d-inline">
                                            <input type="hidden" name="id_user" value="<?=$user['id_user']?>">
                                            <button type="submit" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i></button>
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