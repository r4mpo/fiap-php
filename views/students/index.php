<?php require_once __DIR__ . '/../templates/navbar.php'; ?>
<div class="container mt-5" style="margin-bottom: 4%;">
    <a href="<?php echo BASE_URL ?>/dataStudents"><button type="button" class="btn btn-dark mb-2"><i class="ri-add-circle-line"></i> Cadastrar</button></a>
    
    <!-- Container que permite scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mb-5">
            <thead class="table-light">
                <tr class="sticky-top">
                    <th>#</th>
                    <th>Aluno</th>
                    <th>E-mail</th>
                    <th data-is-date="true">Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0) {
                    foreach ($students as $index => $student) { ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $student['name'] ?></td>
                            <td><?php echo $student['email'] ?></td>
                            <td><?php echo $student['date_of_birth'] ?></td>
                            <td><?php echo $student['document'] ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary"><i class="ri-pencil-fill"></i></button>
                                <button type="button" class="btn btn-outline-danger delete-data-open-modal" 
                                    data-id="<?php echo $student['id'] ?>"
                                    data-name="<?php echo $student['name'] ?>"
                                    data-delete-url="<?php echo BASE_URL ?>/deleteStudent/<?php echo base64urlEncode($student['id']) ?>"
                                ><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6">Nenhum registro de <strong>alunos</strong> foi encontrado em nosso sistema.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>