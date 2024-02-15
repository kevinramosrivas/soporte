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
                        <form action="<?=base_url('documents/addCategory')?>" method="post" id="addCategoryForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="name" name="name_category" placeholder="Nombre de la Categoría">
                            </div>
                            <!--añadir FAQ para explicar que es una categoria-->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" name="description_category" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar" form="addCategoryForm">
                    </div>
                </div>
                </div>
            </div>
        </div>

                

    </div>
    <div class="row">
        <div class="col-12 container-table table-responsive">
        <?php if(empty($categories)): ?>
                <div class="alert alert-warning" role="alert">
                    No hay categorias registradas
                </div>
            <?php else: ?>	
            <table class="table table-striped table-hover text-start" id="table-categories">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col"># Documentos</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categories as $category): ?>
                        <tr id="row_<?=$category['id_category']?>">
                            <td>CD-<?=$category['id_category']?></td>
                            <td><?=$category['categoryName']?></td>
                            <td><?=$category['num_documents']?></td>
                            <td>
                            <!-- modal donde mostrara la descripcion, fecha de creacion y fecha de actualizacion de la categoria-->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal_<?=$category['id_category']?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="modal fade " id="categoryModal_<?=$category['id_category']?>" tabindex="-1" aria-labelledby="categoryModalLabel_<?=$category['id_category']?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="categoryModalLabel_<?=$category['id_category']?>">Descripción de la categoría</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body
                                        ">
                                            <p><?=$category['categoryDescription']?></p>
                                            <p>Fecha de creación: <?=$category['created_at']?></p>
                                            <p>Fecha de actualización: <?=$category['updated_at']?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!--modal para editar la categoria-->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal_<?=$category['id_category']?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <div class="modal fade " id="editCategoryModal_<?=$category['id_category']?>" tabindex="-1" aria-labelledby="editCategoryModalLabel_<?=$category['id_category']?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editCategoryModalLabel_<?=$category['id_category']?>">Editar Categoría</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body
                                        ">
                                            <form action="<?=base_url('documents/editCategory/'.$category['id_category'])?>" method="post" id="editCategoryForm_<?=$category['id_category']?>">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre de la Categoría</label>
                                                    <input type="text" class="form-control" id="name" name="name_category" value="<?=$category['categoryName']?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="description" name="description_category" rows="3"><?=$category['categoryDescription']?></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <input type="submit" class="btn btn-primary" value="Guardar" form="editCategoryForm_<?=$category['id_category']?>">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!--boton para eliminar la categoria-->
                                <a href="<?=base_url('documents/deleteCategory/'.$category['id_category'])?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta categoría?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>