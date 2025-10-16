<?php
include '../header.php'; 

include('conexao.php');

if (isset($_SESSION['usuario_logado_id'])) {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['login'])){
    $usuario_digitado = $_POST['usuario'];
    $senha_digitada = $_POST['senha'];

   
    if($usuario_digitado == 'admin' && $senha_digitada == '123'){
        $_SESSION['logado'] = true; 
        $_SESSION['admin_id'] = 'fixed_admin'; 
        $_SESSION['admin_nome'] = 'Administrador Fixo';
        header("Location: dashboard.php");
        exit();
    } else {

        $stmt = $conn->prepare("SELECT id, nome, usuario, senha FROM administradores WHERE usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $usuario_digitado);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();

                if (password_verify($senha_digitada, $admin['senha'])) {
                    $_SESSION['logado'] = true; 
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_nome'] = $admin['nome'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $erro = "Usuário ou senha incorretos!";
                }
            } else {
                $erro = "Usuário ou senha incorretos!";
            }
            $stmt->close();
        } else {
            $erro = "Erro interno no servidor de autenticação.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <main class="main-centered-content">
            <div class="login-container">
                <h2 class="card-title text-center mb-4 text-primary">Login Administrativo</h2>
                <?php if(isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Seu usuário" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input class="form-control" type="password" id="senha" name="senha" placeholder="Sua senha" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit" name="login">Entrar</button>
                </form>
            </div>
        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>