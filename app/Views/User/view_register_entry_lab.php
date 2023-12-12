<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Reg. ingreso lab.
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
        <h1>Registro de pretamo de laboratorio</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
            <?php if($session->type == 'ADMINISTRADOR'): ?>
                <?=base_url('admin/home')?>
            <?php  elseif($session->type == 'BOLSISTA'): ?>
                <?=base_url('student/home')?>
            <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive">Registro de prestamo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section register-entry-lab">
    <div class="row">
        <h3 class="text col-12">Filtrar por:</h3>
        <div class="col-12 col-md-6">
            <form action="<?=base_url('user/searchEntryLabByDocLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <select name="type_doc" id="type_doc" class="form-select" placeholder="Tipo de documento">
                        <option value="0">Tipo doc.🪪</option>
                        <option value="1">DNI</option>
                        <option value="2">Carnet de biblioteca</option>
                        <option value="3">Carnet universitario</option>
                    </select>
                    <select name="num_lab" id="num_lab" class="form-select">
                        <option value="0"># Lab </option>
                        <option value="1">Laboratorio 1</option>
                        <option value="2">Laboratorio 2</option>
                        <option value="3">Laboratorio 3</option>
                        <option value="4">Laboratorio 4</option>
                        <option value="5">Laboratorio 5</option>
                        <option value="6">Laboratorio 6</option>
                        <option value="7">Laboratorio 7</option>
                        <option value="8">Laboratorio 8</option>
                        <option value="9">Laboratorio 9</option>
                        <option value="10">Laboratorio 10</option>
                        <option value="11">Laboratorio 11</option>
                        <option value="12">Laboratorio 12</option>
                    </select>
                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </div>
            </form>
        </div>

        <!-- boton para generar reporte -->
        <div class="col-12 col-md-6">
            <form action="<?=base_url('user/searchEntryLabByDatetime')?>" method="post" class="p-3">
                <div class="input-group">
                    <!-- por hora y fecha de entrada -->
                    <input type="date" name="date_begin" id="hour_entry" class="form-control" value="<?=date('Y-m-d')?>">
                    <!-- por hora y fecha de salida -->
                    <input type="date" name="date_end" id="hour_exit" class="form-control" value="<?=date('Y-m-d')?>">
                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <!-- hacer un boton que ejecute una promsea -->
            <button class="btn btn-primary" id="btn-print-register-lab">Imprimir</button>
        </div>
    </div>
    <!-- hacer que la tabla sea scrollable hacia abajo -->
    <div class="row table-container mt-3 p-3">
        <div class="col-12 table-responsive">
            <?php 
            //inicio de sesion
            $session = session();
            if(session()->getFlashdata('error')):?>
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

<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>

<?=$this->section('js')?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
<script src="<?=base_url('assets/js/admin/view_register_lab.js')?>"></script>
<?=$this->endSection()?>