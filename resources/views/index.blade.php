<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sage | Cuidado que se veste</title>
    <meta name="description" content="Sage é o colete inteligente para idosos com Edge AI, detecção de quedas e monitoramento de sinais vitais. Cuidado invisível e contínuo.">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="/assets/css/styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    <header id="navbar">
        <div class="container nav-container">
            <div class="logo">
                <a href="{{ route('home') }}" class="logo-link" style="display: flex; align-items: center; gap: 8px; color: inherit; text-decoration: none;">
                    <i data-lucide="shield-check" class="logo-icon"></i>
                    <span>Sage</span>
                </a>
            </div>
            <nav class="nav-links">
                <a href="#problema">O Problema</a>
                <a href="#solucao">A Solução</a>
                <a href="#funcionalidades">Funcionalidades</a>
                <a href="#como-funciona">Como Funciona</a>
                <a href="#faq">FAQ</a>
            </nav>
            <div style="display: flex; gap: 16px; align-items: center;">
                <button id="login-btn-nav" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.95rem; cursor: pointer;">Login</button>
                <button id="register-btn-nav" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.95rem; cursor: pointer;">Criar Conta</button>
                <a href="{{ route('loja') }}" class="btn btn-primary">Adquirir o Sage</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-bg-glow"></div>
        <div class="container hero-container">
            <div class="hero-content">
                <h1 class="animate-up">Cuidado que se <span>veste.</span></h1>
                <p class="animate-up delay-1">O primeiro colete inteligente que protege quem você ama com tecnologia Edge AI. Monitoramento de quedas e sinais vitais com total discrição e conforto.</p>
                <div class="hero-actions animate-up delay-2">
                    <a href="{{ route('loja') }}" class="btn btn-primary btn-lg">Proteger Agora</a>
                    <a href="#solucao" class="btn btn-outline btn-lg">Conheça a Tecnologia</a>
                </div>
            </div>
            <div class="hero-visual animate-fade-in delay-2">
                <img src="/assets/img/hero_elderly.png" alt="Idoso vestindo o colete Sage com conforto e discrição" class="hero-image">
            </div>
        </div>
    </section>

    <!-- O Problema -->
    <section id="problema" class="problem-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="reveal">Por que o Sage existe?</h2>
                <p class="reveal">A cada segundo, uma família vive a angústia da incerteza. Quedas são a principal causa de acidentes entre idosos.</p>
            </div>
            <div class="stats-grid">
                <div class="stat-card reveal">
                    <i data-lucide="activity" class="stat-icon"></i>
                    <h3 class="counter" data-target="30">0</h3><span>%</span>
                    <p>Dos idosos sofrem quedas anualmente, muitas vezes sem ajuda imediata.</p>
                </div>
                <div class="stat-card reveal">
                    <i data-lucide="clock" class="stat-icon"></i>
                    <h3 class="counter" data-target="80">0</h3><span>%</span>
                    <p>De redução em complicações quando o socorro chega nos primeiros minutos.</p>
                </div>
                <div class="stat-card reveal">
                    <i data-lucide="heart-crack" class="stat-icon"></i>
                    <h3>Angústia Constante</h3>
                    <p>O medo das famílias em deixar seus entes queridos sozinhos afeta a qualidade de vida de todos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- A Solução Sage -->
    <section id="solucao" class="solution-section section-padding">
        <div class="container">
            <div class="solution-grid">
                <div class="solution-visual reveal">
                    <div class="vest-mockup">
                        <img src="/assets/img/vest_product.png" alt="Renderização 3D do colete inteligente Sage com sensores" class="vest-image">
                    </div>
                </div>
                <div class="solution-content">
                    <h2 class="reveal">A tecnologia invisível que salva vidas.</h2>
                    <p class="reveal">O Sage não é apenas um monitor. É uma peça de vestuário confortável, lavável e equipada com sensores de precisão clínica e Inteligência Artificial embarcada (Edge AI).</p>
                    
                    <ul class="feature-list">
                        <li class="reveal">
                            <i data-lucide="eye-off"></i>
                            <div>
                                <h4>100% Discreto e Confortável</h4>
                                <p>Feito com tecidos respiráveis e flexíveis. Pode ser usado sob qualquer roupa sem ser notado.</p>
                            </div>
                        </li>
                        <li class="reveal">
                            <i data-lucide="shield-ban"></i>
                            <div>
                                <h4>Privacidade Absoluta (Edge AI)</h4>
                                <p>Os dados são processados no próprio colete, não enviamos áudio ou imagens para a nuvem. Apenas os alertas essenciais chegam até você.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Funcionalidades -->
    <section id="funcionalidades" class="features-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="reveal">Monitoramento Clínico Completo</h2>
                <p class="reveal">Uma verdadeira UTI invisível vestida por quem você mais ama, 24 horas por dia.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-box reveal">
                    <div class="feature-icon-wrapper pulse-danger">
                        <i data-lucide="person-standing"></i>
                    </div>
                    <h3>Detecção de Quedas</h3>
                    <p>Algoritmos avançados que identificam quedas e enviam alertas automáticos em segundos para os contatos de emergência.</p>
                </div>
                <div class="feature-box reveal">
                    <div class="feature-icon-wrapper pulse-primary">
                        <i data-lucide="heart-pulse"></i>
                    </div>
                    <h3>Monitoramento Cardíaco</h3>
                    <p>Acompanhamento contínuo da frequência cardíaca, detectando arritmias ou picos anormais.</p>
                </div>
                <div class="feature-box reveal">
                    <div class="feature-icon-wrapper pulse-info">
                        <i data-lucide="droplet"></i>
                    </div>
                    <h3>Oximetria (SpO2)</h3>
                    <p>Monitora os níveis de oxigênio no sangue, prevenindo episódios de hipóxia silenciosa.</p>
                </div>
                <div class="feature-box reveal">
                    <div class="feature-icon-wrapper pulse-warning">
                        <i data-lucide="thermometer"></i>
                    </div>
                    <h3>Temperatura Corporal</h3>
                    <p>Termômetro integrado que identifica estados febris precocemente, evitando infecções graves.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Como Funciona -->
    <section id="como-funciona" class="how-it-works-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="reveal">Tão simples quanto vestir uma camisa.</h2>
            </div>
            
            <div class="steps-container">
                <div class="step reveal">
                    <div class="step-number">1</div>
                    <i data-lucide="shirt" class="step-icon"></i>
                    <h3>Vestir</h3>
                    <p>O idoso veste o colete Sage confortavelmente como uma roupa íntima diária.</p>
                </div>
                <div class="step-line"></div>
                <div class="step reveal delay-1">
                    <div class="step-number">2</div>
                    <i data-lucide="wifi" class="step-icon"></i>
                    <h3>Conectar</h3>
                    <p>O colete sincroniza automaticamente com o aplicativo da família via Wi-Fi ou Bluetooth.</p>
                </div>
                <div class="step-line"></div>
                <div class="step reveal delay-2">
                    <div class="step-number">3</div>
                    <i data-lucide="smartphone" class="step-icon"></i>
                    <h3>Monitorar</h3>
                    <p>Receba dados vitais e alertas instantâneos de emergência no seu celular, onde estiver.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Depoimentos -->
    <section id="depoimentos" class="testimonials-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="reveal">Histórias Reais de Alívio e Segurança</h2>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card reveal">
                    <i data-lucide="quote" class="quote-icon"></i>
                    <p>"Meu pai mora sozinho. Depois de uma queda na madrugada, decidimos comprar o Sage. Hoje eu durmo tranquila sabendo que serei avisada na hora se algo acontecer."</p>
                    <div class="testimonial-author">
                        <div class="avatar">M</div>
                        <div>
                            <h4>Mariana Silva</h4>
                            <span>Filha de usuário, 42 anos</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal delay-1">
                    <i data-lucide="quote" class="quote-icon"></i>
                    <p>"Eu não queria usar nenhum aparelho porque me sentia vigiado. Mas o colete é tão leve que eu esqueço que estou usando. E minha família fica em paz."</p>
                    <div class="testimonial-author">
                        <div class="avatar">J</div>
                        <div>
                            <h4>João Pedro</h4>
                            <span>Usuário Sage, 67 anos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="faq-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="reveal">Perguntas Frequentes</h2>
            </div>
            
            <div class="faq-container reveal">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Como lavo o colete? Preciso tirar algum aparelho?</h3>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>O colete Sage é composto por um tecido lavável e um módulo principal de processamento destacável. Basta retirar o pequeno módulo antes de colocar a peça na máquina de lavar. O tecido com os fios condutores é feito para resistir a centenas de lavagens.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Qual a duração da bateria?</h3>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>A bateria dura em média 5 dias de uso contínuo, graças ao processamento eficiente da tecnologia Edge AI. O recarregamento completo leva apenas 2 horas.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Funciona fora de casa sem Wi-Fi?</h3>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sim! O Sage possui conexão via Bluetooth com o celular do usuário. Se o celular estiver por perto com internet móvel, os alertas serão enviados normalmente para a família em qualquer lugar do mundo.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>A câmera ou microfone pode me gravar?</h3>
                        <i data-lucide="chevron-down" class="faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Não. O Sage NÃO possui câmeras ou microfones. Nós valorizamos sua privacidade. Todos os sensores são biométricos e inerciais (movimento), e o processamento é local.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-final-section section-padding">
        <div class="cta-glow"></div>
        <div class="container text-center reveal">
            <h2>Pronto para proteger quem você ama?</h2>
            <p>Garanta a segurança e o monitoramento avançado com o colete inteligente Sage.</p>
            <a href="{{ route('loja') }}" class="btn btn-primary btn-lg mt-4">Comprar o Colete Sage</a>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="login-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Acesso Restrito</h3>
                <button id="close-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email">E-mail</label>
                        <input type="email" id="login-email" required placeholder="admin@sage.com ou user@sage.com">
                    </div>
                    <div class="form-group">
                        <label for="login-password">Senha</label>
                        <input type="password" id="login-password" required placeholder="admin ou user">
                    </div>
                    <p id="login-error" class="error-msg hidden" style="color: var(--danger); font-size: 0.85rem; margin-top: 8px;">Credenciais inválidas.</p>
                    <button type="submit" class="btn btn-primary btn-full mt-4" style="width: 100%;">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="register-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Crie sua conta</h3>
                <button id="close-register-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="register-form">
                    <!-- Progress Bar -->
                    <div class="register-progress" style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 0.85rem; color: var(--text-secondary);">
                        <span id="step1-indicator" style="color: var(--primary); font-weight: bold;">1. Conta</span>
                        <span id="step2-indicator">2. Paciente</span>
                        <span id="step3-indicator">3. Ficha Médica</span>
                    </div>

                    <!-- Step 1: Conta (Cuidador) -->
                    <div id="register-step-1" class="register-step">
                        <div class="form-group">
                            <label for="register-name">Seu Nome (Cuidador/Responsável)</label>
                            <input type="text" id="register-name" required placeholder="Seu nome completo">
                        </div>
                        <div class="form-group">
                            <label for="register-email">E-mail</label>
                            <input type="email" id="register-email" required placeholder="seu@email.com">
                        </div>
                        <div class="form-group">
                            <label for="register-password">Senha</label>
                            <input type="password" id="register-password" required placeholder="Mínimo 6 caracteres">
                        </div>
                        <div class="form-group">
                            <label for="register-password-confirm">Confirmar senha</label>
                            <input type="password" id="register-password-confirm" required placeholder="Repita a senha">
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label" style="display: flex; gap: 10px; align-items: center;">
                                <input type="checkbox" id="register-admin">
                                <span>Quero criar uma conta de administrador (não precisa preencher paciente)</span>
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary btn-full mt-4" id="btn-next-1" style="width: 100%;">Próximo</button>
                    </div>

                    <!-- Step 2: Paciente (Idoso) -->
                    <div id="register-step-2" class="register-step" style="display: none;">
                        <div class="form-group">
                            <label for="register-paciente-nome">Nome do Paciente (Idoso)</label>
                            <input type="text" id="register-paciente-nome" placeholder="Nome completo do paciente">
                        </div>
                        <div class="form-group">
                            <label for="register-paciente-cpf">CPF do Paciente</label>
                            <input type="text" id="register-paciente-cpf" placeholder="000.000.000-00">
                        </div>
                        <div class="form-group">
                            <label for="register-paciente-nascimento">Data de Nascimento</label>
                            <input type="date" id="register-paciente-nascimento">
                        </div>
                        <div class="form-group">
                            <label for="register-paciente-telefone">Telefone de Contato</label>
                            <input type="text" id="register-paciente-telefone" placeholder="(11) 90000-0000">
                        </div>
                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="button" class="btn btn-outline" id="btn-prev-2" style="flex: 1;">Voltar</button>
                            <button type="button" class="btn btn-primary" id="btn-next-2" style="flex: 1;">Próximo</button>
                        </div>
                    </div>

                    <!-- Step 3: Ficha Médica -->
                    <div id="register-step-3" class="register-step" style="display: none;">
                        <div class="form-group">
                            <label for="register-tipo-sanguineo">Tipo Sanguíneo</label>
                            <select id="register-tipo-sanguineo" class="input-field" style="width: 100%;">
                                <option value="">Não sei / Não informar</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="register-condicoes">Condições Médicas (Ex: Diabetes, Hipertensão)</label>
                            <textarea id="register-condicoes" rows="2" class="input-field" placeholder="Liste as condições médicas" style="width: 100%; resize: vertical;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="register-alergias">Alergias</label>
                            <textarea id="register-alergias" rows="2" class="input-field" placeholder="Medicamentos, alimentos, etc" style="width: 100%; resize: vertical;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="register-medicamentos">Medicamentos de Uso Contínuo</label>
                            <textarea id="register-medicamentos" rows="2" class="input-field" placeholder="Liste os medicamentos e horários" style="width: 100%; resize: vertical;"></textarea>
                        </div>

                        <p id="register-error" class="error-msg hidden" style="color: var(--danger); font-size: 0.85rem; margin-top: 8px;">Preencha todos os campos obrigatórios corretamente.</p>
                        <div style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="button" class="btn btn-outline" id="btn-prev-3" style="flex: 1;">Voltar</button>
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Criar Conta</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3" style="font-size: 0.95rem; color: #5b5b5b; text-align: center;">
                    Já tem conta? <button id="open-login-from-register" class="btn btn-link" type="button" style="padding: 0; border: none; background: transparent; color: inherit; text-decoration: underline; cursor: pointer;">Entrar</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="footer-brand">
                <div class="logo">
                    <i data-lucide="shield-check" class="logo-icon"></i>
                    <span>Sage</span>
                </div>
                <p>Cuidado invisível. Proteção contínua. Inovação que salva vidas e traz paz para a família. Farmar aura faz parte do nosso sonho!</p>
            </div>
            <div class="footer-links">
                <h4>Links Rápidos</h4>
                <a href="#problema">O Problema</a>
                <a href="#solucao">A Solução</a>
                <a href="#funcionalidades">Funcionalidades</a>
                <a href="#faq">FAQ</a>
            </div>
            <div class="footer-contact">
                <h4>Contato</h4>
                <a href="mailto:contato@sagewearable.com">contato@sagewearable.com</a>
                <a href="tel:+5511999999999">(31) 92469-6742</a>
                <div class="social-links mt-2">
                    <a href="#"><i data-lucide="instagram"></i></a>
                    <a href="#"><i data-lucide="linkedin"></i></a>
                    <a href="#"><i data-lucide="facebook"></i></a>
                </div>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>&copy; 2026 Sage Wearable. Todos os direitos reservados.</p>
            <div class="legal-links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('script.js') }}"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
