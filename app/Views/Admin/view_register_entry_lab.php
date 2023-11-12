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
            <h1 class="text-center">Registro de entrada de laboratorio</h1>
        </div>
    </div>
    <div class="row">
        <h3 class="text col-12">Filtrar por:</h3>
        <div class="col-12 col-md-6">
            <form action="<?=base_url('admin/viewRegisterEntryLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <select name="type_doc" id="type_doc" class="form-select">
                        <option value="1">DNI</option>
                        <option value="2">Carnet de biblioteca</option>
                        <option value="3">Carnet universitario</option>
                    </select>
                    <select name="num_lab" id="num_lab" class="form-select">
                        <option value="">Laboratorio</option>
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
            <form action="<?=base_url('admin/viewRegisterEntryLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <!-- por hora y fecha de entrada -->
                    <input type="datetime-local" name="hour_entry" id="hour_entry" class="form-control" placeholder="Hora de entrada" value="<?=date('Y-m-d\TH:i:s')?>">
                    <!-- por hora y fecha de salida -->
                    <input type="datetime-local" name="hour_exit" id="hour_exit" class="form-control" placeholder="Hora de salida" value="<?=date('Y-m-d\TH:i:s')?>">
                    <input type="submit" value="Filtrar" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6">
            <!-- barra de busqueda -->
            <form action="<?=base_url('admin/viewRegisterEntryLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por numero de documento">
                    <button type="submit" class="btn btn-primary">Buscar</button>	
                </div>
            </form>
            <form action="<?=base_url('admin/viewRegisterEntryLab')?>" method="post" class="p-3">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por registrado por">
                    <button type="submit" class="btn btn-primary">Buscar</button>	
                </div>
            </form>
        </div>
    </div>
    <!-- hacer que la tabla sea scrollable hacia abajo -->
    <div class="row table-container">
        <div class="col-12 table-responsive">
            <table class="table table-hover table-striped">
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
                            <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">🙅‍♂️ No ha salido</span>' : '<span class="badge bg-secondary">🕛 '.date('h:i:s a', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                            <br>
                            <?=is_null($registerEntryLab['hour_exit']) ? '<span class="badge bg-danger">🙅‍♂️ No ha salido</span>' : '<span class="badge bg-secondary">🗓️ '.date('d-m-Y', strtotime($registerEntryLab['hour_exit'])).'</span>'?>
                        </td>
                        <td><?=$registerEntryLab['username']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?=$this->endSection()?>