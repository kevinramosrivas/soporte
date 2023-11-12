<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/register_entry_lab.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_admin')?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registro de ingreso a laboratorio</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <!-- modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#modalLectorQRBarcodes">
            Abrir lector <i class="bi bi-upc-scan"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalLectorQRBarcodes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Lector</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reader">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-md-6 container-form">
            <h3 class="text-center" id="div_bienvenida"></h3>
            <form action="<?=site_url('admin/registerNewEntryLab')?>" method="post" id="form_register_entry_lab">
                <div class="mb-3">
                    <label for="num_laboratorio" class="form-label">Número de laboratorio 💻</label>
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
                    <label for="tipo_documento" class="form-label">Tipo de documento 🪪</label>
                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                        <option value="1">DNI</option>
                        <option value="2">Carnet de biblioteca</option>
                        <option value="3">Carnet universitario</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="numero_documento" id="documento_id" class="form-label">Número de documento 🔢</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" required>
                    <!-- si existen errores mostrarlos -->
                </div>
                <?php if (isset(session()->error_num_doc)): ?>
                    <div class="mb-3">
                        <div class="alert alert-danger" role="alert">
                            <?=session()->error_num_doc?>
                        </div>
                    </div>
                <?php endif;?>
                <?php if (isset(session()->success)): ?>
                    <div class="mb-3">
                        <div class="alert alert-success" role="alert">
                            <?=session()->success?>
                        </div>
                    </div>
                <?php endif;?>
                <div class="mb-3 text-center">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/admin/register_lab.js')?>"></script>
<?=$this->endSection()?>

