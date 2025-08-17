<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<form id="genericForm" class="container mt-4" method="POST" onsubmit="return false;"
  action="<?php echo BASE_URL ?>/exeDataStudents">
  <div class="row g-3 align-items-center">
    <?php if (!empty($id)) { ?>
      <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
    <?php } ?>
    <div class="col-md-3 mb-3">
      <label for="name" class="form-label">Nome do aluno</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ri-group-line"></i></span>
        <input name="name" id="name" type="text" class="form-control" placeholder="Nome do aluno" data-minlength="3"
          data-maxlength="50" required value="<?php echo $name ?>">
        <div class="invalid-feedback"></div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <label for="document" class="form-label">CPF</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ri-article-line"></i></span>
        <input name="document" id="document" type="text" class="cpf form-control" data-maxlength="14" placeholder="CPF" required
          value="<?php echo $document ?>">
        <div class="invalid-feedback"></div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <label for="email" class="form-label">E-mail</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ri-mail-line"></i></span>
        <input name="email" id="email" type="email" class="form-control" placeholder="E-mail" required value="<?php echo $email ?>">
        <div class="invalid-feedback"></div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <label for="password" class="form-label">Senha</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ri-key-2-line"></i></span>
        <input name="password" id="password" type="password" class="form-control" placeholder="Senha" <?php echo empty($id) ? 'required' : '' ?>>
        <div class="invalid-feedback"></div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <label for="description" class="form-label">Data de Nascimento</label>
      <div class="input-group">
        <span class="input-group-text"><i class="ri-calendar-line"></i></span>
        <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" min="<?php echo $dateMin ?>"
          max="<?php echo $dateMax ?>" placeholder="Data de Nascimento" required value="<?php echo $dateOfBirth ?>">
        <div class="invalid-feedback"></div>
      </div>
    </div>

  </div>

  <button type="submit" class="btn btn-success"><i class="ri-add-circle-line"></i></span> Registrar</button>
</form>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>