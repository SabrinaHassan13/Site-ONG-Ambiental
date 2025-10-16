<?php
session_start();

include('Admin/conexao.php');

if (!isset($_SESSION['usuario_logado_id']) && !isset($_SESSION['logado'])) {a $_SESSION['logado']
    header("Location: cadastro.php?msg=Você precisa estar logado para adicionar produtos ao carrinho.");
    exit();
}

$usuario_id = null;
if (isset($_SESSION['usuario_logado_id'])) {
    $usuario_id = $_SESSION['usuario_logado_id'];
} elseif (isset($_SESSION['logado'])) { 
    $usuario_id = 'admin_user_id'; 
    $usuario_id = 1; 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
    $produto_id = filter_var($_POST['produto_id'], FILTER_VALIDATE_INT);
    $quantidade = filter_var($_POST['quantidade'], FILTER_VALIDATE_INT);

    if ($produto_id === false || $quantidade === false || $quantidade <= 0) {
        header("Location: produtos.php?msg_cart=Dados do produto inválidos.");
        exit();
    }

    $stmt_preco = $conn->prepare("SELECT preco_unitario FROM produtos WHERE id = ?"); 
    if (!$stmt_preco) {
        die("Erro ao preparar consulta de preço: " . $conn->error);
    }
    $stmt_preco->bind_param("i", $produto_id);
    $stmt_preco->execute();
    $result_preco = $stmt_preco->get_result();
    if ($result_preco->num_rows === 0) {
        header("Location: produtos.php?msg_cart=Produto não encontrado.");
        exit();
    }
    $produto_data = $result_preco->fetch_assoc();
    $preco_unitario = $produto_data['preco_unitario'];


    $carrinho_id = null;
    $stmt_carrinho = $conn->prepare("SELECT id FROM carrinho WHERE usuario_id = ?");
    if (!$stmt_carrinho) {
        die("Erro ao preparar consulta de carrinho: " . $conn->error);
    }
    $stmt_carrinho->bind_param("i", $usuario_id);
    $stmt_carrinho->execute();
    $result_carrinho = $stmt_carrinho->get_result();

    if ($result_carrinho->num_rows > 0) {
        $carrinho = $result_carrinho->fetch_assoc();
        $carrinho_id = $carrinho['id'];
    } else {
        $stmt_novo_carrinho = $conn->prepare("INSERT INTO carrinho (usuario_id) VALUES (?)");
        if (!$stmt_novo_carrinho) {
            die("Erro ao preparar novo carrinho: " . $conn->error);
        }
        $stmt_novo_carrinho->bind_param("i", $usuario_id);
        $stmt_novo_carrinho->execute();
        $carrinho_id = $conn->insert_id; 
        $stmt_novo_carrinho->close();
    }
    $stmt_carrinho->close();


    $stmt_item = $conn->prepare("SELECT id, quantidade FROM itens_carrinho WHERE carrinho_id = ? AND produto_id = ?");
    if (!$stmt_item) {
        die("Erro ao preparar consulta de item do carrinho: " . $conn->error);
    }
    $stmt_item->bind_param("ii", $carrinho_id, $produto_id);
    $stmt_item->execute();
    $result_item = $stmt_item->get_result();

    if ($result_item->num_rows > 0) {
        $item_existente = $result_item->fetch_assoc();
        $nova_quantidade = $item_existente['quantidade'] + $quantidade;

        $stmt_update = $conn->prepare("UPDATE itens_carrinho SET quantidade = ?, preco_unitario = ? WHERE id = ?");
        if (!$stmt_update) {
            die("Erro ao preparar atualização de item: " . $conn->error);
        }
        $stmt_update->bind_param("idi", $nova_quantidade, $preco_unitario, $item_existente['id']);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        $stmt_insert = $conn->prepare("INSERT INTO itens_carrinho (carrinho_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        if (!$stmt_insert) {
            die("Erro ao preparar inserção de item: " . $conn->error);
        }
        $stmt_insert->bind_param("iiid", $carrinho_id, $produto_id, $quantidade, $preco_unitario);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
    $stmt_item->close();

    header("Location: carrinho.php?msg_cart=Produto adicionado ao carrinho!");
    exit();

} else {
    header("Location: produtos.php?msg_cart=Requisição inválida.");
    exit();
}
?>