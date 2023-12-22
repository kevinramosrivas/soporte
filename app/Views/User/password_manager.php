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
            <div class="col-12 col-md-6 p-2">
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
                        <form action="<?=base_url('user/createNewAccountPassword')?>" method="post" id="formNewAccountPassword">
                            <label for="accountType" class="form-label">Tipo de cuenta</label>
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
                                <label for="inputCountName" class="form-label" id ="labelCountName">
                                    Descripción de la cuenta
                                </label>
                                <input type="text" class="form-control" name="acountname" id="inputCountName" required>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="inputUsername" class="form-label" id ="labelUsername">
                                    Usuario
                                </label>
                                <input type="text" class="form-control" name="username" id="inputUsername" required>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="inputPassword" class="form-label" id ="labelPassword">
                                    Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="inputPassword" required>
                                    <button class="btn btn-outline-secondary" type="button" id="buttonShowPassword" onclick="showPassword()">
                                        <i class="bi bi-eye-fill" id="iconShowPassword"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Generar contraseña" onclick="generatePassword()">
                                        <i class="bi bi-magic"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 inputFormAccount d-none">
                                <label for="inputLevel" class="form-label" id ="labelLevel">
                                    Nivel de autorización
                                </label>
                                <select class="form-select" name="level" id ="inputLevel">
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="ADMINISTRADOR">Administrador</option>
                                    <option value="BOLSISTA">Bolsista y administrador</option>
                                </select>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Crear" form="formNewAccountPassword">
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-md-6 p-2">
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
                if(session()->getFlashdata('no_records_password_manager') || !isset($passwords)):?>
                    <div class="alert alert-danger" role="alert">
                        <?=session()->getFlashdata('no_records_password_manager')?>
                    </div>
                <?php else :?>
                <table class="table table-hover table-striped" id="table-passwords">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Nivel de autorización</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($passwords as $password): ?>     
                            <tr  id="rowPassword<?=$password['id_password']?>" class="rowPassword">
                                <td>
                                    <?php if($password['typeAccount'] == 'DATABASE'): ?>
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Base de datos de prueba">
                                            <i class="bi bi-database"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'EMAIL'): ?>
                                        <button type="button" class="btn btn-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Correo electrónico">
                                            <i class="bi bi-envelope-fill"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'WIFI'): ?>
                                        <button type="button" class="btn btn-success"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Wifi">
                                            <i class="bi bi-wifi"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'DOMAIN'): ?>
                                        <button type="button" class="btn btn-dark"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Dominio">
                                            <i class="bi bi-globe"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'OTHER'): ?>
                                        <button type="button" class="btn btn-alert"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Otro">
                                            <i class="bi bi-file-earmark"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td><?=$password['accountName']?></td>
                                <td><?=$password['level']?></td>
                                <td><?=$password['username']?></td>
                                <td><input type="password" class="form-control" value="<?=$password['password']?>" readonly id="password<?=$password['id_password']?>"></td>
                                <td>
                                    <button type="button" class="btn btn-secondary m-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Ver credenciales" onclick="showCredentials('<?=$password['id_password']?>')">
                                        <i class="bi bi-eye" id="iconShowCredentials<?=$password['id_password']?>"></i>
                                    </button>
                                    <?php if($session->type == 'ADMINISTRADOR' || $session->id_user == $password['registrar_id']): ?>
                                        <a href="<?=base_url('user/deletePassword/'.$password['id_password'])?>" class="btn btn-danger m-1">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    <?php endif; ?> 
                                    <?php
                                    //si el usuario es el que creo la contraseña o es administrador
                                    if($session->id_user == $password['registrar_id'] || $session->type == 'ADMINISTRADOR'):?>
                                     <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editAccountPasswordModal<?=$password['id_password']?>">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editAccountPasswordModal<?=$password['id_password']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar contraseña</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- formulario para editar contraseña guardada -->
                                                <form class="edit-password-form" action="<?=base_url('user/editPassword')?>" method="post" id="formEditAccountPassword<?=$password['id_password']?>">
                                                    <input type="hidden" name="id_password" value="<?=$password['id_password']?>">
                                                    <div class="mb-3">
                                                        <label for="editAccountTypeInput<?=$password['id_password']?>" class="form-label">Tipo de cuenta</label>
                                                        <select class="form-select" name="edit-account-type" id="editAccountTypeInput<?=$password['id_password']?>">
                                                            <option value="" selected>Seleccione una opción</option>
                                                            <option value="DATABASE" <?php if($password['typeAccount'] == 'DATABASE'): ?> selected <?php endif; ?>>Base de datos de prueba</option>
                                                            <option value="EMAIL" <?php if($password['typeAccount'] == 'EMAIL'): ?> selected <?php endif; ?>>Correo electrónico</option>
                                                            <option value="WIFI" <?php if($password['typeAccount'] == 'WIFI'): ?> selected <?php endif; ?>>Wifi</option>
                                                            <option value="DOMAIN" <?php if($password['typeAccount'] == 'DOMAIN'): ?> selected <?php endif; ?>>Dominio</option>
                                                            <option value="OTHER" <?php if($password['typeAccount'] == 'OTHER'): ?> selected <?php endif; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editAccountNameInput<?=$password['id_password']?>" class="form-label">Descripción de la cuenta</label>
                                                        <input type="text" class="form-control"  name="edit-account-name" value="<?=$password['accountName']?>" id="editAccountNameInput<?=$password['id_password']?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editUsernameInput<?=$password['id_password']?>" class="form-label">Usuario</label>
                                                        <input type="text" class="form-control" name="edit-username" value="<?=$password['username']?>" id="editUsernameInput<?=$password['id_password']?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editLevelInput<?=$password['id_password']?>" class="form-label">Nivel de autorización</label>
                                                        <select class="form-select" name="edit-level" id="editLevelInput<?=$password['id_password']?>">
                                                            <option value="" selected>Seleccione una opción</option>
                                                            <option value="ADMINISTRADOR" <?php if($password['level'] == 'ADMINISTRADOR'): ?> selected <?php endif; ?>>Administrador</option>
                                                            <option value="BOLSISTA" <?php if($password['level'] == 'BOLSISTA'): ?> selected <?php endif; ?>>Bolsista y administrador</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-password<?=$password['id_password']?>"class="form-label">Nueva contraseña</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="edit-password<?=$password['id_password']?>" name="edit-password">
                                                            <button class="btn btn-outline-secondary" type="button"  onclick="showEditPassword('<?=$password['id_password']?>')">
                                                                <i class="bi bi-eye-fill" id="iconShowPassword<?=$password['id_password']?>"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-primary"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-custom-class="custom-tooltip"
                                                                        data-bs-title="Generar contraseña" onclick="generateEditPassword('<?=$password['id_password']?>')">
                                                                <i class="bi bi-magic"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="confirm-password<?=$password['id_password']?>" class="form-label">Confirmar contraseña</label>
                                                        <input type="password" class="form-control" id="confirm-password<?=$password['id_password']?>" name="confirm-password">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <input type="submit" class="btn btn-primary" value="Guardar" form="formEditAccountPassword<?=$password['id_password']?>">
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    <?php endif; ?>
                                    <!-- boton para generar qr -->
                                    <button type="button" class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#qrAccountPasswordModal<?=$password['id_password']?>"
                                    <?php if($password['typeAccount'] == 'WIFI'): ?>
                                        onclick="generateQrWifi('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>')"
                                    <?php elseif($password['typeAccount'] == 'EMAIL'): ?>
                                        onclick="generateQrEmail('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>')"
                                    <?php elseif($password['typeAccount'] == 'DOMAIN'): ?>
                                        onclick="generateQrDomain('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>')"
                                    <?php elseif($password['typeAccount'] == 'DATABASE'): ?>
                                        onclick="generateQrDatabase('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>')"
                                    <?php elseif($password['typeAccount'] == 'OTHER'): ?>
                                        onclick="generateQrOther('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>')"
                                    <?php endif; ?>
                                    >
                                        <i class="bi bi-qr-code"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="qrAccountPasswordModal<?=$password['id_password']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="modalQrTitle<?=$password['id_password']?>">Código QR</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card d-flex justify-content-center align-items-center">
                                                <div id="qrcode<?=$password['id_password']?>" class="card-img-top d-flex justify-content-center img-fluid p-4">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title text-center"><?=$password['typeAccount']?></h5>
                                                    <p class="card-text"><span class="badge bg-primary">Escanea el código QR para ver las credenciales</span></p>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><span class="fw-bold">Descripción:</span> <?=$password['accountName']?></li>
                                                    <li class="list-group-item"><span class="fw-bold">Usuario:</span> <?=$password['username']?></li>
                                                    <li class="list-group-item"><span class="fw-bold">Contraseña:</span> <?=$password['password']?></li>
                                                </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary" onclick="downloadQr('qrcode<?=$password['id_password']?>' , '<?=$password['accountName']?>')">Descargar</button>
                                            </div>
                                    </div>
                                    </div>

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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="<?=base_url('assets/js/libs/qrcode.js')?>"></script>
<script src="<?=base_url('assets/js/user/password_manager.js')?>"></script>
<?=$this->endSection()?>