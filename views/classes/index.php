<?php require_once __DIR__ . '/../templates/navbar.php'; ?>
<div class="container mt-5" style="margin-bottom: 4%;">
    <a href="<?php echo BASE_URL ?>/createClasses"><button type="button" class="btn btn-dark mb-2"><i class="ri-add-circle-line"></i> Cadastrar</button></a>
    
    <!-- Container que permite scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mb-5">
            <thead class="table-light">
                <tr class="sticky-top">
                    <th>#</th>
                    <th>Turma</th>
                    <th>Descrição</th>
                    <th>Quantidade de Alunos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($classes) > 0) {
                    foreach ($classes as $index => $class) { ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $class['name'] ?></td>
                            <td><?php echo $class['description'] ?></td>
                            <td><?php echo $class['qttStudents'] ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary"><i class="ri-pencil-fill"></i></button>
                                <button type="button" class="btn btn-outline-danger delete-data-open-modal" 
                                    data-id="<?php echo $class['id'] ?>"
                                    data-name="<?php echo $class['name'] ?>"
                                    data-delete-url="<?php echo BASE_URL ?>/deleteClasses/<?php echo base64urlEncode($class['id']) ?>"
                                ><i class="ri-delete-bin-line"></i></button>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">Nenhum registro de <strong>turmas</strong> foi encontrado em nosso sistema.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>