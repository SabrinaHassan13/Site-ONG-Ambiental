<?php
include 'header.php'; 

if (isset($_SESSION['logado']) && isset($_SESSION['LAST_ACTIVITY'])) {
    $inatividade = 120; 
    if (time() - $_SESSION['LAST_ACTIVITY'] > $inatividade) {
        session_unset(); 
        session_destroy();  
    } else {
        $_SESSION['LAST_ACTIVITY'] = time(); 
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

    <body>
        <main class="container my-5 p-4 bg-white rounded shadow-sm">
            <h2 class="text-center mb-4">Sobre a ONG Mundo Verde</h2>

            <div class="content-section-block">
                <div class="text-block">
                    <h3>Nossa História e Missão</h3>
                    <p>Fundada em 2010, a ONG Ambiental Mundo Verde nasceu com o propósito inabalável de proteger ecossistemas ameaçados e educar a sociedade sobre práticas sustentáveis e a importância da preservação ambiental para as futuras gerações.</p>
                    <p>Desde o início, nossa missão tem sido conscientizar e agir pela preservação ambiental, promovendo a biodiversidade e o uso responsável dos recursos naturais.</p>
                </div>
                <img src="img/MundoVerdeInicio.png" alt="Membros da ONG trabalhando juntos em um projeto ambiental." class="img-fluid rounded shadow-sm">
            </div>

            <div class="content-section-block d-flex flex-column flex-md-row-reverse"> <div class="text-block">
                    <h3>Nossos Fundadores e Valores</h3>
                    <p>A Mundo Verde foi idealizada por Maria Silva e João Souza, dois apaixonados por natureza que uniram forças para transformar a realidade ambiental de nossa comunidade. Nossos valores são pautados na ética, transparência, paixão ambiental e no poder da colaboração.</p>
                    <p>Acreditamos que pequenas ações, quando multiplicadas, geram grandes impactos.</p>
                </div>
                <img src="img/CasalMundoVerde.png" alt="Pessoas plantando árvores em um reflorestamento." class="img-fluid rounded shadow-sm">
            </div>
            
            <div class="content-section-wide my-5">
                <img src="img/MundoVerde1500.png" alt="Equipe de voluntários sorrindo em meio à natureza." class="img-fluid">
                <div class="text-overlay">
                    <h3>Somos Mais de 1500 Voluntários!</h3>
                    <p>Somos uma comunidade crescente de pessoas apaixonadas pela causa ambiental.</p>
                     <p>   Junte-se a nós!</p>
                </div>
            </div>

        </main>

        <footer>
            <p> 2025 ONG Ambiental - Todos os direitos reservados - Mundo Verde</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>