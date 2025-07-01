</main> <!-- Fecha a tag <main> que foi aberta no header.php -->

<!-- Link para o JavaScript do Bootstrap (DEVE VIR ANTES do fechamento do </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhyMDFGlw2V8T2jXQW2q+6S/JzF1R" crossorigin="anonymous"></script>

<!-- Início do Rodapé -->
<footer class="site-footer py-5">
    <div class="container">
        <div class="row">
            <!-- Coluna 1: Sobre a Empresa (4 colunas em telas médias+) -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-white mb-3">Sobre a JC Montagens</h5>
                <p class="text-white-50">Excelência em montagens industriais, manutenção, caldeiraria e construção para diversos segmentos da indústria.</p>
                <p class="text-white-50">&copy; <?= date('Y') ?> JC MONTAGENS. Todos os direitos reservados.</p>
            </div>

            <!-- Coluna 2: Links Rápidos (4 colunas em telas médias+) -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-white mb-3">Links Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white-50 text-decoration-none py-1 d-block">Início</a></li>
                    <li><a href="sobre.php" class="text-white-50 text-decoration-none py-1 d-block">Sobre Nós</a></li>
                    <li><a href="contato.php" class="text-white-50 text-decoration-none py-1 d-block">Contato</a></li>
                    <li><a href="agendar.php" class="text-white-50 text-decoration-none py-1 d-block">Agendar</a></li>
                    <li><a href="ver_agendamentos.php" class="text-white-50 text-decoration-none py-1 d-block">Meus Agendamentos</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Contato e Redes Sociais (4 colunas em telas médias+) -->
            <div class="col-md-4">
                <h5 class="text-white mb-3">Contato</h5>
                <ul class="list-unstyled text-white-50">
                    <li><i class="bi bi-telephone-fill me-2"></i> (19) 3561-3293</li>
                    <li><i class="bi bi-envelope-fill me-2"></i> contato@jcmontagem.com.br</li>
                    <li><i class="bi bi-geo-alt-fill me-2"></i> Rua Oswaldo Tuckmantel, 123</li>
                    <li>Jd. Terra Azul, Pirassununga - SP</li>
                    <li>CEP: 13630-000</li>
                </ul>

                <div>
                    <!-- Ícone do WhatsApp adicionado -->
                    <a href="https://wa.me/551935613293" target="_blank" class="text-white" style="font-size: 1.8rem;"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-white-50"> <!-- Linha divisória -->
        <div class="text-center text-white-50">
            <p>Desenvolvido por JC Montagens. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
