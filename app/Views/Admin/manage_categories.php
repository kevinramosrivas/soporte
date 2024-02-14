<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Gestión de categorias
<?=$this->endSection()?>
<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_admin')?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Gestión de categorias</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/admin')?>">Inicio</a></li>
            <li class="breadcrumb-item inactive">Manuales</li>
            <li class="breadcrumb-item inactive">Gestión de categorias
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="row p-4">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <!--crear un modal para crear categorias-->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
             Agregar Categoría <i class="bi bi-plus-circle"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addCategoryModalLabel">Agregar Categoría</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?=base_url('admin/addCategory')?>" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la Categoría">
                            </div>
                            <!--añadir FAQ para explicar que es una categoria-->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Crear</button>
                    </div>
                </div>
                </div>
            </div>
        </div>

                

    </div>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>