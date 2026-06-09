<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sage | Painel Administrativo</title>
    <meta name="description" content="Painel de gestão administrativa da Sage Wearable.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body class="admin-page">

    <!-- Sidebar -->
    <aside class="sidebar admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i data-lucide="shield-check" class="logo-icon"></i>
                <span>Sage <small>Admin</small></span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-item active" data-section="admin-overview">
                <i data-lucide="layout-dashboard"></i><span>Visão Geral</span>
            </a>
            <a href="#" class="nav-item" data-section="admin-users">
                <i data-lucide="users"></i><span>Gestão de Usuários</span>
            </a>
            <a href="#" class="nav-item" data-section="admin-fleet">
                <i data-lucide="cpu"></i><span>Frota IoT</span>
            </a>
            <a href="#" class="nav-item" data-section="admin-sales">
                <i data-lucide="bar-chart-3"></i><span>Vendas</span>
            </a>
            <a href="#" class="nav-item" data-section="admin-ota">
                <i data-lucide="download-cloud"></i><span>Atualização OTA</span>
            </a>
            <a href="#" class="nav-item" data-section="admin-support">
                <i data-lucide="headphones"></i><span>Suporte</span>
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
        <header class="dash-topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menu-toggle"><i data-lucide="menu"></i></button>
                <h2>Painel Administrativo</h2>
            </div>
            <div class="topbar-right">
                <a href="{{ route('dashboard') }}" class="nav-item" >
                    <i data-lucide="user"></i><span>Painel Usuario</span>
                </a>
                <div class="device-status online"><span class="status-dot"></span> Sistema Operacional</div>
                <div class="user-avatar admin-avatar">AD</div>
            </div>
        </header>

        <!-- Admin Overview -->
        <section class="dash-section active" id="section-admin-overview">
            <div class="dash-greeting">
                <h1>Olá, Admin 🔧</h1>
                <p>Visão geral do sistema Sage.</p>
            </div>
            <div class="admin-kpi-grid">
                <div class="kpi-card">
                    <i data-lucide="users" class="kpi-icon" style="color: var(--primary);"></i>
                    <div class="kpi-data">
                        <h3>1.247</h3>
                        <p>Clientes Ativos</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="cpu" class="kpi-icon" style="color: var(--success);"></i>
                    <div class="kpi-data">
                        <h3>1.189</h3>
                        <p>Coletes Online</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="trending-up" class="kpi-icon" style="color: var(--warning);"></i>
                    <div class="kpi-data">
                        <h3>R$ 84.5k</h3>
                        <p>Receita Mensal (MRR)</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="headphones" class="kpi-icon" style="color: var(--heart);"></i>
                    <div class="kpi-data">
                        <h3>12</h3>
                        <p>Tickets Abertos</p>
                    </div>
                </div>
            </div>

            <!-- Quick Charts -->
            <div class="admin-charts-row">
                <div class="chart-card">
                    <h4><i data-lucide="bar-chart-3"></i> Vendas Últimos 7 Dias</h4>
                    <div class="bar-chart-area">
                        <div class="bar-group"><div class="bar" style="height: 40%;"></div><span>Seg</span></div>
                        <div class="bar-group"><div class="bar" style="height: 65%;"></div><span>Ter</span></div>
                        <div class="bar-group"><div class="bar" style="height: 50%;"></div><span>Qua</span></div>
                        <div class="bar-group"><div class="bar" style="height: 80%;"></div><span>Qui</span></div>
                        <div class="bar-group"><div class="bar" style="height: 72%;"></div><span>Sex</span></div>
                        <div class="bar-group"><div class="bar highlight" style="height: 90%;"></div><span>Sáb</span></div>
                        <div class="bar-group"><div class="bar" style="height: 55%;"></div><span>Dom</span></div>
                    </div>
                </div>
                <div class="chart-card">
                    <h4><i data-lucide="pie-chart"></i> Distribuição de Planos</h4>
                    <div class="plan-dist">
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--primary);"></span> Premium SaaS <strong>58%</strong></div>
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--warning);"></span> Assinatura Total <strong>27%</strong></div>
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--text-secondary);"></span> Básico <strong>15%</strong></div>
                        <div class="dist-bars">
                            <div class="dist-bar" style="width: 58%; background: var(--primary);"></div>
                            <div class="dist-bar" style="width: 27%; background: var(--warning);"></div>
                            <div class="dist-bar" style="width: 15%; background: var(--text-secondary);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin: Users -->
        <section class="dash-section" id="section-admin-users">
            <div class="section-top-bar">
                <h2>Gestão de Usuários</h2>
                <div class="search-bar">
                    <i data-lucide="search"></i>
                    <input type="text" placeholder="Buscar por nome ou e-mail..." class="input-field">
                </div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Plano</th>
                            <th>Dispositivo</th>
                            <th>Status</th>
                            <th>Último Sinal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="table-user"><div class="user-avatar sm">JM</div> João Mendes</div></td>
                            <td><span class="plan-tag premium">Premium</span></td>
                            <td>SGE-0042</td>
                            <td><span class="status-pill online">Online</span></td>
                            <td>Há 12s</td>
                            <td><button class="icon-btn sm"><i data-lucide="eye"></i></button></td>
                        </tr>
                        <tr>
                            <td><div class="table-user"><div class="user-avatar sm" style="background: var(--info);">RL</div> Rosa Lima</div></td>
                            <td><span class="plan-tag haas">HaaS</span></td>
                            <td>SGE-0078</td>
                            <td><span class="status-pill online">Online</span></td>
                            <td>Há 45s</td>
                            <td><button class="icon-btn sm"><i data-lucide="eye"></i></button></td>
                        </tr>
                        <tr>
                            <td><div class="table-user"><div class="user-avatar sm" style="background: var(--warning);">AS</div> Antônio Souza</div></td>
                            <td><span class="plan-tag basic">Básico</span></td>
                            <td>SGE-0105</td>
                            <td><span class="status-pill offline">Offline</span></td>
                            <td>Há 3h</td>
                            <td><button class="icon-btn sm"><i data-lucide="eye"></i></button></td>
                        </tr>
                        <tr>
                            <td><div class="table-user"><div class="user-avatar sm" style="background: var(--heart);">MC</div> Maria Clara</div></td>
                            <td><span class="plan-tag premium">Premium</span></td>
                            <td>SGE-0210</td>
                            <td><span class="status-pill online">Online</span></td>
                            <td>Há 1m</td>
                            <td><button class="icon-btn sm"><i data-lucide="eye"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Admin: Fleet -->
        <section class="dash-section" id="section-admin-fleet">
            <h2>Monitoramento de Frota IoT</h2>
            <div class="fleet-summary">
                <div class="fleet-stat"><h3>1.189</h3><p>Online</p><span class="status-dot green"></span></div>
                <div class="fleet-stat"><h3>42</h3><p>Offline</p><span class="status-dot red"></span></div>
                <div class="fleet-stat"><h3>16</h3><p>Bateria Crítica</p><span class="status-dot yellow"></span></div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID Dispositivo</th>
                            <th>Usuário</th>
                            <th>Firmware</th>
                            <th>Bateria</th>
                            <th>Conexão</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="mono">SGE-0042</td>
                            <td>João Mendes</td>
                            <td>v2.4.1</td>
                            <td><div class="battery-bar"><div class="battery-level" style="width: 85%; background: var(--success);"></div></div> 85%</td>
                            <td>Wi-Fi</td>
                            <td><span class="status-pill online">Online</span></td>
                        </tr>
                        <tr>
                            <td class="mono">SGE-0078</td>
                            <td>Rosa Lima</td>
                            <td>v2.4.1</td>
                            <td><div class="battery-bar"><div class="battery-level" style="width: 62%; background: var(--warning);"></div></div> 62%</td>
                            <td>BLE</td>
                            <td><span class="status-pill online">Online</span></td>
                        </tr>
                        <tr>
                            <td class="mono">SGE-0105</td>
                            <td>Antônio Souza</td>
                            <td>v2.3.8</td>
                            <td><div class="battery-bar"><div class="battery-level" style="width: 12%; background: var(--danger);"></div></div> 12%</td>
                            <td>—</td>
                            <td><span class="status-pill offline">Offline</span></td>
                        </tr>
                        <tr>
                            <td class="mono">SGE-0210</td>
                            <td>Maria Clara</td>
                            <td>v2.4.0</td>
                            <td><div class="battery-bar"><div class="battery-level" style="width: 95%; background: var(--success);"></div></div> 95%</td>
                            <td>Wi-Fi</td>
                            <td><span class="status-pill online">Online</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Admin: Sales -->
        <section class="dash-section" id="section-admin-sales">
            <h2>Gestão de Vendas</h2>
            <div class="admin-kpi-grid">
                <div class="kpi-card">
                    <i data-lucide="receipt" class="kpi-icon" style="color: var(--primary);"></i>
                    <div class="kpi-data"><h3>327</h3><p>Pedidos este Mês</p></div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="wallet" class="kpi-icon" style="color: var(--success);"></i>
                    <div class="kpi-data"><h3>R$ 424k</h3><p>Faturamento Acumulado</p></div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="refresh-cw" class="kpi-icon" style="color: var(--warning);"></i>
                    <div class="kpi-data"><h3>94.2%</h3><p>Taxa de Renovação</p></div>
                </div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Plano</th>
                            <th>Valor</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="mono">#2026-0421</td>
                            <td>Mariana Silva</td>
                            <td><span class="plan-tag premium">Premium</span></td>
                            <td>R$ 1.299,00</td>
                            <td>Pix</td>
                            <td><span class="status-pill online">Entregue</span></td>
                        </tr>
                        <tr>
                            <td class="mono">#2026-0420</td>
                            <td>Carlos Mendes</td>
                            <td><span class="plan-tag haas">HaaS</span></td>
                            <td>R$ 149,00/mês</td>
                            <td>Cartão</td>
                            <td><span class="status-pill warning">Enviado</span></td>
                        </tr>
                        <tr>
                            <td class="mono">#2026-0419</td>
                            <td>Fernanda Costa</td>
                            <td><span class="plan-tag basic">Básico</span></td>
                            <td>R$ 1.299,00</td>
                            <td>Boleto</td>
                            <td><span class="status-pill pending">Pend. Pagamento</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Admin: OTA -->
        <section class="dash-section" id="section-admin-ota">
            <h2>Atualização Remota (OTA)</h2>
            <div class="ota-status-panel">
                <div class="ota-current">
                    <h3>Firmware Atual</h3>
                    <div class="ota-version">
                        <span class="version-tag">v2.4.1</span>
                        <p>Lançado em 28/04/2026</p>
                    </div>
                </div>
                <div class="ota-new">
                    <h3>Nova Versão Disponível</h3>
                    <div class="ota-version highlight">
                        <span class="version-tag new">v2.5.0</span>
                        <p>Melhoria no algoritmo de detecção de quedas e correção de bugs de conectividade BLE.</p>
                    </div>
                </div>
            </div>
            <div class="ota-deploy">
                <h4>Distribuição de Atualização</h4>
                <div class="ota-options">
                    <label class="ota-option">
                        <input type="radio" name="ota-target" value="all" checked>
                        <span>Todos os dispositivos (1.189 online)</span>
                    </label>
                    <label class="ota-option">
                        <input type="radio" name="ota-target" value="outdated">
                        <span>Apenas desatualizados (v2.3.x — 58 dispositivos)</span>
                    </label>
                    <label class="ota-option">
                        <input type="radio" name="ota-target" value="batch">
                        <span>Deploy gradual (10% por dia)</span>
                    </label>
                </div>
                <button class="btn btn-primary mt-4"><i data-lucide="upload-cloud"></i> Iniciar Deploy OTA</button>
            </div>
        </section>

        <!-- Admin: Support -->
        <section class="dash-section" id="section-admin-support">
            <h2>Suporte ao Cliente</h2>
            <div class="support-summary">
                <div class="kpi-card"><div class="kpi-data"><h3>12</h3><p>Tickets Abertos</p></div></div>
                <div class="kpi-card"><div class="kpi-data"><h3>4</h3><p>Prioridade Alta</p></div></div>
                <div class="kpi-card"><div class="kpi-data"><h3>2h 15m</h3><p>Tempo Médio de Resposta</p></div></div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Cliente</th>
                            <th>Assunto</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="mono">#T-0891</td>
                            <td>João Mendes</td>
                            <td>Colete não conecta ao Wi-Fi</td>
                            <td><span class="priority-tag high">Alta</span></td>
                            <td><span class="status-pill warning">Em Andamento</span></td>
                            <td><button class="icon-btn sm"><i data-lucide="message-square"></i></button></td>
                        </tr>
                        <tr>
                            <td class="mono">#T-0890</td>
                            <td>Fernanda Costa</td>
                            <td>Dúvida sobre lavagem do colete</td>
                            <td><span class="priority-tag low">Baixa</span></td>
                            <td><span class="status-pill online">Respondido</span></td>
                            <td><button class="icon-btn sm"><i data-lucide="message-square"></i></button></td>
                        </tr>
                        <tr>
                            <td class="mono">#T-0889</td>
                            <td>Carlos Mendes</td>
                            <td>Alerta de queda falso positivo</td>
                            <td><span class="priority-tag high">Alta</span></td>
                            <td><span class="status-pill warning">Em Andamento</span></td>
                            <td><button class="icon-btn sm"><i data-lucide="message-square"></i></button></td>
                        </tr>
                        <tr>
                            <td class="mono">#T-0888</td>
                            <td>Rosa Lima</td>
                            <td>Troca de tamanho do colete HaaS</td>
                            <td><span class="priority-tag medium">Média</span></td>
                            <td><span class="status-pill pending">Aguardando</span></td>
                            <td><button class="icon-btn sm"><i data-lucide="message-square"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="../script.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
