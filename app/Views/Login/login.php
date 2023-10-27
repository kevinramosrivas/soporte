<?=$this->extend('Layouts/main')?>

<?=$this->section('content')?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <h1 class="text-center">Login</h1>
            <form action="<?=site_url('login/login')?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="text" name="password" id="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?=$this->endSection()?>
