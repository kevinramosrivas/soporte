<?=$this->extend('Layouts/main')?>

<?=$this->section('title')?>
Dashboard
<?=$this->endSection()?>


<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_user')?>
<main id="main" class="main">

<div class="pagetitle">
<h1>Dashboard</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=base_url('dashboard/user')?>">Inicio</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section dashboard">
<div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
    <div class="row">


        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-6">
            <div class="card info-card revenue-card">


                <div class="card-body">
                <a href="<?=base_url('labs/viewRegisterEntryLab')?>"><h5 class="card-title">Alumnos en laboratorios</h5></a>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?=$students_using_lab?></h6>
                    </div>
                </div>
                </div>

            </div>
            <div class="card info-card task_inprogress">

            <div class="card-body">
            <a href="<?=base_url('tasks/myTasks')?>/<?=session()->get('id_user')?>"><h5 class="card-title">Mis tareas pendientes</h5></a>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-clock"></i>
                </div>
                <div class="ps-3">
                <h6><?=$tasksOpenByUser?> tarea(s)</h6>
                </div>
            </div>

            </div>
            </div>



            <div class="card info-card customers-card">
            <div class="card-body">
            <a href="<?=base_url('tasks/myTasks')?>/<?=session()->get('id_user')?>"><h5 class="card-title">Mis tareas en proceso</h5></a>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-walking"></i>
                </div>
                <div class="ps-3">
                <h6><?=$tasksInProgressByUser?> tarea(s)</h6> 
                </div>
            </div>

            </div>

            </div>
            <div class="card info-card revenue-card">
                    <div class="card-body">
                    <a href="<?=base_url('tasks/myClosedTasks')?>/<?=session()->get('id_user')?>"><h5 class="card-title">Mis tareas finalizadas</h5></a>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-arms-up"></i>
                        </div>
                        <div class="ps-3">
                        <h6><?=$taskFinishedByUser?> tarea(s)</h6> 
                        </div>
                    </div>

                    </div>

            </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-6 col-md-6">

        <div class="card">

            <div class="card-body">
            <h5 class="card-title">Tareas este mes</h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#reportsChart"), {
                    series: [
                        <?=$numberOfTasksByState['open']?>, <?=$numberOfTasksByState['in_progress']?>, <?=$numberOfTasksByState['closed']?>
                    ],
                    chart: {
                    width: "100%",
                    type: 'donut',
                    },
                    labels: ['Pendientes', 'En proceso', 'Completadas'],
                    responsive: [{
                    breakpoint: 480,
                    options: {

                        legend: {
                            position: 'bottom'
                        }
                    }
                    }]
                }).render();
                });
            </script>
            <!-- End Line Chart -->

            </div>

        </div>


        </div><!-- End Customers Card -->



    </div>
    </div><!-- End Left side columns -->

</div>
</section>
</main><!-- End #main -->
<?=$this->endSection()?>
<?=$this->section('js')?>
<?=$this->endSection()?>