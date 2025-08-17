<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<form id="genericForm" class="container mt-4" method="POST" onsubmit="return false;"
  action="<?php echo BASE_URL ?>/exeDataClasses">
  <div class="mb-3">
    <label class="form-label">Nome da turma</label>
    <div class="input-group">
      <span class="input-group-text"><i class="ri-group-line"></i></span>
      <input name="name" type="text" class="form-control" placeholder="Nome da turma" data-minlength="3"
        data-maxlength="20" required>
      <div class="invalid-feedback"></div>

    </div>
  </div>

  <div class="mb-3">
    <label class="form-label">Descrição</label>
    <div class="input-group">
      <span class="input-group-text"><i class="ri-text"></i></span>
      <textarea name="description" class="form-control" placeholder="Descrição da turma" data-minlength="3"
        data-maxlength="100" required></textarea>
      <div class="invalid-feedback"></div>
    </div>
  </div>

  <button type="submit" class="btn btn-success"><i class="ri-add-circle-line"></i> Registrar</button>
</form>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>