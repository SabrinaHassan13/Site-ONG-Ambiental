<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page_name = basename($_SERVER['PHP_SELF']);
$is_admin_page = (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], '/Admin/') !== false);

$active_item = $current_page_name; 

if ($is_admin_page) {
    if ($current_page_name == 'gerenciar_produtos.php') {
        $active_item = 'produtos.php';
    } elseif ($current_page_name == 'novidades.php') { 
        $active_item = 'novidade.php'; 
    } elseif ($current_page_name == 'administradores.php') { 
        $active_item = 'dashboard.php';
    } elseif ($current_page_name == 'login.php') { 
        $active_item = 'Admin_login.php';
    } elseif ($current_page_name == 'gerenciar_usuarios.php') {
        $active_item = 'dashboard.php';
    } elseif ($current_page_name == 'dashboard.php') {
        $active_item = 'dashboard.php';
    }
}

if (!$is_admin_page) {
    if ($current_page_name == 'produtos.php') {
        $active_item = 'produtos.php';
    } elseif ($current_page_name == 'novidade.php') {
        $active_item = 'novidade.php';
    } elseif ($current_page_name == 'cadastro.php') {
        $active_item = 'cadastro.php';
    } elseif ($current_page_name == 'carrinho.php') {
        $active_item = 'carrinho.php';
    } elseif ($current_page_name == 'login_usuario.php') {
        $active_item = 'login_usuario.php';
    }
}


$page_title = 'Mundo Verde';
if ($current_page_name == 'index.php') $page_title = 'Início - Mundo Verde';
elseif ($current_page_name == 'sobre.php') $page_title = 'Sobre - Mundo Verde';
elseif ($current_page_name == 'produtos.php') $page_title = 'Produtos - Mundo Verde';
elseif ($current_page_name == 'novidade.php') $page_title = 'Novidades - Mundo Verde';
elseif ($current_page_name == 'cadastro.php') $page_title = 'Cadastro - Mundo Verde';
elseif ($current_page_name == 'carrinho.php') $page_title = 'Carrinho - Mundo Verde';
elseif ($current_page_name == 'login_usuario.php') $page_title = 'Login de Usuário - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'login.php') $page_title = 'Login Admin - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'dashboard.php') $page_title = 'Painel Admin - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'gerenciar_produtos.php') $page_title = 'Gerenciar Produtos - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'novidades.php') $page_title = 'Gerenciar Novidades - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'administradores.php') $page_title = 'Gerenciar Admins - Mundo Verde';
elseif ($is_admin_page && $current_page_name == 'gerenciar_usuarios.php') $page_title = 'Gerenciar Usuários - Mundo Verde';


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="<?= $is_admin_page ? '../style.css' : 'style.css'; ?>"> 

</head>
<body>
    <header>
        <div class="logo">
            <h1><a href="<?= $is_admin_page ? '../index.php' : 'index.php'; ?>" class="header-link">Mundo Verde</a></h1>
        </div>
        
        <nav class="nav">
            <ul>
                <li><a href="<?= $is_admin_page ? '../index.php' : 'index.php'; ?>" class="<?= ($active_item == 'index.php') ? 'active-nav' : ''; ?>">Início</a></li>
                <li><a href="<?= $is_admin_page ? '../sobre.php' : 'sobre.php'; ?>" class="<?= ($active_item == 'sobre.php') ? 'active-nav' : ''; ?>">Sobre</a></li>
                <li><a href="<?= $is_admin_page ? '../produtos.php' : 'produtos.php'; ?>" class="<?= ($active_item == 'produtos.php') ? 'active-nav' : ''; ?>">Produtos</a></li>
                <li><a href="<?= $is_admin_page ? '../novidade.php' : 'novidade.php'; ?>" class="<?= ($active_item == 'novidade.php') ? 'active-nav' : ''; ?>">Novidades</a></li>
                <li><a href="<?= $is_admin_page ? '../carrinho.php' : 'carrinho.php'; ?>" class="<?= ($active_item == 'carrinho.php') ? 'active-nav' : ''; ?>">Carrinho</a></li>

                <?php if (isset($_SESSION['logado'])):?>
                <li><a href="<?= $is_admin_page ? 'dashboard.php' : 'Admin/dashboard.php'; ?>" class="<?= ($active_item == 'dashboard.php' || $current_page_name == 'gerenciar_produtos.php' || $current_page_name == 'novidades.php' || $current_page_name == 'administradores.php' || $current_page_name == 'gerenciar_usuarios.php') ? 'active-nav' : ''; ?>">Painel</a></li>
                <li><a href="<?= $is_admin_page ? '../Admin/logout.php' : 'Admin/logout.php'; ?>">Sair</a></li>

                <?php elseif (isset($_SESSION['usuario_logado_id'])): ?>
                <li><a href="<?= $is_admin_page ? '../logout_usuario.php' : 'logout_usuario.php'; ?>">Sair</a></li>
                <?php else: ?>
                <li><a href="<?= $is_admin_page ? '../login_usuario.php' : 'login_usuario.php'; ?>" class="<?= ($active_item == 'login_usuario.php') ? 'active-nav' : ''; ?>">Login</a></li>
                <li><a href="<?= $is_admin_page ? 'login.php' : 'Admin/login.php'; ?>" class="<?= ($active_item == 'Admin_login.php') ? 'active-nav' : ''; ?>">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>