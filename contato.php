<?php
session_start(); // Inicia a sessão PHP, se necessário para outras partes do seu site
include 'includes/header.php'; // Inclui o header.php que conterá a navbar e a abertura do <body>
?>

<!-- Importante: O CSS do Bootstrap deve ser carregado no includes/header.php ou ANTES do seu estilo.css -->
<!-- Se você já tem o link do Bootstrap CSS no seu header.php, pode remover esta linha daqui para evitar duplicação. -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Seu CSS personalizado (DEVE VIR DEPOIS DO BOOTSTRAP para que seus estilos sobrescrevam) -->
<link rel="stylesheet" href="assets/css/estilo.css">
<!-- Link para Bootstrap Icons (ADICIONADO AQUI) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<!-- Seção de Contato -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Coluna da Esquerda: Canais de Comunicação -->
            <!-- Adicionamos 'pe-md-5' para padding-right em telas médias e maiores, afastando da coluna da direita -->
            <div class="col-md-6 mb-4 mb-md-0 pe-md-5">
                <h2 class="display-6 text-primary mb-4">Canais de Comunicação</h2>
                
                <p class="lead">Entre em contato conosco através dos seguintes canais:</p>

                <ul class="list-unstyled">
                    <li class="mb-3">
                        <h5 class="text-secondary">Telefone:</h5>
                        <p>(19) 3561-3293</p>
                    </li>
                    <li class="mb-3">
                        <h5 class="text-secondary">E-mail:</h5>
                        <p>contato@jcmontagem.com.br</p>
                    </li>
                    <li class="mb-3">
                        <h5 class="text-secondary">Endereço:</h5>
                        <p>Rua Oswaldo Tuckmantel, Jd. Terra Azul, Pirassununga - São Paulo, CEP: 13630-000</p>
                    </li>
                    <li class="mb-3">
                        <h5 class="text-secondary">Redes Sociais:</h5>
                        <p>
                            <!-- Ícones do Instagram e LinkedIn com classes Bootstrap Icons -->
                            <a href="#" class="text-primary me-3" style="font-size: 2.5rem;"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-primary" style="font-size: 2.5rem;"><i class="bi bi-linkedin"></i></a>
                        </p>
                    </li>
                </ul>
            </div>

            <!-- Coluna da Direita: Imagem do Endereço (Mapa) -->
            <!-- Adicionamos 'ps-md-5' para padding-left em telas médias e maiores, afastando da coluna da esquerda -->
            <div class="col-md-6 ps-md-5">
                <h2 class="display-6 text-primary mb-4">Nosso Endereço</h2>
                <!-- Imagem do mapa ou localização -->
                <img src="src/img/imagem9.png" class="img-fluid rounded shadow-lg" alt="Localização da Empresa">
                <!-- Opcional: Adicionar um link para o Google Maps -->
                <a href="https://www.google.com/maps/place/JC+Montagens+Industriais/@-21.973597,-47.419521,20.56z/data=!4m14!1m7!3m6!1s0x94c801653efaeceb:0xfea50f6bab7ab4c4!2sGodoy+Beer+-+Bebidas+e+Conveniências!8m2!3d-21.9734857!4d-47.4197168!16s%2Fg%2F11j6m_nvmv!3m5!1s0x94c801c567faeb57:0xfb63c361671e7a9d!8m2!3d-21.9735432!4d-47.4195306!16s%2Fg%2F11jb5bm29w?entry=ttu&g_ep=EgoyMDI1MDYyNi4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn btn-outline-primary mt-2 d-block mx-auto" style="max-width: 250px;">Ver no Google Maps</a>
            </div>
        </div>
    </div>
</section>

<!-- Link para o JavaScript do Bootstrap (coloque antes do fechamento do </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhyMDFGlw2V8T2jXQW2q+6S/JzF1R" crossorigin="anonymous"></script>
<?php include 'includes/footer.php'; // Inclui o footer.php que conterá o fechamento do <body> e <html> ?>
