<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Comentarios de tarea
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
        <h1>Comentarios de tarea</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="
                <?php if($session->type == 'ADMINISTRADOR'): ?>
                    <?=base_url('dashboard/admin')?>
                <?php  elseif($session->type == 'BOLSISTA'): ?>
                    <?=base_url('dashboard/user')?>
                <?php  endif; ?>
            ">Inicio</a></li>
            <li class="breadcrumb-item inactive"><a href="<?=base_url('tasks/tasks')?>">Tareas</a></li>
            <li class="breadcrumb-item active">Comentarios de tarea</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php $session = session(); ?>
    <section class="section comment_tasks">
        <div class="row ">
        <div class="task">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 p-4 col-md-6">
                            <h5 class="card-title"><?=$task['title']?></h5>
                            <div class="list-group my-2">
                                <p class="card-subtitle mb-1">Creado: <span class="badge bg-primary"><?=$task['created_at']?></span></p>
                                <p class="card-subtitle mb-1">Actualizado: <span class="badge bg-success"><?=$task['updated_at']?></span></p>
                                <p class="card-subtitle mb-1"><span class="badge bg-dark"><?=$task['requesting_unit']?></span></p>
                                <!--hacer un input donde haya un link para que se pueda hacer seguimiento a la tarea por usuarios externos-->
                                <div class="mt-2 mb-2">
                                    <label for="followupLink" class="form-label mb-1">Link de seguimiento</label>
                                </div>
                                <div class="input-group mt-2 mb-2">
                                    <input type="text" class="form-control" value="<?=base_url('tasks/followup/'.$task['followup_uuid_code'])?>" id="followupLink" readonly>
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2" onclick="copyLinkToClipboard('followupLink', '<?=$task['followup_uuid_code']?>')">Copiar</button>
                                </div>
                            </div>
                            <h6 class="card-subtitle mb-3 text-body-secondary">Asignado a:
                                <?php $task_users = explode(',', $task['username']);?>
                                <!--si es que son mas de 3 usuarios, mostrar solo 3 y un boton para ver mas-->
                                <?php if (count($task_users ) > 3) : ?>
                                    <?php for ($i = 0; $i < 3; $i++) : ?>
                                        <img src="https://ui-avatars.com/api/?name=<?=$task_users[$i]?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                    <?php endfor; ?>
                                    <img src="https://ui-avatars.com/api/?name=+<?=count($task_users) - 3?>" alt="" class="rounded-circle" width="30" heigth="30">

                                <?php else : ?>
                                    <?php foreach ($task_users  as $task_user) :?>
                                        <img src="https://ui-avatars.com/api/?name=<?=$task_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </h6>
                        </div>
                        <div class="col-12 p-4 col-md-6">

                            <p class="card-text"><?=$task['description']?></p>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                <div class="row d-flex align-items-center">
                        <div class="col-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskDetailModal<?=$task['followup_uuid_code']?>">
                                Detalles
                            </button>
                            <div class="modal fade" id="taskDetailModal<?=$task['followup_uuid_code']?>" tabindex="-" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de la tarea</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Tarea:</h5>
                                        <p><?=$task['title']?></p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <h5 class="card-title">Descripción:</h5>
                                            <p><?=$task['description']?></p>
                                        </li>
                                        <li class="list-group-item">Estado: 
                                            <span class="badge bg-secondary">
                                            <?php if ($task['status'] == 'open') : ?>
                                                Pendiente
                                            <?php elseif ($task['status'] == 'in_progress') : ?>
                                                En progreso
                                            <?php else : ?>
                                                Terminada
                                            <?php endif; ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item">Unidad solicitante: <span class="badge bg-dark"><?=$task['requesting_unit']?></span></li>
                                        <li class="list-group-item">Fecha de creación: <span class="badge bg-primary"><?=$task['created_at']?></span></li>
                                        <li class="list-group-item">Fecha de actualización: <span class="badge bg-success"><?=$task['updated_at']?></span></li>
                                        <li class="list-group-item">
                                            Asignado a:
                                            <br>
                                            <?php foreach ($task_users  as $task_user) :?>
                                                <button type="button" class="btn btn-link p-0 m-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?=$task_user?>">
                                                    <img src="https://ui-avatars.com/api/?name=<?=$task_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                </button>
                                            <?php endforeach; ?>
                                        </li>
                                        <div class="row text-center p-2">
                                                                                                                    <!-- solo el administrador puede editar y eliminar tareas-->
                                            <!-- un ususario solo puede comentar las tareas-->
                                            <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
                                                <div class="col-6 p-3">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal<?=$task['id_task']?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </div>
                                                <div class="col-6 p-3">
                                                    <a href="<?=base_url('tasks/deleteTask/'.$task['id_task'])?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </ul>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="editTaskModal<?=$task['id_task']?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar tarea</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?=base_url('tasks/editTask/'.$task['id_task'])?>" method="post" id="editTaskForm<?=$task['id_task']?>" onsubmit=" return validateFormEditTask(<?=$task['id_task']?>)">
                                                <div class="mb-3">
                                                    <label for="titleEditTask<?=$task['id_task']?>" class="form-label">Título</label>
                                                    <input type="text" class="form-control" id="titleEditTask<?=$task['id_task']?>" name="title" value="<?=$task['title']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descriptionEditTask<?=$task['id_task']?>" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descriptionEditTask<?=$task['id_task']?>" name="description" required><?=$task['description']?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="requesting_unitEditTask<?=$task['id_task']?>" class="form-label">Unidad solicitante</label>
                                                    <select class="form-select" id="requesting_unitEditTask<?=$task['id_task']?>" name="requesting_unit" required>
                                                        <option value="Unidad de Posgrado">Unidad de Posgrado</option>
                                                        <option value="Instituto de Investigación">Instituto de Investigación</option>
                                                        <option value="Centro de Producción">Centro de Producción</option>
                                                        <option value="Dpto. Académico de Ingeniería de Software">Dpto. Académico de Ingeniería de Software</option>
                                                        <option value="Dpto. Académico de Ingeniería de Sistemas">Dpto. Académico de Ingeniería de Sistemas</option>
                                                        <option value="CERSEU">CERSEU</option>
                                                        <option value="DACC">DACC</option>
                                                        <option value="Dirección Administrativa">Dirección Administrativa</option>
                                                        <option value="Decanato">Decanato</option>
                                                        <option value="Unidad de Estadistica e Informática">Unidad de Estadistica e Informática</option>
                                                        <option value="Unidad de Matricula">Unidad de Matricula</option>
                                                        <!--unidad de publicaciones-->
                                                        <option value="Unidad de Publicaciones">Unidad de Publicaciones</option>
                                                        <!--unidad de bienestar universitario-->
                                                        <option value="Unidad de Bienestar Universitario">Unidad de Bienestar Universitario</option>
                                                        <!--unidad de personal-->
                                                        <option value="Unidad de Personal">Unidad de Personal</option>
                                                        <!--USGOM-->
                                                        <option value="USGOM">USGOM</option>
                                                        <!--UNIDAD DE BIBLIOTECA-->
                                                        <option value="Unidad de Biblioteca">Unidad de Biblioteca</option>
                                                        <!--UNAYOE-->
                                                        <option value="UNAYOE">UNAYOE</option>
                                                        <!-- UNIDAD DE PLANIFICACION -->
                                                        <option value="Unidad de Planificación">Unidad de Planificación</option>
                                                        <!--UNIDAD DE TRAMITE DOCUMENTARIO-->
                                                        <option value="Unidad de Trámite Documentario">Unidad de Trámite Documentario</option>
                                                        <!--UNIDAD DE ECONOMIA-->
                                                        <option value="Unidad de Economía">Unidad de Economía</option>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="alert alert-warning" role="alert">
                                                        Si no selecciona a nadie, las personas asignadas anteriormente se mantendrán
                                                    </div>
                                                    <label for="assigned_toEditTask<?=$task['id_task']?>" class="form-label
                                                    ">Asignar a</label>
                                                    <select class="form-select" id="assigned_toEditTask<?=$task['id_task']?>" name="assigned_to[]" multiple>
                                                        <?php foreach ($users as $user) : ?>
                                                            <option value="<?=$user['id_user']?>"><?=$user['username']?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" form="editTaskForm<?=$task['id_task']?>">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <!--un select con la propiedad onchage para cambiar el estado de la tarea-->
                            <!--este select solo se muestra si el usuario es un administrador y a los usuarios que se les asigno la tarea-->
                            <!--si el usuario es un usuario normal, no se muestra el select-->
                            <?php if (isset($session->type) && ($session->type == 'ADMINISTRADOR' || in_array($session->id_user, explode(',', $task['id_users'])))) : ?>
                                <div class="m-2">
                                    <select class="form-select" id="status" name="status" onchange="changeStatusTask(this, <?=$task['id_task']?>,'<?=$task['followup_uuid_code']?>')" required>
                                    <?php if ($task['status'] == 'open') : ?>
                                        <option value="open" selected>Pendiente 📍</option>
                                        <option value="in_progress">En progreso 🏃‍♂️</option>
                                        <option value="closed">Terminada ✅</option>
                                    <?php elseif ($task['status'] == 'in_progress') : ?>
                                        <option value="open">Pendiente📍</option>
                                        <option value="in_progress" selected>En progreso 🏃‍♂️</option>
                                        <option value="closed">Terminada ✅</option>
                                    <?php else : ?>
                                        <option value="open">Pendiente📍</option>
                                        <option value="in_progress">En progreso 🏃‍♂️</option>
                                        <option value="closed" selected >Terminada ✅</option>
                                    <?php endif; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
        <!-- boton para añadir nuevo comentario -->
        <div class="row p-3">
            <div class="col-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                    Añadir comentario
                </button>
                <div class="modal fade " id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir comentario</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3">
                                <form action="<?=base_url('tasks/registerComment').'/'.$task['id_task'].'/'.$task['followup_uuid_code']?>" method="post" id="addCommentForm" onsubmit="return validateFormAddComment()">
                                    <div class="mb-3">
                                        <label for="comment_create" class="form-label">Comentario</label>
                                        <textarea class="form-control" id="comment_create" name="comment"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" form="addCommentForm">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row comments p-3">
            <div class="col-12">
                <h3 class="text-title">Comentarios</h3>
                <!--si no hay comentarios, mostrar un mensaje-->
                <?php if (empty($comments)) : ?>
                    <div class="alert alert-warning" role="alert">
                        No hay comentarios
                    </div>
                <?php else : ?>
                    <?php foreach ($comments as $comment) : ?>
                        <div class="card p-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title"><img src="https://ui-avatars.com/api/?name=<?=$comment['username']?>&background=random" alt="" class="rounded-circle me-2" width="30" heigth="30"><?=$comment['username']?></h5>
                                        <p class="card-subtitle text-muted">Creado🕑: <?=$comment['created_at']?></p>
                                        <p class="card-subtitle text-muted">Actualizado🕑: <?=$comment['updated_at']?></p>
                                        <p class="card-text mt-4 mb-4"><?=$comment['comment']?></p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <?php if (isset($session->type) && ($session->type == 'ADMINISTRADOR' || $session->id_user == $comment['created_by'])) : ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCommentModal<?=$comment['id_comment_uuid']?>">
                                                Editar
                                            </button>
                                            <div class="modal fade" id="editCommentModal<?=$comment['id_comment_uuid']?>" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar comentario</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?=base_url('tasks/editComment').'/'.$comment['id_comment_uuid'].'/'.$task['id_task'].'/'.$task['followup_uuid_code']?>" method="post" id="editCommentForm<?=$comment['id_comment_uuid']?>"
                                                            onsubmit="return validateFormEditComment('<?=$comment['id_comment_uuid']?>')"
                                                            >
                                                                <div class="mb-3">
                                                                    <label for="commentEditComment<?=$comment['id_comment_uuid']?>" class="form-label">Comentario</label>
                                                                    <textarea class="form-control" id="commentEditComment<?=$comment['id_comment_uuid']?>" name="comment"><?=$comment['comment']?></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary" form="editCommentForm<?=$comment['id_comment_uuid']?>">Guardar</button>
                                                    </div>
                                                </div>
                                                </div>               
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <!--mostrar el boton de eliminar solo si el usuario es un administrador o el usuario que creo el comentario-->
                                        <?php if (isset($session->type) && ($session->type == 'ADMINISTRADOR' || $session->id_user == $comment['created_by'])) : ?>
                                            <a href="<?=base_url('tasks/deleteComment/'.$comment['id_comment_uuid']).'/'.$task['id_task'].'/'.$task['followup_uuid_code']?>" class="btn btn-danger">Eliminar</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </section>
</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?=base_url('assets/js/user/task_comments.js')?>"></script>
<?=$this->endSection()?>

