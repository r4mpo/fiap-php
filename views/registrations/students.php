<?php require_once __DIR__ . '/../templates/navbar.php'; ?>
<div class="container mt-5">
    <a href="<?php echo BASE_URL ?>"><button type="button" class="btn btn-dark mb-2"><i class="ri-add-circle-line"></i> Cadastrar</button></a>
    <a href="<?php echo BASE_URL ?>/registrations"><button type="button" class="btn btn-primary mb-2"><i class="ri-corner-down-left-fill"></i> Retornar</button></a>

    <!-- Container que permite scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mb-5">
            <thead class="table-light">
                <tr class="sticky-top">
                    <th>#</th>
                    <th>Aluno</th>
                    <th>Turma</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0) {
                    foreach ($students as $index => $student) { ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $student['name'] ?></td>
                            <td><?php echo $student['class'] ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="3">Nenhum registro de <strong>matrículas</strong> foi encontrado em nosso sistema.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>