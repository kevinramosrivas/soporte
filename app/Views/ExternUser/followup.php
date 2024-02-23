<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/login.css')?>">
<?=$this->endSection()?>
<?=$this->section('title')?>
Consultar Seguimiento
<?=$this->endSection()?>

<?=$this->section('content')?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="container">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <a href="<?=base_url('tasks/followup')?>">
                            <span class="d-lg-block d-xl-block text-white ms-2"><?=APP_NAME;?></span>
                        </a>
                    </div>
                </div><!-- End Logo -->
        <div class="row">
                <div class="col-12">

                    <div class="card">
                        <!-- formulario para buscar tareas -->
                        <div class="card-body p-4">
                            <form action="<?=base_url('tasks/searchMyUuid')?>" method="post">
                                <label for="taskCode" class="form-label">Código de seguimiento</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="taskCode" name="taskCode" required>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </form>
                        </div>           
                    </div>
                </div>
            </div>
            <?php if (!empty($task)) : ?>
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body p-4">
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
                                                    <div class="mb-1">
                                                        <h6>Estado: 
                                                        <?php if ($task['status'] == 'in_progress') : ?>
                                                            <span class="badge bg-warning">En progreso</span>
                                                        <?php elseif ($task['status'] == 'closed') : ?>
                                                            <span class="badge bg-success">Cerrado</span>
                                                        <?php else : ?>
                                                            <span class="badge bg-secondary">Pendiente</span>
                                                        <?php endif; ?>
                                                        </h6>
                                                    </div>
                                                    <div class="mb-1">
                                                        <p>Código de seguimiento: <span class="badge bg-info"><?=$task['followup_uuid_code']?></span></p>
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
                                    </div>
                                </div>


                            </div>



                                                    
                            <!-- INICIO DE LOS COMENTARIOS -->
                            <div class="row comments p-4">
                                <div class="col-12">
                                    <h3 class="text-title m-4">Comentarios</h3>
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
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <!--final de los comentarios-->
                        </div>








                        <div class="credits text-white text-center ms-2">
                            <p>© UEI FISI - UNMSM 2023</p>
                            <p>v 1.0</p>
                        </div>

                    </div>
                </div>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    No se encontró la tarea
                </div>
            <?php endif; ?>
            

        </div>

        </section>

    </div>
</main><!-- End #main -->

<?=$this->endSection()?>

<?=$this->section('js')?>
    <script src="<?=base_url('assets/js/login/login.js')?>"></script>
<?=$this->endSection()?>
