<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<form id="genericForm" class="container mt-4" method="POST" onsubmit="return false;" action="<?php echo BASE_URL ?>/exeDataRegistrations">
    <input type="hidden" id="class_id" name="class_id" value="<?php echo $id ?>">
    <div class="col-md-2 mb-3">
        <label for="studentSelect" class="form-label">Selecione a turma</label>
        <select class="form-select" id="studentSelect" name="student_id" required>
            <option value="" selected disabled>Escolha uma turma...</option>
            <?php if (count($students) > 0) {
                foreach ($students as $student) { ?>
                    <option value="<?php echo base64urlEncode($student['id']) ?>"><?php echo $student['name'] ?></option>
                <?php }
            } ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success"><i class="ri-add-circle-line"></i> Registrar</button>
    <a href="<?php echo BASE_URL ?>/registrations/<?php echo $id ?>"><button type="button" class="btn btn-primary"><i class="ri-corner-down-left-fill"></i> Retornar</button></a>
</form>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>