<?php
include '../header.php';

$inactive = 120;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $inactive)) {
    session_unset();    
    session_destroy();  
    header("Location: login.php?msg=Sessão expirada. Faça login novamente.");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();

if(!isset($_SESSION['logado'])){header("Location: login.php?msg=Acesso restrito, faça login.");exit();}
include('conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <main class="admin-painel">
            <h2 class="text-center mb-4">Painel Administrativo</h2>
            <div class="row justify-content-center g-3">
                <div class="col-md-6 col-sm-12 d-flex justify-content-center"> 
                    <a class="btn btn-primary w-75 py-3" href="gerenciar_produtos.php">Gerenciar Produtos</a> 
                </div>
                <div class="col-md-6 col-sm-12 d-flex justify-content-center"> 
                    <a class="btn btn-primary w-75 py-3" href="administradores.php">Gerenciar Admnistradores</a> 
                </div>
                <div class="col-md-6 col-sm-12 d-flex justify-content-center"> 
                    <a class="btn btn-primary w-75 py-3" href="novidades.php">Gerenciar Novidades</a>
                </div>
                <div class="col-md-6 col-sm-12 d-flex justify-content-center"> 
                    <a class="btn btn-primary w-75 py-3" href="gerenciar_usuarios.php">Gerenciar Usuários</a> 
                </div>
            </div>
        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>