<header class="bg-light shadow-sm py-2">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">

      <!-- Logo -->
      <div class="d-flex align-items-center">
        <img src="<?php echo BASE_URL ?>/public/images/logo-fiap.jpeg" 
             alt="Logo" class="me-2 logo-img">
      </div>

      <!-- Desktop Navigation -->
      <nav class="d-none d-md-flex gap-3">
        <a href="<?php echo BASE_URL ?>" class="nav-link text-dark">Home</a>
        <a href="<?php echo BASE_URL ?>/students" class="nav-link text-dark">Alunos</a>
        <a href="<?php echo BASE_URL ?>/classes" class="nav-link text-dark">Turmas</a>
        <a href="<?php echo BASE_URL ?>/registrations" class="nav-link text-dark">Matrículas</a>
        <a href="<?php echo BASE_URL ?>/users" class="nav-link text-dark">Usuários</a>
        <a href="<?php echo BASE_URL ?>/reports" class="nav-link text-dark">Relatórios</a>
      </nav>

      <!-- Right Section -->
      <div class="d-flex align-items-center">
        <!-- Desktop Search Bar -->
        <div class="d-none d-md-block">
            <p class="mb-0">Bem-vindo, <strong><?php echo $_SESSION['authenticated']['name'] ?></strong></p>
        </div>
        <a href="<?php echo BASE_URL ?>/logout" class="btn text-dark d-none d-md-block">
          <i class="ri-login-circle-line"></i>
        </a>

        <!-- Mobile Menu Button -->
        <button class="btn btn-outline-secondary d-md-none" id="menuToggle">
          <i class="ri-menu-line"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="d-md-none mt-2 collapse">
      <nav class="mb-2 d-flex flex-column align-items-center gap-2">
        <a href="<?php echo BASE_URL ?>" class="nav-link text-dark">Home</a>
        <a href="<?php echo BASE_URL ?>/students" class="nav-link text-dark">Alunos</a>
        <a href="<?php echo BASE_URL ?>/classes" class="nav-link text-dark">Turmas</a>
        <a href="<?php echo BASE_URL ?>/registrations" class="nav-link text-dark">Matrículas</a>
        <a href="<?php echo BASE_URL ?>/users" class="nav-link text-dark">Usuários</a>
        <a href="<?php echo BASE_URL ?>/reports" class="nav-link text-dark">Relatórios</a>
      </nav>
      <div class="mb-3 w-100 px-3">
        <a href="<?php echo BASE_URL ?>/logout" class="btn btn-outline-dark w-100">
          <i class="ri-login-circle-line"></i>
        </a>
      </div>
      <p class="text-center">Bem-vindo, <strong><?php echo $_SESSION['authenticated']['name'] ?></strong></p>
    </div>
  </div>
</header>