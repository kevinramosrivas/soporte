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
                <?=base_url('dashboard/admin')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('dashboard/user')?>
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
                        <form action="<?=base_url('passwords/createNewAccountPassword')?>" method="post" id="formNewAccountPassword">
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
                                <label for="inputAdditionaInfo" class="form-label" id ="labelAdditionaInfo">
                                    Información adicional
                                </label>
                                <textarea class="form-control" name="additionalInfo" id="inputAdditionaInfo" rows="3"></textarea>
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
                <a type="button" class="btn btn-danger" href="<?=base_url('passwords/closeTemporarySession')?>">
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
                            <th scope="col">Usuario</th>
                            <th scope="col">+ Información</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($passwords as $password): ?>     
                            <tr  id="rowPassword<?=$password['id_password']?>" class="rowPassword">
                                <td>
                                    <?php if($password['typeAccount'] == 'DATABASE'): ?>
                                        <button type="button" class="btn btn-secondary m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Base de datos de prueba">
                                            <i class="bi bi-database"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'EMAIL'): ?>
                                        <button type="button" class="btn btn-primary m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Correo electrónico">
                                            <i class="bi bi-envelope-fill"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'WIFI'): ?>
                                        <button type="button" class="btn btn-success m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Wifi">
                                            <i class="bi bi-wifi"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'DOMAIN'): ?>
                                        <button type="button" class="btn btn-dark m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Dominio">
                                            <i class="bi bi-globe"></i>
                                        </button>
                                    <?php elseif($password['typeAccount'] == 'OTHER'): ?>
                                        <button type="button" class="btn btn-warning m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Otro">
                                            <i class="bi bi-key-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if($password['level'] == 'ADMINISTRADOR'): ?>
                                        <button type="button" class="btn btn-dark m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Acceso solo para administradores">
                                            <i class="bi bi-person-fill-lock"></i>
                                        </button>
                                    <?php elseif($password['level'] == 'BOLSISTA'): ?>
                                        <button type="button" class="btn btn-info m-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Acceso para bolsistas y administradores">
                                                <i class="bi bi-people-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td><?=$password['accountName']?></td>
                                <td><?=$password['username']?></td>
                                <td>
                                    <!--modal para mostrar informacion adicional-->
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#infoPasswordModal<?=$password['id_password']?>">
                                    <i class="bi bi-info-circle"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="infoPasswordModal<?=$password['id_password']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="infoPasswordModalLabel">Información adicional</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if($password['additionalInfo'] == null):?>
                                                <span class="badge bg-danger">No hay información adicional</span>
                                            <?php endif; ?>
                                            <p id="additionalInfoTable<?=$password['id_password']?>">
                                                <?=$password['additionalInfo']?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--fin modal para mostrar informacion adicional-->
                                </td>
                                <td><input type="password" class="form-control" value="<?=$password['password']?>" readonly id="passwordTable<?=$password['id_password']?>">

                                <td>
                                    <button type="button" class="btn btn-secondary m-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Ver credenciales" onclick="showCredentials('<?=$password['id_password']?>')">
                                        <i class="bi bi-eye" id="iconShowCredentials<?=$password['id_password']?>"></i>
                                    </button>
                                    <?php if($session->type == 'ADMINISTRADOR' || $session->id_user == $password['registrar_id']): ?>
                                        <a href="<?=base_url('passwords/deletePassword/'.$password['id_password'])?>" class="btn btn-danger m-1">
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
                                                <form class="edit-password-form" action="<?=base_url('passwords/editPassword')?>" method="post" id="formEditAccountPassword<?=$password['id_password']?>" onsubmit="return validateEditPassword('<?=$password['id_password']?>')">
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
                                                        <label for="editAdditionalInfoInput<?=$password['id_password']?>" class="form-label">Información adicional</label>
                                                        <textarea class="form-control" name="edit-additional-info" id="editAdditionalInfoInput<?=$password['id_password']?>" rows="3"><?=$password['additionalInfo']?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editPasswordInput<?=$password['id_password']?>"class="form-label">Nueva contraseña</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="editPasswordInput<?=$password['id_password']?>" name="edit-password">
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
                                                        <label for="editConfirmPasswordInput<?=$password['id_password']?>" class="form-label">Confirmar contraseña</label>
                                                        <input type="password" class="form-control" id="editConfirmPasswordInput<?=$password['id_password']?>" name="confirm-password">
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
                                        <!-- fin modal para editar contraseña guardada -->
                                    <?php endif; ?>
                                    <!-- boton para generar qr -->
                                    <button type="button" class="btn btn-dark m-1" data-bs-toggle="modal" data-bs-target="#qrAccountPasswordModal<?=$password['id_password']?>"
                                    <?php if($password['typeAccount'] == 'WIFI'): ?>
                                        onclick="generateQrWifi('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>', '<?=$session->id_user_uuid?>')"
                                    <?php elseif($password['typeAccount'] == 'EMAIL'): ?>
                                        onclick="generateQrEmail('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>' , '<?=$session->id_user_uuid?>')"
                                    <?php elseif($password['typeAccount'] == 'DOMAIN'): ?>
                                        onclick="generateQrDomain('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>' , '<?=$session->id_user_uuid?>')"
                                    <?php elseif($password['typeAccount'] == 'DATABASE'): ?>
                                        onclick="generateQrDatabase('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>' , '<?=$session->id_user_uuid?>')"
                                    <?php elseif($password['typeAccount'] == 'OTHER'): ?>
                                        onclick="generateQrOther('<?=$password['id_password']?>' ,  '<?=$password['username']?>' , '<?=$password['password']?>' , '<?=$password['accountName']?>' , '<?=$session->id_user_uuid?>')"
                                    <?php endif; ?>
                                    >
                                        <i class="bi bi-qr-code"></i>
                                    </button>
                                    <!-- Modal donde se muestra el qr -->
                                    <div class="modal fade" id="qrAccountPasswordModal<?=$password['id_password']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="modalQrTitle<?=$password['id_password']?>">Código QR</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card d-flex justify-content-center align-items-center" id="cardQr<?=$password['id_password']?>">
                                                    <div id="qrcode<?=$password['id_password']?>" class="card-img-top d-flex justify-content-center img-fluid p-4">
                                                    </div>
                                                    <div class="card-body text-center">

                                                        <button type="button" class="btn btn-lg" style="background-color: #70191c; color: white;">
                                                            <?php if($password['typeAccount'] == "DATABASE"): ?>
                                                                <i class="bi bi-database"></i>
                                                            <?php elseif($password['typeAccount'] == "EMAIL"): ?>
                                                                <i class="bi bi-envelope-fill"></i>
                                                            <?php elseif($password['typeAccount'] == "WIFI"): ?>
                                                                <i class="bi bi-wifi"></i>
                                                            <?php elseif($password['typeAccount'] == "DOMAIN"): ?>
                                                                <i class="bi bi-globe"></i>
                                                            <?php elseif($password['typeAccount'] == "OTHER"): ?>
                                                                <i class="bi bi-key-fill"></i>
                                                            <?php endif; ?>
                                                        </button>

                                                        <span class="badge text-bg-warning d-block m-2">
                                                            <h5 class="card-text m-2"><i class="bi bi-qr-code-scan"></i> <i class="bi bi-arrow-up-square-fill"></i> Escanea el código QR</h5>
                                                            <h5 class="card-text m-2">para ver las credenciales</h5>
                                                        </span>
                                                        <span class="fw-bold">Descripción:</span> 
                                                        <p><?=$password['accountName']?></p>
                                                        <span class="fw-bold">
                                                            <?php if($password['typeAccount'] == "DATABASE"): ?>
                                                                Nombre de usuario de la BD:
                                                            <?php elseif($password['typeAccount'] == "EMAIL"): ?>
                                                                Correo electrónico:
                                                            <?php elseif($password['typeAccount'] == "WIFI"): ?>
                                                                Nombre de la red:
                                                            <?php elseif($password['typeAccount'] == "DOMAIN"): ?>
                                                                Nombre del usuario:
                                                            <?php elseif($password['typeAccount'] == "OTHER"): ?>
                                                                Nombre de usuario:
                                                            <?php endif; ?>
                                                        </span>
                                                        <p><?=$password['username']?></p>
                                                        <?php if($password['additionalInfo'] != null):?>
                                                            <span class="fw-bold">Información adicional:</span>
                                                            <p><?=$password['additionalInfo']?></p>
                                                        <?php endif; ?>
                                                        <span class="fw-bold">Contraseña:</span>
                                                        <p><?=$password['password']?></p>
                                                    </div>
                                                    <div class= "card-footer">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-6 d-flex justify-content-center align-items-center">
                                                                    <h6 class="text-center"><?=APP_NAME;?></h6>
                                                                </div>
                                                                <div class="col-6">
                                                                    <canvas id="signatureQr<?=$password['id_password']?>">
                                                                    
                                                                    </canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="spinner-border text-primary d-none" role="status" id="spinnerQr<?=$password['id_password']?>">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                <p class="text-center d-none" id="messageQr<?=$password['id_password']?>">Espere un momento</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary" onclick="downloadQr('cardQr<?=$password['id_password']?>','<?=$password['id_password']?>','<?=$session->id_user?>')"><i class="bi bi-download"></i></button>
                                                <button type="button" class="btn btn-primary" onclick="printQr('cardQr<?=$password['id_password']?>', '<?=$password['id_password']?>', '<?=$session->id_user?>')"><i class="bi bi-printer"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- fin modal donde se muestra el qr -->
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
<script src="<?=base_url('assets/js/libs/html2canvas.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url('assets/js/user/password_manager.js')?>"></script>
<?=$this->endSection()?>