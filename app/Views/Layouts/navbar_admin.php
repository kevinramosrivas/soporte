  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?=base_url('admin/home')?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#labs-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-pc-display"></i><span>Laboratorios</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="labs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=base_url('user/registerEntryLab')?>">
              <span>Registrar entrada</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url('user/registerExitLab')?>">
              <span>Registrar salida</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url('user/viewRegisterEntryLab')?>">
              <span>Ver registro de ingresos</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=base_url('admin/users')?>">
              <span>Usuarios</span>
            </a>
          </li>
          <li>
            <a href="<?=base_url('admin/usersInactive')?>">
              <span>Usuarios inactivos</span>
            </a>
          </li>
        </ul>
      </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#password-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-key-fill"></i><span>Contraseñas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="password-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=base_url('user/intermediary')?>">
              <span>Contraseñas</span>
            </a>
          </li>
        </ul>
      </li>
      
      

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=base_url('user/profile')?>">
          <i class="bi bi-person"></i>
          <span>Mi perfil</span>
        </a>
      </li>
      <!-- End Profile Page Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li> -->
      <!-- End F.A.Q Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->