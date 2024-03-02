<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Gestión de tareas
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
        <h1>Gestor de tareas</h1>
        <nav>
            <ol class="breadcrumb">
            <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/admin')?>">Inicio</a></li>
            <?php else : ?>
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard/user')?>">Inicio</a></li>
            <?php endif; ?>
            <li class="breadcrumb-item inactive">Tareas
            <li class="breadcrumb-item inactive">Gestor de tareas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section tasks">
        <div class="row">
            <!--solo mostrar el boton de crear tarea si el usuario es un administrador-->
            <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
                <div class="col-12 d-flex justify-content-center">
                    <!--crear un boton con su modal para agregar tareas tarea las tareas tienen los siguientes campos: titulo, descripcion, estado, asignado a,-->
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    Crear tarea <i class="bi bi-plus-square-fill"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Crear tarea</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?=base_url('tasks/registerTask')?>" method="post" id="createTaskForm" onsubmit="return validateCreateTaskForm()">
                                <div class="mb-3">
                                    <label for="titleCreateTaskForm" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="titleCreateTaskForm" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descriptionCreateTaskForm" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descriptionCreateTaskForm" name="description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="requesting_unitCreateTaskForm" class="form-label">Unidad solicitante</label>
                                    <select class="form-select" name="requesting_unit" id="requesting_unitCreateTaskForm" required>
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
                                        Si esta usando una computadora de escritorio, mantenga presionado la tecla Ctrl para seleccionar a más de un usuario
                                    </div>
                                    <label for="assigned_toCreateTaskForm" class="form-label">Asignar a</label>
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Seleccionar
                                    </button>
                                    <ul class="dropdown-menu">
                                    <select class="form-select" id="assigned_toCreateTaskForm" name="assigned_to[]" multiple>
                                        <?php foreach ($users as $user) : ?>
                                            <li><option class="dropdown-item" value="<?=$user['id_user']?>"><?=$user['username']?></option></li>
                                        <?php endforeach; ?>
                                    </select>
                                    </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" form="createTaskForm">Guardar</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row mt-4">
            <!--alert donde se mostrara el mensaje de exito o error al crear, editar o eliminar una tarea-->
            <div class="col-12">
                <?php if (isset($session->success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?=$session->getFlashdata('success')?>
                    </div>
                <?php endif; ?>
                <?php if (isset($session->error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$session->getFlashdata('error')?>
                    </div>
                <?php endif; ?>
            </div>
    
            <!--tres columnas, una para las tareas pendientes, otra para las tareas en proceso y otra para las tareas terminadas-->
            <div class="col-12 col-md-4">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" id="button_collapse_open_tasks" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_open_tasks" aria-expanded="true" aria-controls="collapse_open_tasks">
                        <h2><span class="badge bg-secondary">Pendientes 📍</span></h2>
                    </button>
                    </h2>
                    <div id="collapse_open_tasks" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="tasks-container" id="pendingTasks">
                            <?php if (isset($tasks_open)):?>
                                <?php foreach ($tasks_open as $task) : ?>
                                    <?php if ($task['status'] == 'open') : ?>
                                        <div class="task">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?=$task['title']?></h5> 
                                                <div class="list-group my-2">
                                                    <p class="card-subtitle mb-1">Creado: <span class="badge bg-primary"><?=$task['created_at']?></span></p>
                                                    <p class="card-subtitle mb-1">Actualizado: <span class="badge bg-success"><?=$task['updated_at']?></span></p>
                                                    <p class="card-subtitle mb-1"><span class="badge bg-dark"><?=$task['requesting_unit']?></span></p>
                                                </div>
                                                <p class="card-text"><?=substr($task['description'], 0, 100)?>...</p>
                                                <h6 class="card-subtitle my-2 text-body-secondary">Asignado a:
                                                <?php $task_open_users = explode(',', $task['username']);?>
                                                <!--si es que son mas de 3 usuarios, mostrar solo 3 y un boton para ver mas-->
                                                <?php if (count($task_open_users) > 3) : ?>
                                                    <?php for ($i = 0; $i < 3; $i++) : ?>
                                                        <img src="https://ui-avatars.com/api/?name=<?=$task_open_users[$i]?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                    <?php endfor; ?>
                                                    <img src="https://ui-avatars.com/api/?name=+<?=count($task_open_users) - 3?>" alt="" class="rounded-circle" width="30" heigth="30">

                                                <?php else : ?>
                                                    <?php foreach ($task_open_users as $task_open_user) :?>
                                                        <img src="https://ui-avatars.com/api/?name=<?=$task_open_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </h6>
                                                
                                            </div>
                                            <div class="card-footer">
                                                <div class="row d-flex align-items-center">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskDetailModal<?=$task['followup_uuid_code']?>">
                                                        Detalles
                                                    </button>
                                                    <div class="modal fade" id="taskDetailModal<?=$task['followup_uuid_code']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                <li class="list-group-item">Estado: <span class="badge bg-secondary">Pendiente</span></li>
                                                                <li class="list-group-item">Unidad solicitante: <span class="badge bg-dark"><?=$task['requesting_unit']?></span></li>
                                                                <li class="list-group-item">Fecha de creación: <span class="badge bg-primary"><?=$task['created_at']?></span></li>
                                                                <li class="list-group-item">Fecha de actualización: <span class="badge bg-success"><?=$task['updated_at']?></span></li>
                                                                <li class="list-group-item">
                                                                    Asignado a:
                                                                    <br>
                                                                    <?php foreach ($task_open_users as $task_open_user) :?>
                                                                        <button type="button" class="btn btn-link p-0 m-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?=$task_open_user?>">
                                                                            <img src="https://ui-avatars.com/api/?name=<?=$task_open_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                                        </button>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                                <div class="row text-center p-2">
                                                                        <!-- solo el administrador puede editar y eliminar tareas-->
                                                                        <!-- un ususario solo puede comentar las tareas-->
                                                                        <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
                                                                            <div class="col-4 p-3">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal<?=$task['id_task']?>">
                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/deleteTask/'.$task['id_task'])?>" class="btn btn-danger btn-delete"><i class="bi bi-trash-fill"></i></a>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <!-- mostrar solo el boton de comentarios si el usuario es parte de los usuarios asignados a la tarea y no es un administrador-->
                                                                        <?php if(in_array($session->id_user, explode(',', $task['id_users'])) && $session->type != 'ADMINISTRADOR') : ?>
                                                                            <div class="col-12 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                </div>
                    
                                                            </ul>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="editTaskModal<?=$task['id_task']?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar tarea</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?=base_url('tasks/editTask/'.$task['id_task'])?>" method="post" id="editTaskForm<?=$task['id_task']?>" onsubmit="return validateEditTaskForm(<?=$task['id_task']?>)">
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
                                                                        <select class="form-select" id="requesting_unitEditTask<?=$task['id_task']?>" name="requesting_unit">
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
                                                                        <select class="form-select" id="assigned_toEditTask<?=$task['id_task']?>" name="assigned_to[]"  multiple>
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
                                                <!--un select con la propiedad onchage para cambiar el estado de la tarea-->
                                                <div class="col-6">
                                                        <!--un select con la propiedad onchage para cambiar el estado de la tarea-->
                                                        <!--este select solo se muestra si el usuario es un administrador y a los usuarios que se les asigno la tarea-->
                                                        <!--si el usuario es un usuario normal, no se muestra el select-->
                                                        <?php if (isset($session->type) && ($session->type == 'ADMINISTRADOR' || in_array($session->id_user, explode(',', $task['id_users'])))) : ?>
                                                            <div class="m-2">
                                                                <select class="form-select" id="status_task<?=$task['id_task']?>" name="status" onchange="changeStatusTask(this, <?=$task['id_task']?>,'<?=$task['followup_uuid_code']?>')" required>
                                                                    <option value="open"selected>Pendiente 📍</option>
                                                                    <option value="in_progress">En progreso 🏃‍♂️</option>
                                                                    <option value="closed">Terminada ✅</option>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else:?>
                                <div class="alert alert-warning" role="alert">
                                    No hay tareas pendientes
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>


            <div class="col-12 col-md-4">
            <div class="accordion" id="accordionInProgressTasks">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" id="button_collapse_inprogress_tasks" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_inprogress_tasks" aria-expanded="true" aria-controls="collapse_inprogress_tasks">
                        <h2><span class="badge bg-warning">En progreso 🏃‍♂️</span>
                    </button>
                    </h2>
                    <div id="collapse_inprogress_tasks" class="accordion-collapse collapse show" data-bs-parent="#accordionInProgressTasks">
                    <div class="accordion-body">
                        <div class="tasks-container" id="pendingTasks">
                            <?php if (isset($tasks_in_progress)):?>
                                <?php foreach ($tasks_in_progress as $task) : ?>
                                    <?php if ($task['status'] == 'in_progress') : ?>
                                        <div class="card">
                                            <div class="card-body">
                                        
                                                <h5 class="card-title"><?=$task['title']?></h5>
                                                <div class="list-group my-2">
                                                    <p class="card-subtitle mb-1">Creado: <span class="badge bg-primary"><?=$task['created_at']?></span></p>
                                                    <p class="card-subtitle mb-1">Actualizado: <span class="badge bg-success"><?=$task['updated_at']?></span></p>
                                                    <p class="card-subtitle mb-1"><span class="badge bg-dark"><?=$task['requesting_unit']?></span></p>
                                                </div>
                                                <p class="card-text"><?=substr($task['description'], 0, 100)?>...</p>
                                                <h6 class="card-subtitle my-2 text-body-secondary">Asignado a:
                                                    <?php $task_inprogress_users = explode(',', $task['username']);?>
                                                    <!--si es que son mas de 3 usuarios, mostrar solo 3 y un boton para ver mas-->
                                                    <?php if (count($task_inprogress_users) > 3) : ?>
                                                        <?php for ($i = 0; $i < 3; $i++) : ?>
                                                            <img src="https://ui-avatars.com/api/?name=<?=$task_inprogress_users[$i]?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                        <?php endfor; ?>
                                                        <img src="https://ui-avatars.com/api/?name=+<?=count($task_inprogress_users) - 3?>" alt="" class="rounded-circle" width="30" heigth="30">

                                                    <?php else : ?>
                                                        <?php foreach ($task_inprogress_users as $task_inprogress_user) :?>
                                                            <img src="https://ui-avatars.com/api/?name=<?=$task_inprogress_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </h6>

                                        
                                                
                                            </div>
                                            <div class="card-footer">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskDetailModal<?=$task['followup_uuid_code']?>">
                                                            Detalles
                                                        </button>
                                                        <div class="modal fade" id="taskDetailModal<?=$task['followup_uuid_code']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <li class="list-group-item">Estado: <span class="badge bg-warning">En progreso</span></li>
                                                                    <li class="list-group-item">Unidad solicitante: <span class="badge bg-dark"><?=$task['requesting_unit']?></span></li>
                                                                    <li class="list-group-item">Fecha de creación: <span class="badge bg-primary"><?=$task['created_at']?></span></li>
                                                                    <li class="list-group-item">Fecha de actualización: <span class="badge bg-success"><?=$task['updated_at']?></span></li>
                                                                    <li class="list-group-item">
                                                                        Asignado a:
                                                                        <br>
                                                                        <?php foreach ($task_inprogress_users as $task_inprogress_user) :?>
                                                                            <button type="button" class="btn btn-link p-0 m-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?=$task_inprogress_user?>">
                                                                                <img src="https://ui-avatars.com/api/?name=<?=$task_inprogress_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                                            </button>
                                                                        <?php endforeach; ?>
                                                                    </li>
                                                                    <div class="row text-center p-2">
                                                                                                                                                <!-- solo el administrador puede editar y eliminar tareas-->
                                                                        <!-- un ususario solo puede comentar las tareas-->
                                                                        <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
                                                                            <div class="col-4 p-3">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal<?=$task['id_task']?>">
                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/deleteTask/'.$task['id_task'])?>" class="btn btn-danger btn-delete"><i class="bi bi-trash-fill"></i></a>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <!-- mostrar solo el boton de comentarios si el usuario es parte de los usuarios asignados a la tarea y no es un administrador-->
                                                                        <?php if(in_array($session->id_user, explode(',', $task['id_users'])) && $session->type != 'ADMINISTRADOR') : ?>
                                                                            <div class="col-12 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                        
                                                                </ul>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="editTaskModal<?=$task['id_task']?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar tarea</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?=base_url('tasks/editTask/'.$task['id_task'])?>" method="post" id="editTaskForm<?=$task['id_task']?>" onsubmit="return validateEditTaskForm(<?=$task['id_task']?>)">
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
                                                                <select class="form-select" id="status_task<?=$task['id_task']?>" name="status" onchange="changeStatusTask(this, <?=$task['id_task']?>,'<?=$task['followup_uuid_code']?>')" required>
                                                                    <option value="in_progress" selected>En progreso 🏃‍♂️</option>
                                                                    <option value="open">Pendiente 📍</option>
                                                                    <option value="closed">Terminada ✅</option>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else:?>
                                <div class="alert alert-warning" role="alert">
                                    No hay tareas en progreso
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-12 col-md-4">
            <div class="accordion" id="accordionClosedTasks">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" id="button_collapse_closed_tasks" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_closed_tasks" aria-expanded="true" aria-controls="collapse_closed_tasks">
                        <h2><span class="badge bg-success">Terminadas ✅</span>
                    </button>
                    </h2>
                    <div id="collapse_closed_tasks" class="accordion-collapse collapse show" data-bs-parent="#accordionClosedTasks">
                    <div class="accordion-body">
                        <div class="tasks-container" id="pendingTasks">
                            <?php if (isset($tasks_closed)):?>
                                <?php foreach ($tasks_closed as $task) : ?>
                                    <?php if ($task['status'] == 'closed') : ?>
                                        <div class="task">
                                        <div class="card">
                                            <div class="card-body">
                                                <del>
                                                    <h5 class="card-title"><?=$task['title']?></h5>
                                                </del>
                                                <div class="list-group my-2">
                                                    <p class="card-subtitle mb-1">Creado: <span class="badge bg-primary"><?=$task['created_at']?></span></p>
                                                    <p class="card-subtitle mb-1">Actualizado: <span class="badge bg-success"><?=$task['updated_at']?></span></p>
                                                    <p class="card-subtitle mb-1"><span class="badge bg-dark"><?=$task['requesting_unit']?></span></p>
                                                </div>
                                                <del>
                                                    <p class="card-text"><?=substr($task['description'], 0, 100)?>...</p>
                                                </del>
                                                <h6 class="card-subtitle my-2 text-body-secondary">Completado por:
                                                    <?php $task_closed_users = explode(',', $task['username']);?>
                                                    <!--si es que son mas de 3 usuarios, mostrar solo 3 y un boton para ver mas-->
                                                    <?php if (count($task_closed_users ) > 3) : ?>
                                                        <?php for ($i = 0; $i < 3; $i++) : ?>
                                                            <img src="https://ui-avatars.com/api/?name=<?=$task_closed_users[$i]?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                        <?php endfor; ?>
                                                        <img src="https://ui-avatars.com/api/?name=+<?=count($task_closed_users) - 3?>" alt="" class="rounded-circle" width="30" heigth="30">

                                                    <?php else : ?>
                                                        <?php foreach ($task_closed_users  as $task_closed_user) :?>
                                                            <img src="https://ui-avatars.com/api/?name=<?=$task_closed_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </h6>
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
                                                                    <li class="list-group-item">Estado: <span class="badge bg-success">Terminada</span></li>
                                                                    <li class="list-group-item">Unidad solicitante: <span class="badge bg-dark"><?=$task['requesting_unit']?></span></li>
                                                                    <li class="list-group-item">Fecha de creación: <span class="badge bg-primary"><?=$task['created_at']?></span></li>
                                                                    <li class="list-group-item">Fecha de actualización: <span class="badge bg-success"><?=$task['updated_at']?></span></li>
                                                                    <li class="list-group-item">
                                                                        Asignado a:
                                                                        <br>
                                                                        <?php foreach ($task_closed_users  as $task_closed_user) :?>
                                                                            <button type="button" class="btn btn-link p-0 m-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?=$task_closed_user?>">
                                                                                <img src="https://ui-avatars.com/api/?name=<?=$task_closed_user?>&background=random" alt="" class="rounded-circle" width="30" heigth="30">
                                                                            </button>
                                                                        <?php endforeach; ?>
                                                                    </li>
                                                                    <div class="row text-center p-2">
                                                                                                                                                <!-- solo el administrador puede editar y eliminar tareas-->
                                                                        <!-- un ususario solo puede comentar las tareas-->
                                                                        <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR') : ?>
                                                                            <div class="col-4 p-3">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal<?=$task['id_task']?>">
                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/deleteTask/'.$task['id_task'])?>" class="btn btn-danger btn-delete"><i class="bi bi-trash-fill"></i></a>
                                                                            </div>
                                                                            <div class="col-4 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <!-- mostrar solo el boton de comentarios si el usuario es parte de los usuarios asignados a la tarea y no es un administrador-->
                                                                        <?php if(in_array($session->id_user, explode(',', $task['id_users'])) && $session->type != 'ADMINISTRADOR') : ?>
                                                                            <div class="col-12 p-3">
                                                                                <a href="<?=base_url('tasks/comments/'.$task['id_task']).'/'.$task['followup_uuid_code']?>" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i></a>
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
                                                                        <form action="<?=base_url('tasks/editTask/'.$task['id_task'])?>" method="post" id="editTaskForm<?=$task['id_task']?>" onsubmit="return validateEditTaskForm(<?=$task['id_task']?>)">
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
                                                                                <label for="assigned_to" class="form-label
                                                                                ">Asignar a</label>
                                                                                <select class="form-select" id="assigned_to" name="assigned_to[]" multiple>
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
                                                                <select class="form-select" id="status_task<?=$task['id_task']?>" name="status" onchange="changeStatusTask(this, <?=$task['id_task']?>,'<?=$task['followup_uuid_code']?>')" required>
                                                                    <option value="open">Pendiente 📍</option>
                                                                    <option value="in_progress" >En progreso 🏃‍♂️</option>
                                                                    <option value="closed"selected>Terminada ✅</option>
        
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
    
                                        </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <!-- boton para ver mas tareas-->
                                <!--si es administrador, mostrar boton para ver mas tareas-->
                                <?php if (isset($session->type) && $session->type == 'ADMINISTRADOR' && !isset($is_admin_tasks)) : ?>
                                    <div class="row d-flex justify-content-center">
                                        <a href="<?=base_url('tasks/closedTasks')?>" class="btn btn-primary">Ver más</a>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($session->type) && $session->type == 'BOLSISTA') : ?>
                                    <div class="row d-flex justify-content-center">
                                        <a href="<?=base_url('tasks/myClosedTasks/'.$session->id_user)?>" class="btn btn-primary">Ver más</a>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($is_admin_tasks) && $is_admin_tasks == true):?>
                                    <div class="row d-flex justify-content-center">
                                        <a href="<?=base_url('tasks/myClosedTasks/'.$session->id_user)?>" class="btn btn-primary">Ver más</a>
                                    </div>
                                <?php endif;?>
                            <?php else:?>
                                <div class="alert alert-warning" role="alert">
                                    No hay tareas terminadas
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>

            
        </div>
    </section>


    

</main><!-- End #main -->
<?=$this->include('Layouts/footer')?>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url('assets/js/user/tasks.js')?>"></script>
<?=$this->endSection()?>