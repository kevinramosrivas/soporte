<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Gestión de Manuales
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_admin')?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Gestión de documentación</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/home')?>">Inicio</a></li>
            <li class="breadcrumb-item inactive">Manuales</li>
            <li class="breadcrumb-item inactive">Gestión de documentación</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="row p-4">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <!--Modal para agregar un nuevo manual-->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addManualModal">
             Agregar Manual <i class="bi bi-plus-circle"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addManualModal" tabindex="-1" aria-labelledby="addManualModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addManualModalLabel">Agregar Documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Formulario para agregar un nuevo manual-->
                    <form action="<?=base_url('admin/addManual')?>" method="post" id="addManualForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select class="form-select" aria-label="Default select example" name="category">
                                <?php foreach($categories as $category):?>
                                    <option value="<?=$category['id_category']?>"><?=$category['categoryName']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del documento</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Manual">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Subir documento</label>
                            <!--solo se pueden subir archivos pdf-->
                            <input class="form-control" type="file" id="file" name="file" accept="application/pdf">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Subir" form="addManualForm">
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>