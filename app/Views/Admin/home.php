<?=$this->extend('Layouts/main')?>
<?=$this->section('title')?>
Dashboard
<?=$this->endSection()?>


<?=$this->section('content')?>
<?=$this->include('Layouts/header')?>
<?=$this->include('Layouts/navbar_admin')?>
<main id="main" class="main">

<div class="pagetitle">
<h1>Dashboard</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=base_url('dashboard/admin')?>">Inicio</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section dashboard">
<div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
    <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card sales-card">

            <div class="card-body">
            <a href="<?=base_url('users/users')?>"><h5 class="card-title">Usuarios activos del sistema</h5></a>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                <h6><?=$users?></h6>
                </div>
            </div>
            </div>

        </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-4">
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
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-md-4">
        <div class="card info-card revenue-card">
            <div class="card-body">
            <a href="<?=base_url('tasks/myClosedTasks')?>/<?=session()->get('id_user')?>"><h5 class="card-title">Mis tareas finalizadas</h5></a>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-arms-up"></i>
                </div>
                <div class="ps-3">
                <h6><?=$taskFinishedByUser?></h6> 
                </div>
            </div>

            </div>

        </div>


        </div><!-- End Customers Card -->

        <!-- Reports -->
        <div class="col-12 col-md-6">
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
        </div><!-- End Reports -->
        <!-- Reports -->

        <!-- Reports -->
        <div class="col-12 col-md-6">


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
        </div><!-- End Reports -->
        <!-- Reports -->


    </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4 ">

    <!-- Recent Activity -->
    <div class="card ">
        <!-- <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
        </div> -->

        <div class="card-body">
        <h5 class="card-title">Actividad reciente</h5>

        <div class="activity">
            <?php if($logs == null):?>
                <div class="activity-item d-flex">
                    <div class="activite-label">
                        -
                    </div>
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                        No hay actividad reciente
                    </div>
                </div><!-- End activity item-->
            <?php
            else:
            foreach($logs as $log):?>
                <div class="activity-item d-flex">
                    <div class="activite-label">
                        <?php 
                        //obtener la diferencia de tiempo
                        $datetime1 = new DateTime($log['created_at']);
                        $datetime2 = new DateTime($now);
                        $interval = $datetime1->diff($datetime2);
                        //imprimir la diferencia
                        echo $interval->format('%Dd %Hh %Im');
                        ?>
                    </div>
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                        <div class="accordion" id="accordionLog">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$log['id_log']?>" aria-expanded="true" aria-controls="collapse<?=$log['id_log']?>">
                                    <?=$log['username']?> <?= substr($log['action'], 0, 40)?>...
                                </button>
                                </h2>
                                <div id="collapse<?=$log['id_log']?>" class="accordion-collapse collapse" data-bs-parent="#accordionLog">
                                <div class="accordion-body">
                                    <?=$log['username']?> <?=$log['action']?>
                                </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div><!-- End activity item-->
            <?php endforeach;?>
            <?php endif;?>
        </div>

        </div>
    </div><!-- End Recent Activity -->


    </div><!-- End Right side columns -->

</div>
</section>
</main><!-- End #main -->
<?=$this->endSection()?>
<?=$this->section('js')?>
<?=$this->endSection()?>