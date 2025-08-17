<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<form id="genericForm" class="container mt-4" method="POST" onsubmit="return false;" action="<?php echo BASE_URL ?>/exeDataUsers">
  <?php if (!empty($id)) { ?>
    <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
  <?php } ?>
  <div class="mb-3">
    <label for="name" class="form-label">Nome do usuário</label>
    <div class="input-group">
      <span class="input-group-text"><i class="ri-group-line"></i></span>
      <input name="name" id="name" type="text" class="form-control" placeholder="Nome do usuário" data-minlength="3"
        data-maxlength="20" required value="<?php echo $name ?>">
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <div class="col-md-3">
    <label for="email" class="form-label">E-mail</label>
    <div class="input-group">
      <span class="input-group-text"><i class="ri-mail-line"></i></span>
      <input name="email" id="email" type="email" class="form-control" placeholder="E-mail" required
        value="<?php echo $email ?>">
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


  <button type="submit" class="btn btn-success"><i class="ri-add-circle-line"></i> Registrar</button>
  <a href="<?php echo BASE_URL ?>/users"><button type="button" class="btn btn-primary"><i
        class="ri-corner-down-left-fill"></i> Retornar</button></a>
</form>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>