<?php require_once __DIR__ . '/../templates/navbar.php'; ?>
<div class="container mt-5" style="margin-bottom: 4%;">
    <a href="<?php echo BASE_URL ?>/dataUsers"><button type="button" class="btn btn-dark mb-2"><i class="ri-add-circle-line"></i> Cadastrar</button></a>
    
    <!-- Container que permite scroll horizontal -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center mb-5">
            <thead class="table-light">
                <tr class="sticky-top">
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0) {
                    foreach ($users as $index => $user) { ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td>
                                <a href="<?php echo BASE_URL ?>/editUsers/<?php echo base64urlEncode($user['id']) ?>"><button type="button" class="btn btn-outline-primary"><i class="ri-pencil-fill"></i></button></a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="4">Nenhum registro de <strong>turmas</strong> foi encontrado em nosso sistema.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>