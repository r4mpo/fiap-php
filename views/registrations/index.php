<?php require_once __DIR__ . '/../templates/navbar.php'; ?>
<form id="searchClassForm" class="container mt-4" method="GET" action="<?php echo BASE_URL ?>/registrations" onsubmit="return false;">
  <div class="row g-3 align-items-center">
    <div class="col-md-2">
      <label for="classSelect" class="form-label">Selecione a turma</label>
      <select class="form-select" id="classSelect" name="class_id" required>
        <option value="" selected disabled>Escolha uma turma...</option>
        <?php if (count($classes) > 0) {
            foreach ($classes as $class) { ?>
                <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>
            <?php }
        } ?>
      </select>
    </div>

    <div class="col-md-3 d-flex align-items-end mt-5">
      <button type="submit" class="btn btn-secondary"><i class="ri-search-line"></i></button>
    </div>
  </div>
</form>
<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>