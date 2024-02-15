<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Gestión de Manuales
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<!--si el usuario es un administrador, mostrar el navbar de administrador, si no, mostrar el navbar de usuario-->
<?php
    $session = session(); 
if($session->type == 'ADMINISTRADOR'): ?>
    <?=$this->include('Layouts/navbar_admin')?>
<?php  elseif($session->type == 'BOLSISTA'): ?>
    <?=$this->include('Layouts/navbar_user')?>
<?php  endif; ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ver documentación</h1>
        <nav>
            <ol class="breadcrumb">
            <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/admin')?>">Inicio</a></li>
            <?php else : ?>
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/user')?>">Inicio</a></li>
            <?php endif; ?>
            <li class="breadcrumb-item inactive">Documentación</li>
            <li class="breadcrumb-item inactive">Ver documentación
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <!--hacer un acordeon para mostrar los manuales por categorias, dentro de cada categoria mostrar los manuales en grid-->
    <div class="accordion" id="accordionExample">
        <?php foreach ($categories as $category) : ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?=$category['id_category']?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$category['id_category']?>" aria-expanded="false" aria-controls="collapse<?=$category['id_category']?>">
                    <?=$category['categoryName']?>
                </button>
            </h2>
            <div id="collapse<?=$category['id_category']?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$category['id_category']?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row">
                        <!-- mostrar la descripcion de la categoria -->
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <!-- poner decripcion de la categoria -->
                            <?= $category['categoryDescription']?>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($documents as $document) : ?>
                        <?php
                            if ($document['id_category'] == $category['id_category']) : 
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-image d-flex justify-content-center align-items-center p-3">
                                    <!-- si el cliente es un celular, mostrar un icono de pdf -->
                                    <i class="bi bi-file-pdf-fill file-pdf-icon" style="font-size: 5rem; color: #f00;"></i>
                                    <!-- mostrar una previualizacion del pdf , ocultar el scrollbar -->
                                    <embed src="<?=base_url($document['documentPath'])?>" type="application/pdf"  class="file-pdf-embed card-img-top">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title
                                    "><?=$document['documentName']?></h5>
                                    <p class="card-text"><?=$document['documentDescription']?></p>
                                    <a href="<?=base_url($document['documentPath'])?>" class="btn btn-primary">Descargar</a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


    

</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url('assets/js/user/show_documents.js')?>"></script>
<?=$this->endSection()?>