<div class="modal fade" id="editTaskModal<?=$task['id_task']?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar tarea</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('tasks/editTask/'.$task['id_task'])?>" method="post" id="editTaskForm<?=$task['id_task']?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?=$task['title']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" required><?=$task['description']?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="requesting_unit" class="form-label">Unidad solicitante</label>
                        <select class="form-select" id="requesting_unit" name="requesting_unit" required>
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
                        <label for="assigned_to" class="form-label
                        ">Asignar a</label>
                        <select class="form-select" id="assigned_to" name="assigned_to[]" required multiple>
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