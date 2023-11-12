<?=$this->extend('Layouts/main')?>
<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/admin/register_entry_lab.css')?>">
<?=$this->endSection()?>

<?=$this->section('content')?>
<?=$this->include('Layouts/navbar_user')?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registro de salida de laboratorio</h1>
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
            <form action="<?=site_url('user/registerNewExitLab')?>" method="post" id="form_register_exit_lab">
                <div class="mb-3">
                    <label for="num_doc" class="form-label">Número de documento 🔢</label>
                    <input type="text" class="form-control" id="num_doc" name="num_doc" placeholder="Número de documento" required>
                    <div class="invalid-feedback" id="error_num_doc">
                    </div>
                </div>
                <div class="mb-3">
                    <!-- si existe un mensaje de error o exito mostrarlo -->
                    <?php if(session()->getFlashdata('error_num_doc')):?>
                        <div class="alert alert-danger" role="alert">
                            <?=session()->getFlashdata('error_num_doc')?>
                        </div>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('success')):?>
                        <div class="alert alert-success" role="alert">
                            <?=session()->getFlashdata('success')?>
                        </div>
                    <?php endif;?>
                    <?php if(session()->getFlashdata('alert_num_doc')):?>
                        <div class="alert alert-warning" role="alert">
                            <?=session()->getFlashdata('alert_num_doc')?>
                        </div>
                    <?php endif;?>
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Registrar salida</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?=$this->endSection()?>
<?=$this->section('js')?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?=base_url('assets/js/admin/register_lab_exit.js')?>"></script>
<?=$this->endSection()?>

