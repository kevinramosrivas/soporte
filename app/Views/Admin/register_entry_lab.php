<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/register_entry_lab.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_admin')?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 container-form">
            <h3 class="text-center" id="div_bienvenida"></h3>
            <form action="" id="form_register_student">
                <div class="mb-3">
                    <label for="num_laboratorio">Número de laboratorio</label>
                    <select name="num_laboratorio" id="num_laboratorio" class="form-select">
                        <option value="1">Laboratorio 1</option>
                        <option value="2">Laboratorio 2</option>
                        <option value="3">Laboratorio 3</option>
                        <option value="4">Laboratorio 4</option>
                        <option value="5">Laboratorio 5</option>
                        <option value="6" selected>Laboratorio 6</option>
                        <option value="7">Laboratorio 7</option>
                        <option value="8">Laboratorio 8</option>
                        <option value="9">Laboratorio 9</option>
                        <option value="10">Laboratorio 10</option>
                        <option value="11">Laboratorio 11</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tipo_documento">Tipo de documento</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                        <option value="1">DNI</option>
                        <option value="2">Carnet de biblioteca</option>
                        <option value="3">Carnet universitario</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="numero_documento" id="documento_id">Número de documento</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" required>
                </div>
                <div class="mb-3 text-center">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6">
            <!-- modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reader">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/admin/register_lab.js')?>"></script>
<?=$this->endSection()?>

