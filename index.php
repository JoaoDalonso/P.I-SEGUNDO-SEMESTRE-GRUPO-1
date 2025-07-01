<?php include 'includes/header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
        #imageTextCarousel .carousel-inner {
            min-height: 400px;
        }

        #imageTextCarousel .carousel-item img {
            height: 400px;
            object-fit: cover; 
            width: 100%; 
        }
    
        #imageTextCarousel .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5); 
            padding: 10px;
            border-radius: 5px;
            bottom: 20px; 
            left: 50%;
            transform: translateX(-50%);
            width: 90%; 
}
</style>
<section class="hero"><div class="container">
<h1>JC MONTAGENS</h1><p>Excelência em Montagens Industriais</p>
<a href="agendar.php"class="btn btn-primary btn-lg mt-3">Agende Já</a></div></section>



<div class="container my-5">
        
        <div class="row align-items-center">
            
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- Início do Carrossel -->
                <div id="imageTextCarousel" class="carousel slide rounded shadow" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#imageTextCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#imageTextCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#imageTextCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="src/img/imagem1.png" class="d-block w-100" alt="Imagem Carrossel 1">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Revestimentos de Tanques</h5>
                                <p>Revestimento de tanque de aço carbono em aço inox.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="src/img/imagem2.png" class="d-block w-100" alt="Imagem Carrossel 2">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Reformas Gerais</h5>
                                <p>Trabalhamos com solda no processo TIG.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="src/img/imagem3.png" class="d-block w-100" alt="Imagem Carrossel 3">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Tubulações Industriais</h5>
                                <p>Oferecemos um serviço voltado para indústrias de médio e grande porte.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageTextCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageTextCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
                <!-- Fim do Carrossel -->
            </div>

            
            <div class="col-md-6">
               
                <h2 class="display-6 text-primary mb-3">Soluções para montagens industriais</h2>
                <p class="lead">A transparência e comprometimento, alinhada à capacitação técnica da nossa equipe, gerenciada por modernas práticas de planejamento, 
                    logística, segurança e qualidade, nos permite estabelecer relacionamentos de mútua confiança com nossos clientes, oferecendo as melhores soluções de 
                    montagem industrial, manutenção, caldeiraria e construção para os diversos segmentos da indústria.</p>

                <p class="lead">
                A empresa conta com uma grande experiência de seus proprietários no ramo adquirido ao longo de mais de 15 anos trabalhando nas atividades relacionadas.
                </p>
                
                <a href="sobre.php" class="btn btn-primary btn-lg mt-3">Saiba Mais</a>
            </div>
        </div>
    </div>

    <section class="py-5">
    <div class="container">
        <h2 class="text-center display-6 text-primary mb-5">Nossos Serviços</h2>
        
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card shadow-lg rounded">
                    <img src="src/img/imagem6.png" class="card-img-top rounded-top" alt="Descrição da Imagem 1">
                    <div class="card-body">
                        <h5 class="card-title">Obra: Revestimento de Tanque</h5>
                        <p class="card-text">Revestimento de tanque de aço carbono em aço inox. Capacidade de tanque: 3.000 m³.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="card shadow-lg rounded">
                    <img src="src/img/imagem7.png" class="card-img-top rounded-top" alt="Descrição da Imagem 2">
                    <div class="card-body">
                        <h5 class="card-title">Obra: Construção de Tubulações</h5>
                        <p class="card-text">Obra realizada utilizando aço carbono e polietileno. Realizada em 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="card shadow-lg rounded">
                    <img src="src/img/imagem8.png" class="card-img-top rounded-top" alt="Descrição da Imagem 3">
                    <div class="card-body">
                        <h5 class="card-title">Serviço de Munck</h5>
                        <p class="card-text">Caminhão para transporte e movimentação de máquinas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhyMDFGlw2V8T2jXQW2q+6S/JzF1R" crossorigin="anonymous"></script>    
<?php include 'includes/footer.php'; ?>