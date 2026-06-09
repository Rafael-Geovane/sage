<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sage | Dashboard do Cuidador</title>
    <meta name="description" content="Painel de monitoramento em tempo real do colete Sage.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body class="dashboard-page">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i data-lucide="shield-check" class="logo-icon"></i>
                <span>Sage</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-item active" data-section="overview">
                <i data-lucide="layout-dashboard"></i><span>Visão Geral</span>
            </a>
            <a href="#" class="nav-item" data-section="health-history">
                <i data-lucide="chart-line"></i><span>Histórico de Saúde</span>
            </a>
            <a href="#" class="nav-item" data-section="event-log">
                <i data-lucide="list-checks"></i><span>Log de Eventos</span>
            </a>
            <a href="#" class="nav-item" data-section="alert-settings">
                <i data-lucide="bell-ring"></i><span>Alertas</span>
            </a>
            <a href="#" class="nav-item" data-section="contacts">
                <i data-lucide="users"></i><span>Contatos de Emergência</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" class="nav-item">
                <i data-lucide="arrow-left"></i><span>Voltar ao Site</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="dash-wrapper">
        <!-- Top Bar -->
        <header class="dash-topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menu-toggle"><i data-lucide="menu"></i></button>
                <h2>Painel do Cuidador</h2>
            </div>
            <div class="topbar-right">
                    <a href="{{ route('admin') }}" class="nav-item" data-section="admin-panel">
                        <i data-lucide="settings"></i><span>Painel</span>
                    </a>
                <div class="device-status online">
                    <span class="status-dot"></span> Colete Online
                </div>
                <div class="user-avatar">MS</div>
            </div>
        </header>

        <!-- Section: Overview -->
        <section class="dash-section active" id="section-overview">
            <div class="dash-greeting">
                <h1>Olá, Mariana 👋</h1>
                <p>Último dado recebido: <strong>há 12 segundos</strong></p>
            </div>

            <!-- Vital Cards -->
            <div class="vitals-grid">
                <div class="vital-card heart-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-primary"><i data-lucide="heart-pulse"></i></div>
                        <span class="vital-badge normal">Normal</span>
                    </div>
                    <div class="vital-value"><span id="bpm-value">72</span> <small>bpm</small></div>
                    <p class="vital-label">Frequência Cardíaca</p>
                    <div class="vital-chart-mini" id="heart-mini-chart">
                        <svg viewBox="0 0 200 40" preserveAspectRatio="none">
                            <polyline fill="none" stroke="currentColor" stroke-width="2"
                                points="0,20 15,20 25,10 35,30 45,20 60,20 75,20 85,8 95,32 105,20 120,20 135,20 145,12 155,28 165,20 180,20 200,20"/>
                        </svg>
                    </div>
                </div>
                <div class="vital-card spo2-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-info"><i data-lucide="droplet"></i></div>
                        <span class="vital-badge normal">Normal</span>
                    </div>
                    <div class="vital-value"><span id="spo2-value">97</span><small>%</small></div>
                    <p class="vital-label">Oxigenação (SpO2)</p>
                    <div class="vital-range">
                        <div class="range-bar" style="width: 97%;"></div>
                    </div>
                </div>
                <div class="vital-card temp-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-warning"><i data-lucide="thermometer"></i></div>
                        <span class="vital-badge normal">Normal</span>
                    </div>
                    <div class="vital-value"><span id="temp-value">36.4</span><small>°C</small></div>
                    <p class="vital-label">Temperatura Corporal</p>
                    <div class="vital-range">
                        <div class="range-bar warning-range" style="width: 60%;"></div>
                    </div>
                </div>
                <div class="vital-card fall-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-danger"><i data-lucide="person-standing"></i></div>
                        <span class="vital-badge ok">Seguro</span>
                    </div>
                    <div class="vital-value"><span>0</span></div>
                    <p class="vital-label">Quedas Detectadas Hoje</p>
                    <p class="vital-sub">Última queda: <strong>Nenhuma registrada</strong></p>
                </div>
            </div>

            <!-- Location Map -->
            <div class="map-section">
                <div class="map-header">
                    <h3><i data-lucide="map-pin"></i> Localização Atual</h3>
                    <span class="map-timestamp">Atualizado há 30s</span>
                </div>
                <div class="map-container">
                    <div class="map-placeholder">
                        <div class="map-pin-animated">
                            <i data-lucide="map-pin"></i>
                        </div>
                        <p>Rua das Flores, 123 — São Paulo, SP</p>
                        <span>Localização aproximada via Wi-Fi</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Health History -->
        <section class="dash-section" id="section-health-history">
            <h2>Histórico de Saúde</h2>
            <div class="history-tabs">
                <button class="htab active">Diário</button>
                <button class="htab">Semanal</button>
                <button class="htab">Mensal</button>
            </div>
            <div class="history-charts">
                <div class="chart-card">
                    <h4><i data-lucide="heart-pulse"></i> Frequência Cardíaca</h4>
                    <div class="chart-area">
                        <svg viewBox="0 0 600 150" preserveAspectRatio="none" class="line-chart">
                            <defs><linearGradient id="hg1" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#F43F5E" stop-opacity="0.3"/><stop offset="100%" stop-color="#F43F5E" stop-opacity="0"/></linearGradient></defs>
                            <polygon fill="url(#hg1)" points="0,150 0,90 50,85 100,95 150,70 200,80 250,65 300,75 350,90 400,60 450,70 500,85 550,80 600,75 600,150"/>
                            <polyline fill="none" stroke="#F43F5E" stroke-width="2.5" points="0,90 50,85 100,95 150,70 200,80 250,65 300,75 350,90 400,60 450,70 500,85 550,80 600,75"/>
                        </svg>
                        <div class="chart-labels"><span>00h</span><span>04h</span><span>08h</span><span>12h</span><span>16h</span><span>20h</span><span>Agora</span></div>
                    </div>
                </div>
                <div class="chart-card">
                    <h4><i data-lucide="droplet"></i> Oxigenação (SpO2)</h4>
                    <div class="chart-area">
                        <svg viewBox="0 0 600 150" preserveAspectRatio="none" class="line-chart">
                            <defs><linearGradient id="hg2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#3B82F6" stop-opacity="0.3"/><stop offset="100%" stop-color="#3B82F6" stop-opacity="0"/></linearGradient></defs>
                            <polygon fill="url(#hg2)" points="0,150 0,30 50,28 100,32 150,25 200,30 250,28 300,35 350,30 400,25 450,30 500,28 550,32 600,30 600,150"/>
                            <polyline fill="none" stroke="#3B82F6" stroke-width="2.5" points="0,30 50,28 100,32 150,25 200,30 250,28 300,35 350,30 400,25 450,30 500,28 550,32 600,30"/>
                        </svg>
                        <div class="chart-labels"><span>00h</span><span>04h</span><span>08h</span><span>12h</span><span>16h</span><span>20h</span><span>Agora</span></div>
                    </div>
                </div>
                <div class="chart-card">
                    <h4><i data-lucide="thermometer"></i> Temperatura</h4>
                    <div class="chart-area">
                        <svg viewBox="0 0 600 150" preserveAspectRatio="none" class="line-chart">
                            <defs><linearGradient id="hg3" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#F59E0B" stop-opacity="0.3"/><stop offset="100%" stop-color="#F59E0B" stop-opacity="0"/></linearGradient></defs>
                            <polygon fill="url(#hg3)" points="0,150 0,75 50,78 100,72 150,80 200,76 250,74 300,78 350,76 400,73 450,77 500,75 550,78 600,76 600,150"/>
                            <polyline fill="none" stroke="#F59E0B" stroke-width="2.5" points="0,75 50,78 100,72 150,80 200,76 250,74 300,78 350,76 400,73 450,77 500,75 550,78 600,76"/>
                        </svg>
                        <div class="chart-labels"><span>00h</span><span>04h</span><span>08h</span><span>12h</span><span>16h</span><span>20h</span><span>Agora</span></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Event Log -->
        <section class="dash-section" id="section-event-log">
            <h2>Log de Eventos</h2>
            <div class="event-filters">
                <button class="ef-btn active">Todos</button>
                <button class="ef-btn">Quedas</button>
                <button class="ef-btn">Alertas Cardíacos</button>
                <button class="ef-btn">SpO2</button>
            </div>
            <div class="event-list">
                <div class="event-item event-info">
                    <div class="event-icon"><i data-lucide="heart-pulse"></i></div>
                    <div class="event-content">
                        <h4>Frequência cardíaca elevada detectada</h4>
                        <p>Batimento registrado: <strong>112 bpm</strong> durante 3 minutos.</p>
                    </div>
                    <span class="event-time">Hoje, 14:32</span>
                </div>
                <div class="event-item event-warning">
                    <div class="event-icon"><i data-lucide="thermometer"></i></div>
                    <div class="event-content">
                        <h4>Temperatura levemente elevada</h4>
                        <p>Registrado <strong>37.6°C</strong>. Monitoramento contínuo ativado.</p>
                    </div>
                    <span class="event-time">Ontem, 22:15</span>
                </div>
                <div class="event-item event-danger">
                    <div class="event-icon"><i data-lucide="person-standing"></i></div>
                    <div class="event-content">
                        <h4>Queda detectada e alerta enviado</h4>
                        <p>Queda registrada às 08:42. Contatos Mariana e Carlos notificados via SMS e ligação.</p>
                    </div>
                    <span class="event-time">03/05/2026, 08:42</span>
                </div>
                <div class="event-item event-success">
                    <div class="event-icon"><i data-lucide="check-circle"></i></div>
                    <div class="event-content">
                        <h4>Dispositivo reconectado com sucesso</h4>
                        <p>O colete foi reconectado à rede Wi-Fi "Casa_Mendes".</p>
                    </div>
                    <span class="event-time">02/05/2026, 10:00</span>
                </div>
                <div class="event-item event-info">
                    <div class="event-icon"><i data-lucide="droplet"></i></div>
                    <div class="event-content">
                        <h4>SpO2 abaixo do ideal por breve período</h4>
                        <p>Oxigenação registrada em <strong>93%</strong> por 2 minutos. Voltou ao normal.</p>
                    </div>
                    <span class="event-time">01/05/2026, 03:18</span>
                </div>
            </div>
        </section>

        <!-- Section: Alert Settings -->
        <section class="dash-section" id="section-alert-settings">
            <h2>Configurações de Alerta</h2>
            <p class="section-desc">Defina os limites personalizados para receber notificações imediatas quando os valores saírem da faixa segura.</p>
            <div class="settings-grid">
                <div class="setting-card">
                    <div class="setting-header">
                        <i data-lucide="heart-pulse" class="s-icon heart"></i>
                        <h4>Frequência Cardíaca</h4>
                    </div>
                    <div class="setting-row">
                        <label>Alerta se acima de:</label>
                        <div class="input-group"><input type="number" value="100" class="input-field"><span>bpm</span></div>
                    </div>
                    <div class="setting-row">
                        <label>Alerta se abaixo de:</label>
                        <div class="input-group"><input type="number" value="50" class="input-field"><span>bpm</span></div>
                    </div>
                    <div class="setting-toggle">
                        <label>Ativo</label>
                        <input type="checkbox" class="toggle-switch" checked>
                    </div>
                </div>
                <div class="setting-card">
                    <div class="setting-header">
                        <i data-lucide="droplet" class="s-icon spo2"></i>
                        <h4>Oxigenação (SpO2)</h4>
                    </div>
                    <div class="setting-row">
                        <label>Alerta se abaixo de:</label>
                        <div class="input-group"><input type="number" value="94" class="input-field"><span>%</span></div>
                    </div>
                    <div class="setting-toggle">
                        <label>Ativo</label>
                        <input type="checkbox" class="toggle-switch" checked>
                    </div>
                </div>
                <div class="setting-card">
                    <div class="setting-header">
                        <i data-lucide="thermometer" class="s-icon temp"></i>
                        <h4>Temperatura Corporal</h4>
                    </div>
                    <div class="setting-row">
                        <label>Alerta se acima de:</label>
                        <div class="input-group"><input type="number" value="37.8" step="0.1" class="input-field"><span>°C</span></div>
                    </div>
                    <div class="setting-toggle">
                        <label>Ativo</label>
                        <input type="checkbox" class="toggle-switch" checked>
                    </div>
                </div>
                <div class="setting-card">
                    <div class="setting-header">
                        <i data-lucide="person-standing" class="s-icon fall"></i>
                        <h4>Detecção de Quedas</h4>
                    </div>
                    <div class="setting-row">
                        <label>Sensibilidade:</label>
                        <select class="input-field"><option>Alta</option><option selected>Média</option><option>Baixa</option></select>
                    </div>
                    <div class="setting-row">
                        <label>Notificar via:</label>
                        <div class="notify-methods">
                            <label class="chip active"><input type="checkbox" checked> Push</label>
                            <label class="chip active"><input type="checkbox" checked> SMS</label>
                            <label class="chip"><input type="checkbox"> Ligação</label>
                        </div>
                    </div>
                    <div class="setting-toggle">
                        <label>Ativo</label>
                        <input type="checkbox" class="toggle-switch" checked>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-4">Salvar Configurações</button>
        </section>

        <!-- Section: Emergency Contacts -->
        <section class="dash-section" id="section-contacts">
            <h2>Contatos de Emergência</h2>
            <p class="section-desc">As pessoas listadas abaixo serão notificadas automaticamente em caso de alerta.</p>
            <div class="contacts-list">
                <div class="contact-card">
                    <div class="contact-avatar">M</div>
                    <div class="contact-info">
                        <h4>Mariana Silva</h4>
                        <p>(11) 98765-4321</p>
                        <div class="contact-methods">
                            <span class="chip active">Push</span>
                            <span class="chip active">SMS</span>
                            <span class="chip active">Ligação</span>
                        </div>
                    </div>
                    <div class="contact-actions">
                        <button class="icon-btn"><i data-lucide="pencil"></i></button>
                        <button class="icon-btn danger"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-avatar" style="background: var(--info);">C</div>
                    <div class="contact-info">
                        <h4>Carlos Mendes</h4>
                        <p>(11) 91234-5678</p>
                        <div class="contact-methods">
                            <span class="chip active">Push</span>
                            <span class="chip active">SMS</span>
                        </div>
                    </div>
                    <div class="contact-actions">
                        <button class="icon-btn"><i data-lucide="pencil"></i></button>
                        <button class="icon-btn danger"><i data-lucide="trash-2"></i></button>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline mt-4" id="add-contact-btn"><i data-lucide="plus"></i> Adicionar Contato</button>
        </section>
    </div>

    <script src="../script.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
