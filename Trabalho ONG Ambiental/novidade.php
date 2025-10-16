<?php
include 'header.php'; 

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $inatividade = 120; 
    if (time() - $_SESSION['LAST_ACTIVITY'] > $inatividade) {
        session_unset(); 
        session_destroy();  
    } else {
        $_SESSION['LAST_ACTIVITY'] = time(); 
    }
}

include('Admin/conexao.php'); 

$novidades_publicas = $conn->query("SELECT id, titulo , conteudo, data_publicacao FROM novidades ORDER BY data_publicacao DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">

    <body>
        <main class="container my-5">
            
            <section class="news-section">
                <div class="news-hero-section"> 
                    <img src="img/MundoVerdeNovidade.png" alt="Imagem principal de Novidades" style="object-position: center bottom;">
                    <div class="news-hero-text"> 
                        <h2>Nossas Novidades</h2>
                        <p>Fique por dentro das últimas ações, eventos e campanhas da nossa ONG.</p>
                    </div>
                </div>

                <div class="news-list list-group">
                    <?php if ($novidades_publicas && $novidades_publicas->num_rows > 0): ?>
                        <?php while($n = $novidades_publicas->fetch_assoc()): ?>
                            <a href="#" class="list-group-item news-item"> 
                                <h5 class="mb-1 text-primary"><?= htmlspecialchars($n['titulo']) ?></h5>
                                <small>Publicado em <?= date('d/m/Y H:i', strtotime($n['data_publicacao'])) ?></small>
                                <p class="mb-1"><?= htmlspecialchars($n['conteudo']) ?></p>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center" role="alert">
                            Nenhuma novidade disponível no momento.
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        
        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>