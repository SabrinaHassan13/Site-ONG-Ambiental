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


if(isset($_POST['add'])){
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    
    $stmt = $conn->prepare("INSERT INTO novidades (titulo, conteudo) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $titulo, $conteudo);
        $stmt->execute();
        $stmt->close();
        header("Location: novidades.php");
        exit();
    } else {
        die("Erro ao preparar a inserção: " . $conn->error);
    }
}


if(isset($_GET['del'])){
    $id = $_GET['del'];
    
    $stmt = $conn->prepare("DELETE FROM novidades WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: novidades.php");
        exit();
    } else {
        die("Erro ao preparar a exclusão: " . $conn->error);
    }
}


$novidades = $conn->query("SELECT id, titulo, conteudo FROM novidades ORDER BY id DESC"); 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <main class="container my-5 p-4 bg-white rounded shadow-sm">
            <h2 class="text-center mb-4">Gerenciar Novidades</h2>
            <form method="post" class="p-4 mb-4 bg-light rounded">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input class="form-control" type="text" id="titulo" name="titulo" placeholder="Título" required>
                </div>
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" placeholder="Conteúdo" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit" name="add">Adicionar Novidade</button>
            </form>

            <h3 class="mt-4 mb-3">Lista de Novidades</h3>
            <ul class="list-group">
                <?php while($n = $novidades->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($n['titulo']) ?></strong>: <?= htmlspecialchars($n['conteudo']) ?>
                        </div>
                        <a class="btn btn-sm btn-danger" href="?del=<?= $n['id'] ?>">Excluir</a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <a class="btn btn-secondary mt-3 d-block w-25 mx-auto" href="dashboard.php">Voltar ao Painel</a>
        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>