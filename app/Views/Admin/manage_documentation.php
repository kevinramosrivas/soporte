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
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/admin')?>">Inicio</a></li>
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
                    <form action="<?=base_url('documents/addManual')?>" method="post" id="addDocumentForm" enctype="multipart/form-data" onsubmit="return validateAddDocumentForm()">
                        <div class="mb-3">
                            <label for="category-add_manual" class="form-label">Categoría</label>
                            <select class="form-select" aria-label="Default select example" name="category" id="category_add_document">
                                <?php foreach($categories as $category):?>
                                    <option value="<?=$category['id_category']?>"><?=$category['categoryName']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name-add_manual" class="form-label">Nombre del documento</label>
                            <input type="text" class="form-control" id="name_add_document" name="name" placeholder="Nombre del Manual">
                        </div>
                        <div class="mb-3">
                            <label for="description-add_manual" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description_add_document" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <!--alert de que solo se pueden subir archivos pdf de hasta 10MB-->
                            <div class="alert alert-warning" id="alert_add_document" role="alert">
                                Solo se pueden subir archivos pdf de hasta 10MB
                            </div>
                            <label for="file" class="form-label">Subir documento</label>
                            <!--solo se pueden subir archivos pdf-->
                            <input class="form-control" type="file" name="file" accept="application/pdf" id = "file_add_document">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Subir" form="addDocumentForm">
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 container-table table-responsive">
        <?php if(empty($documents)): ?>
                <div class="alert alert-warning" role="alert">
                    No hay documentos registrados
                </div>
            <?php else: ?>	
            <table class="table table-striped table-hover text-start" id="table-documents">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($documents as $document) : ?>
                        <tr id="row_<?=$document['id_document']?>">
                            <td><img src="https://ui-avatars.com/api/?name=<?=$booksArray[rand(0,count($booksArray)-1)]?>&background=random" alt="<?=$document['documentName']?>" class="rounded-circle" width="40" height="40"></td>
                            <td><?=$document['categoryName']?></td>
                            <td><?=$document['documentName']?></td>
                            <td>
                                <!-- boton para abrir modal de visualizar documento -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary m-1" data-bs-toggle="modal" data-bs-target="#PreviewDocument<?=$document['id_document']?>">
                                <i class="bi bi-eye"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="PreviewDocument<?=$document['id_document']?>" tabindex="-1" aria-labelledby="PreviewDocumentLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="PreviewDocumentLabel">Visualizar Documento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <embed src="<?=base_url($document['documentPath'])?>" type="application/pdf" width="100%" height="600rem">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--  Fin boton para abrir modal de visualizar documento -->

                                
                                 <!-- boton para abrir modal de informacion de documento -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#InfoDocument<?=$document['id_document']?>">
                                <i class="bi bi-info-circle"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="InfoDocument<?=$document['id_document']?>" tabindex="-1" aria-labelledby="InfoDocumentLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="InfoDocumentLabel">Información del Documento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>ID: <span class="badge text-bg-info"><?=$document['id_document']?></span></p>
                                        <p>Fecha de creación: <span class="badge text-bg-dark"><?=$document['created_at']?></span></p>
                                        <p>Fecha de actualización: <span class="badge text-bg-success"><?=$document['updated_at']?></span></p>
                                        <p>Descripción: <?=$document['documentDescription']?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--  Fin boton para abrir modal de informacion de documento -->
                                <!-- boton para editar documento -->
                                                                 <!-- boton para abrir modal de informacion de documento -->
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editDocument<?=$document['id_document']?>">
                                <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editDocument<?=$document['id_document']?>" tabindex="-1" aria-labelledby="editDocumentLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editDocumentLabel">Editar Documento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?=base_url('documents/edit/'.$document['id_document'])?>" method="post" id="editDocumentForm<?=$document['id_document']?>" enctype="multipart/form-data" onsubmit="return validateEditDocumentForm('<?=$document['id_document']?>')">
                                            <div class="mb-3">
                                                <label for="category-edit_document" class="form-label">Categoría</label>
                                                <select class="form-select" aria-label="Default select example" name="category" id="category_edit_document<?=$document['id_document']?>">
                                                <?php foreach($categories as $category):?>
                                                    <option value="<?=$category['id_category']?>"><?=$category['categoryName']?></option>
                                                <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="name-edit_document" class="form-label">Nombre del documento</label>
                                                <input type="text" class="form-control" id="name_edit_document<?=$document['id_document']?>" name="name" placeholder="Nombre del Manual" value="<?=$document['documentName']?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description-edit_document" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="description_edit_document<?=$document['id_document']?>" name="description" rows="3"><?=$document['documentDescription']?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Subir documento</label>
                                                <!--alerta de que solo se pueden subir archivos pdf y que si no se sube un archivo, se mantendra el archivo actual-->
                                                <div class="alert alert-warning" id="alert_edit_document<?=$document['id_document']?>" role="alert">
                                                    Si no se sube un archivo, se mantendrá el archivo actual
                                                </div>
                                                <!--solo se pueden subir archivos pdf-->
                                                <input class="form-control" type="file" id="file_edit_document<?=$document['id_document']?>" name="file" accept="application/pdf" value="<?=$document['documentPath']?>">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <input type="submit" class="btn btn-primary" value="Guardar" form="editDocumentForm<?=$document['id_document']?>">
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--  Fin boton para abrir modal de informacion de documento -->
                                <!-- boton para eliminar documento -->
                                <a href="<?=base_url('documents/delete/'.$document['id_document'])?>" class="btn btn-danger m-1 delete-button" title="Eliminar"><i class="bi bi-trash"></i></a>
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
<script src="<?=base_url('assets/js/admin/manage_documentation.js')?>"></script>
<?=$this->endSection()?>