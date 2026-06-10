<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Sage | Loja Oficial</title>
    <meta name="description" content="Adquira o colete inteligente Sage e escolha o plano ideal para a segurança da sua família.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="store-page">
    <!-- Navbar -->
    <header id="navbar" class="scrolled">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
                <i data-lucide="shield-check" class="logo-icon"></i>
                <span>Sage</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('home') }}#problema">O Problema</a>
                <a href="{{ route('home') }}#solucao">A Solução</a>
                <a href="{{ route('home') }}#funcionalidades">Funcionalidades</a>
                <a href="{{ route('home') }}#faq">FAQ</a>
            </nav>
            <a href="{{ route('home') }}" class="btn btn-outline">Voltar ao Início</a>
        </div>
    </header>

    <main class="store-main section-padding">
        <div class="container">
            <h1 class="store-title">Configure seu <span>Sage</span></h1>
            
            <div class="store-grid">
                <!-- Left Column: Product Configuration -->
                <div class="store-config">
                    <!-- Product Visual -->
                    <div class="product-gallery">
                        <div class="product-image-container">
                            <img src="/assets/img/sage_vest_preto_onix.png" alt="Colete Sage" class="product-main-img" id="product-img">
                        </div>
                    </div>

                    <!-- Configurator -->
                    <div class="config-section">
                        <h3>1. Cor do Colete</h3>
                        <div class="color-selector">
                            <label class="color-option">
                                <input type="radio" name="color" value="Preto Ônix" checked>
                                <span class="color-swatch" style="background: #1a1a1a;"></span>
                                <span class="color-name">Preto Ônix</span>
                            </label>
                            <label class="color-option">
                                <input type="radio" name="color" value="Azul Marinho">
                                <span class="color-swatch" style="background: #1e3a5f;"></span>
                                <span class="color-name">Azul Marinho</span>
                            </label>
                            <label class="color-option">
                                <input type="radio" name="color" value="Branco Gelo">
                                <span class="color-swatch" style="background: #f0f0f0; border: 1px solid #ccc;"></span>
                                <span class="color-name">Branco Gelo</span>
                            </label>
                        </div>
                    </div>

                    <div class="config-section">
                        <h3>2. Tamanho</h3>
                        <div class="size-selector">
                            <label class="size-option">
                                <input type="radio" name="size" value="P">
                                <span class="size-label">P</span>
                            </label>
                            <label class="size-option">
                                <input type="radio" name="size" value="M" checked>
                                <span class="size-label">M</span>
                            </label>
                            <label class="size-option">
                                <input type="radio" name="size" value="G">
                                <span class="size-label">G</span>
                            </label>
                            <label class="size-option">
                                <input type="radio" name="size" value="GG">
                                <span class="size-label">GG</span>
                            </label>
                        </div>
                        <a href="#" class="size-guide"><i data-lucide="ruler"></i> Guia de Tamanhos</a>
                    </div>

                    <div class="config-section">
                        <h3>3. Escolha o Plano</h3>
                        <div class="plan-selector">
                            <!-- Basic Plan -->
                            <label class="plan-card">
                                <input type="radio" name="plan" value="basico" data-price="1299" data-monthly="0">
                                <div class="plan-content">
                                    <div class="plan-header">
                                        <div class="plan-title">
                                            <h4>Básico</h4>
                                            <span>Uso Essencial</span>
                                        </div>
                                        <div class="plan-price">R$ 0<span>/mês</span></div>
                                    </div>
                                    <ul class="plan-features">
                                        <li><i data-lucide="check"></i> Hardware incluído (R$ 1.299)</li>
                                        <li><i data-lucide="check"></i> Monitoramento via App</li>
                                        <li><i data-lucide="check"></i> Alertas push simples</li>
                                    </ul>
                                </div>
                            </label>

                            <!-- Premium Plan -->
                            <label class="plan-card recommended">
                                <div class="badge">Mais Escolhido</div>
                                <input type="radio" name="plan" value="premium" data-price="1299" data-monthly="49" checked>
                                <div class="plan-content">
                                    <div class="plan-header">
                                        <div class="plan-title">
                                            <h4>Premium (SaaS)</h4>
                                            <span>Tranquilidade Total</span>
                                        </div>
                                        <div class="plan-price">R$ 49<span>/mês</span></div>
                                    </div>
                                    <ul class="plan-features">
                                        <li><i data-lucide="check"></i> Hardware incluído (R$ 1.299)</li>
                                        <li><i data-lucide="check"></i> Relatórios Clínicos Completos</li>
                                        <li><i data-lucide="check"></i> Ligações Automáticas em Emergências</li>
                                        <li><i data-lucide="check"></i> Histórico de 30 dias</li>
                                    </ul>
                                </div>
                            </label>

                            <!-- HaaS Plan -->
                            <label class="plan-card">
                                <input type="radio" name="plan" value="haas" data-price="0" data-monthly="149">
                                <div class="plan-content">
                                    <div class="plan-header">
                                        <div class="plan-title">
                                            <h4>Assinatura Total (HaaS)</h4>
                                            <span>Sem Custo Inicial</span>
                                        </div>
                                        <div class="plan-price">R$ 149<span>/mês</span></div>
                                    </div>
                                    <ul class="plan-features">
                                        <li><i data-lucide="check"></i> Colete Alugado (Custo Zero)</li>
                                        <li><i data-lucide="check"></i> Troca grátis de tamanho</li>
                                        <li><i data-lucide="check"></i> Seguro contra danos</li>
                                        <li><i data-lucide="check"></i> Todos os benefícios Premium</li>
                                    </ul>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Cart & Checkout -->
                <div class="store-sidebar">
                    <div class="checkout-panel">
                        <h3>Resumo do Pedido</h3>
                        
                        <div class="cart-items">
                            <div class="cart-item">
                                <div class="cart-item-info">
                                    <h4>Colete Sage</h4>
                                    <p id="summary-options">Preto Ônix • Tamanho M</p>
                                </div>
                                <div class="cart-item-price" id="summary-hardware-price">R$ 1.299,00</div>
                            </div>
                            <div class="cart-item">
                                <div class="cart-item-info">
                                    <h4 id="summary-plan-name">Plano Premium</h4>
                                    <p>Assinatura Mensal</p>
                                </div>
                                <div class="cart-item-price" id="summary-plan-price">R$ 49,00</div>
                            </div>
                        </div>

                        <!-- Shipping Calculator -->
                        <div class="shipping-calculator">
                            <label>Calcular Frete</label>
                            <div class="shipping-input">
                                <input type="text" placeholder="00000-000" id="cep-input" maxlength="9">
                                <button type="button" id="calc-frete-btn">Calcular</button>
                            </div>
                            <div id="shipping-results" class="shipping-results hidden">
                                <label class="shipping-option">
                                    <input type="radio" name="shipping" value="0" checked>
                                    <span>Frete Grátis (7-10 dias)</span>
                                    <span>R$ 0,00</span>
                                </label>
                                <label class="shipping-option">
                                    <input type="radio" name="shipping" value="35">
                                    <span>Sedex (2-3 dias)</span>
                                    <span>R$ 35,00</span>
                                </label>
                            </div>
                        </div>

                        <div class="cart-totals">
                            <div class="total-row">
                                <span>Subtotal Hoje</span>
                                <strong id="total-today">R$ 1.299,00</strong>
                            </div>
                            <div class="total-row highlight">
                                <span>Cobrança Mensal</span>
                                <strong id="total-monthly">R$ 49,00/mês</strong>
                            </div>
                        </div>

                        <!-- Checkout Methods -->
                        <div class="checkout-methods">
                            <h4>Método de Pagamento (Hoje)</h4>
                            <div class="payment-tabs">
                                <button class="tab-btn active" data-target="cc">Cartão</button>
                                <button class="tab-btn" data-target="pix">Pix</button>
                                <button class="tab-btn" data-target="boleto">Boleto</button>
                            </div>

                            <div class="payment-content active" id="cc-form">
                                <input type="text" class="input-field" placeholder="Número do Cartão">
                                <div class="input-row">
                                    <input type="text" class="input-field" placeholder="MM/AA">
                                    <input type="text" class="input-field" placeholder="CVC">
                                </div>
                                <input type="text" class="input-field" placeholder="Nome no Cartão">
                            </div>

                            <div class="payment-content" id="pix-form">
                                <div class="pix-mockup">
                                    <i data-lucide="qr-code"></i>
                                    <p>O QR Code será gerado após a confirmação do pedido.</p>
                                    <span class="discount-badge">5% de Desconto no Hardware</span>
                                </div>
                            </div>

                            <div class="payment-content" id="boleto-form">
                                <div class="boleto-mockup">
                                    <i data-lucide="file-text"></i>
                                    <p>O boleto será enviado para o seu e-mail.</p>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block checkout-btn" id="finish-btn">
                            <i data-lucide="lock"></i> Finalizar Compra Segura
                        </button>
                        <p class="secure-text"><i data-lucide="shield-check"></i> Pagamento processado de forma segura e criptografada.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Lite for Checkout -->
    <footer style="padding-top: 40px;">
        <div class="container footer-bottom">
            <p>&copy; 2026 Sage Wearable. Todos os direitos reservados.</p>
            <div class="legal-links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
            </div>
        </div>
    </footer>

    <script src="/assets/js/script.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
