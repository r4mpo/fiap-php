<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg w-100" style="max-width: 480px;">
        <div class="card-body">
            <div class="text-center">
                <h1 class="card-title h3"><strong>LOGIN</strong></h1>
                <p class="card-text text-muted"><em>Preencha com seus dados para prosseguir...</em></p>
            </div>
            <div class="mt-4">
                <form id="loginForm" action="<?php echo BASE_URL ?>/exeLogin" onsubmit="return false;">
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted">E-mail</label>
                        <input type="email" class="form-control" id="email" autocomplete="off" placeholder="E-mail" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label text-muted">Senha</label>
                        <input type="password" class="form-control" id="password" autocomplete="off" placeholder="Senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>