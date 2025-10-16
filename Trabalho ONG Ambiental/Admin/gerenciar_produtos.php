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
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $imagem_url = $_POST['imagem_url']; 
    $preco_unitario = filter_var($_POST['preco_unitario'], FILTER_VALIDATE_FLOAT); 
    
    if ($preco_unitario === false) {
        die("Preço inválido.");
    }

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, imagem_url, preco_unitario) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssd", $nome, $descricao, $imagem_url, $preco_unitario); 
        $stmt->execute();
        $stmt->close();
        header("Location: gerenciar_produtos.php");
        exit();
    } else {
        die("Erro ao preparar a inserção: " . $conn->error);
    }
}


if(isset($_GET['del'])){
    $id = $_GET['del'];
    
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: gerenciar_produtos.php");
        exit();
    } else {
        die("Erro ao preparar a exclusão: " . $conn->error);
    }
}


$produtos = $conn->query("SELECT id, nome, descricao, imagem_url, preco_unitario FROM produtos ORDER BY id DESC"); 
?>

<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <main class="container my-5 p-4 bg-white rounded shadow-sm">
            <h2 class="text-center mb-4">Gerenciar Produtos</h2>
            <form method="post" class="p-4 mb-4 bg-light rounded">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Produto</label>
                    <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome do Produto" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição Detalhada do Produto" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem_url" class="form-label">URL da Imagem</label>
                    <input class="form-control" type="url" id="imagem_url" name="imagem_url" placeholder="Ex: http://exemplo.com/imagem.jpg">
                </div>
                <div class="mb-3">
                    <label for="preco_unitario" class="form-label">Preço Unitário</label>
                    <input class="form-control" type="number" step="0.01" id="preco_unitario" name="preco_unitario" placeholder="Ex: 99.99" required>
                </div>
                <button class="btn btn-primary" type="submit" name="add">Adicionar Produto</button>
            </form>

            <h3 class="mt-4 mb-3">Lista de Produtos</h3>
            <ul class="list-group">
                <?php if ($produtos && $produtos->num_rows > 0): ?>
                    <?php while($p = $produtos->fetch_assoc()): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($p['nome']) ?></strong>: <?= htmlspecialchars($p['descricao']) ?> (R$ <?= number_format($p['preco_unitario'], 2, ',', '.') ?>)
                                <?php if (!empty($p['imagem_url'])): ?>
                                    <br><img src="<?= htmlspecialchars($p['imagem_url']) ?>" alt="Imagem do Produto" style="max-width: 100px; height: auto; margin-top: 10px; border-radius: 5px;">
                                <?php endif; ?>
                            </div>
                            <a class="btn btn-sm btn-danger" href="?del=<?= $p['id'] ?>">Excluir</a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        Nenhum produto disponível no momento.
                    </div>
                <?php endif; ?>
            </ul>
            <a class="btn btn-secondary mt-3 d-block w-25 mx-auto" href="dashboard.php">Voltar ao Painel</a>
        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>