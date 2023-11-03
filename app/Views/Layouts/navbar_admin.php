<link rel="stylesheet" href="<?=base_url('/assets/css/admin/navbar.css')?>">
<nav class="navbar  fixed-top navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/UNMSM_coatofarms_seal.svg" class="img-fluid" alt="" width="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?=base_url("admin/home")?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Laboratorios
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?=base_url("admin/registerEntryLab")?>">Registrar entrada</a></li>
                            <li><a class="dropdown-item" href="<?=base_url("admin/registerExitLab")?>">Registrar salida</a></li>
                            <li><a class="dropdown-item" href="<?=base_url("admin/viewRegisterEntryLab")?>">Ver registro de entrada</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?=base_url("admin/users")?>">Usuarios</a>
                </li>
                <li class="nav-item">
                    <!-- boton de cerrar sesion  -->
                    <form action="<?=base_url("admin/logout")?>" method="post">
                        <button type="submit" class="btn btn-danger">Cerrar sesion</button>
                    </form>
                </li>
            </ul>
        </div>
        </div>
    </div>
</nav>