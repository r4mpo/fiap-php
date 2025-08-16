<?php require_once __DIR__ . '/templates/navbar.php'; ?>

<div class="mt-5">
  <main class="container">
    <div class="row g-4">

      <!-- CRUD Alunos -->
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card p-3 h-100">
          <div class="icon-box mb-3"><i class="ri-graduation-cap-line"></i></div>
          <h5 class="card-title">Alunos</h5>
          <p class="card-text">
            Permite cadastrar, visualizar, editar e remover alunos. 
            Use esta área para manter atualizado o cadastro de estudantes.
          </p>
        </div>
      </div>

      <!-- CRUD Turmas -->
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card p-3 h-100">
          <div class="icon-box mb-3"><i class="ri-team-line"></i></div>
          <h5 class="card-title">Turmas</h5>
          <p class="card-text">
            Gerencie as turmas existentes no sistema. 
            É possível vincular alunos às turmas e manter a organização acadêmica.
          </p>
        </div>
      </div>

      <!-- Controle de Matrículas -->
      <div class="col-md-6 col-lg-4">
        <div class="card feature-card p-3 h-100">
          <div class="icon-box mb-3"><i class="ri-booklet-line"></i></div>
          <h5 class="card-title">Matrículas</h5>
          <p class="card-text">
            Realize matrículas de alunos nas turmas disponíveis, 
            garantindo que todos estejam alocados corretamente.
          </p>
        </div>
      </div>

      <!-- CRUD Usuários -->
      <div class="col-md-6 col-lg-6">
        <div class="card feature-card p-3 h-100">
          <div class="icon-box mb-3"><i class="ri-user-settings-line"></i></div>
          <h5 class="card-title">Usuários</h5>
          <p class="card-text">
            Administre os usuários que têm acesso ao sistema. 
            Cadastre novos perfis, visualize e altere informações.
          </p>
        </div>
      </div>

      <!-- Relatórios -->
      <div class="col-md-6 col-lg-6">
        <div class="card feature-card p-3 h-100">
          <div class="icon-box mb-3"><i class="ri-bar-chart-box-line"></i></div>
          <h5 class="card-title">Relatórios</h5>
          <p class="card-text">
            Gere relatórios detalhados sobre alunos, turmas e matrículas. 
            Utilize filtros para extrair informações relevantes e apoiar a gestão.
          </p>
        </div>
      </div>

    </div>

    <!-- Dicas de uso -->
    <section class="mt-5">
      <h4 class="mb-3">Dicas de Uso</h4>
      <ul class="list-group">
        <li class="list-group-item"><i class="ri-check-line text-success"></i> Mantenha os cadastros de alunos e turmas sempre atualizados.</li>
        <li class="list-group-item"><i class="ri-check-line text-success"></i> Utilize o controle de matrículas para organizar alunos em suas turmas.</li>
        <li class="list-group-item"><i class="ri-check-line text-success"></i> Gere relatórios para acompanhar o desempenho e organização.</li>
        <li class="list-group-item"><i class="ri-check-line text-success"></i> Use o menu de usuários apenas para administradores do sistema.</li>
      </ul>
    </section>
  </main>
</div>

<?php require_once __DIR__ . '/templates/bottom-bar.php'; ?>