<?php
include 'header.php'; 

include('Admin/conexao.php');

if (isset($_SESSION['logado'])) {
    header("Location: Admin/dashboard.php");
    exit();
}

$erro = '';

if(isset($_POST['login_usuario'])){
    $email_digitado = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuarios_site WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email_digitado);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha_digitada, $usuario['senha'])) {
                $_SESSION['usuario_logado_id'] = $usuario['id'];
                $_SESSION['usuario_logado_nome'] = $usuario['nome'];
                $_SESSION['usuario_logado_email'] = $usuario['email'];
                $_SESSION['LAST_ACTIVITY'] = time();
                header("Location: index.php");
                exit();
            } else {
                $erro = "Email ou senha incorretos!";
            }
        } else {
            $erro = "Email ou senha incorretos!";
        }
        $stmt->close();
    } else {
        $erro = "Erro interno no servidor de autenticação.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <main class="main-centered-content">
            <div class="login-container">
                <h2 class="card-title text-center mb-4 text-primary">Login de Usuário</h2>
                <?php if(!empty($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Seu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input class="form-control" type="password" id="senha" name="senha" placeholder="Sua senha" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit" name="login_usuario">Entrar</button>
                </form>
                <p class="mt-3 text-center">Não tem uma conta? <a style="color: #11a19a; text-decoration: underline; href="cadastro.php">Cadastre-se</a></p>
            </div>
        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>