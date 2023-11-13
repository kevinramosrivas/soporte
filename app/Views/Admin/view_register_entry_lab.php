<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/view_register_lab.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_admin')?>
<!-- hacer una tabla con el registro de entrada de laboratorio , los campos son el numero de documento, el tipo de documento, el laboratior, hora y fecha de entrada, hora y fecha de salida, el nombre del usuario que registro la entrada -->
<div class="container">
    <div class="row" id="row-title">
        <div class="col-12">
            <h1 class="text-center">Registro préstamo de laboratorio</h1>   
        </div>
    </div>
    <div class="row">
        <h3 class="text col-12">Filtrar por:</h3>
        <div class="col-12 col-md-6">
            <form action="<?=base_url('admin/searchEntryLabByDocLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <select name="type_doc" id="type_doc" class="form-select" placeholder="Tipo de documento">
                        <option value="0">Documento 🪪</option>
                        <option value="1">DNI</option>
                        <option value="2">Carnet de biblioteca</option>
                        <option value="3">Carnet universitario</option>
                    </select>
                    <select name="num_lab" id="num_lab" class="form-select">
                        <option value="0"># Lab </option>
                        <option value="1">Laboratorio 1</option>
                        <option value="2">Laboratorio 2</option>
                        <option value="3">Laboratorio 3</option>
                        <option value="4">Laboratorio 4</option>
                        <option value="5">Laboratorio 5</option>
                        <option value="6">Laboratorio 6</option>
                        <option value="7">Laboratorio 7</option>
                        <option value="8">Laboratorio 8</option>
                        <option value="9">Laboratorio 9</option>
                        <option value="10">Laboratorio 10</option>
                        <option value="11">Laboratorio 11</option>
                        <option value="12">Laboratorio 12</option>
                    </select>
                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </div>
            </form>
        </div>

        <!-- boton para generar reporte -->
        <div class="col-12 col-md-6">
            <form action="<?=base_url('admin/searchEntryLabByDatetime')?>" method="post" class="p-3">
                <div class="input-group">
                    <!-- por hora y fecha de entrada -->
                    <input type="date" name="hour_entry" id="hour_entry" class="form-control" placeholder="Hora de entrada" >
                    <!-- por hora y fecha de salida -->
                    <input type="date" name="hour_exit" id="hour_exit" class="form-control" placeholder="Hora de salida">
                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <!-- hacer un boton que ejecute una promsea -->
            <button class="btn btn-primary" id="btn-print-register-lab">Imprimir</button>
        </div>
    </div>
    <!-- hacer que la tabla sea scrollable hacia abajo -->
    <div class="row table-container mt-3 p-3">
        <div class="col-12 table-responsive">
            <table class="table table-hover table-striped" id="table-register-entry-lab">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"># doc</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Laboratorio</th>
                        <th scope="col">Entrada</th>
                        <th scope="col">Salida</th>
                        <th scope="col">Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    //inicio de sesion
                    $session = session();
                    if(session()->getFlashdata('error')):?>
                        <div class="alert alert-danger" role="alert">
                            <?=session()->getFlashdata('error')?>
                        </div>
                    <?php if($registerEntryLab == null):?>
                        <div class="alert alert-danger" role="alert">
                            No hay registros
                        </div>
                    <?php endif;?>    
                    <!-- ver si es que hay datos en la variable de sesion -->
                    <?php else: ?>
                        <?php foreach ($registerEntryLab as $registerEntryLab) : ?>
                        <tr>
                            <td><?=$registerEntryLab['num_doc']?></td>
                            <td><?=$registerEntryLab['type_doc']?></td>
                            <td><?=$registerEntryLab['num_lab']?></td>
                            <td>
                                <span class="badge text-bg-primary"><?='🕛'.date('h:i:s a', strtotime($registerEntryLab['hour_entry']))?></span>
                                <br>
                                <span class="badge text-bg-primary"><?='🗓️ '.date('d-m-Y', strtotime($registerEntryLab['hour_entry']))?></span>
                            </td>
                            <td>
                                <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">No ha salido</span>' : '<span class="badge bg-secondary">🕛 '.date('h:i:s a', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                                <br>
                                <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">No ha salido</span>' : '<span class="badge bg-secondary">🗓️ '.date('d-m-Y', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                            </td>
                            <td><?=$registerEntryLab['username']?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif;?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?=$this->endSection()?>

<?=$this->section('js')?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.7/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
<script src="<?=base_url('assets/js/admin/view_register_lab.js')?>"></script>
<?=$this->endSection()?>