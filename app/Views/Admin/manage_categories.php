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
                        <form action="<?=base_url('documents/addCategory')?>" method="post" id="addCategoryForm" onsubmit="return validateCategoryForm()">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="name_add_category_form" name="name_category" placeholder="Nombre de la Categoría">
                            </div>
                            <!--añadir FAQ para explicar que es una categoria-->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description_add_category_form"" name="description_category" rows="3"></textarea>
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
        <!-- hacer un mensaje de alerta por si hay errores , este menbsaje debe poder ser cerrado-->
        <div class="col-12">
            <?php if(session()->get('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=session()->get('success')?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session()->get('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=session()->get('error')?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
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
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#categoryModal_<?=$category['id_category']?>">
                                    <i class="bi bi-info-circle"></i>
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
                                            <p>Id de categoria: <span class="badge text-bg-info"><?=$category['id_category_uuid']?></span></p>
                                            <p>Descripción: <span class="badge bg-primary"><?=$category['categoryDescription']?></span></p>
                                            <p>Fecha de creación: <span class="badge text-bg-dark"><?=$category['created_at']?></span></p>
                                            <p>Fecha de actualización: <sp class="badge text-bg-success"><?=$category['updated_at']?></span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!--modal para editar la categoria-->
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal_<?=$category['id_category']?>">
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
                                            <form action="<?=base_url('documents/editCategory/'.$category['id_category'])?>" method="post" id="editCategoryForm_<?=$category['id_category']?>" onsubmit="return validateEditCategoryForm(<?=$category['id_category']?>)">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nombre de la Categoría</label>
                                                    <input type="text" class="form-control" id="name_edit_category<?=$category['id_category']?>"name="name_category" value="<?=$category['categoryName']?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="description_edit_category<?=$category['id_category']?>" name="description_category" rows="3"><?=$category['categoryDescription']?></textarea>
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
                                <a href="<?=base_url('documents/deleteCategory/'.$category['id_category'])?>" class="btn btn-danger btn_delete_category m-1">
                                    <i class="bi bi-trash"></i>
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
<?=$this->section('js')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url('assets/js/admin/manage_categories.js')?>"></script>
<?=$this->endSection()?>