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
    <link rel="stylesheet" href="/assets/css/styles.css">
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
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Clientes Ativos</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <i data-lucide="cpu" class="kpi-icon" style="color: var(--success);"></i>
                    <div class="kpi-data">
                        <h3>{{ $dispositivosOnline }}</h3>
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
                        <h3>{{ $ticketsAbertos }}</h3>
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
                        @php
                            $totalPlanos = $usuarios->count() ?: 1;
                            $premiumPct = round($usuarios->where('nome_plano', 'Premium')->count() / $totalPlanos * 100);
                            $haasPct    = round($usuarios->where('nome_plano', 'HaaS')->count() / $totalPlanos * 100);
                            $basicoPct  = 100 - $premiumPct - $haasPct;
                        @endphp
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--primary);"></span> Premium SaaS <strong>{{ $premiumPct }}%</strong></div>
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--warning);"></span> HaaS <strong>{{ $haasPct }}%</strong></div>
                        <div class="plan-dist-item"><span class="plan-dot" style="background: var(--text-secondary);"></span> Básico <strong>{{ $basicoPct }}%</strong></div>
                        <div class="dist-bars">
                            <div class="dist-bar" style="width: {{ $premiumPct }}%; background: var(--primary);"></div>
                            <div class="dist-bar" style="width: {{ $haasPct }}%; background: var(--warning);"></div>
                            <div class="dist-bar" style="width: {{ $basicoPct }}%; background: var(--text-secondary);"></div>
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
                    <input type="text" placeholder="Buscar por nome ou e-mail..." class="input-field" id="user-search">
                </div>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table" id="users-table">
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
                        @foreach($usuarios as $u)
                        <tr>
                            <td><div class="table-user"><div class="user-avatar sm">{{ $u->iniciais }}</div> {{ $u->nome }}</div></td>
                            <td><span class="plan-tag {{ $u->plano_css_class }}">{{ $u->nome_plano ?? 'N/A' }}</span></td>
                            <td>{{ $u->dispositivo->codigo_serial ?? '—' }}</td>
                            <td>
                                @if($u->dispositivo)
                                    <span class="status-pill {{ $u->dispositivo->is_online ? 'online' : 'offline' }}">{{ $u->dispositivo->status_conexao }}</span>
                                @else
                                    <span class="status-pill offline">Sem dispositivo</span>
                                @endif
                            </td>
                            <td>{{ $u->dispositivo->tempo_ultimo_sinal ?? '—' }}</td>
                            <td><button class="icon-btn sm"><i data-lucide="eye"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Admin: Fleet -->
        <section class="dash-section" id="section-admin-fleet">
            <h2>Monitoramento de Frota IoT</h2>
            <div class="fleet-summary">
                <div class="fleet-stat"><h3>{{ $dispositivosOnline }}</h3><p>Online</p><span class="status-dot green"></span></div>
                <div class="fleet-stat"><h3>{{ $dispositivosOffline }}</h3><p>Offline</p><span class="status-dot red"></span></div>
                <div class="fleet-stat"><h3>{{ $dispositivosBatCrit }}</h3><p>Bateria Crítica</p><span class="status-dot yellow"></span></div>
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
                        @foreach($dispositivos as $d)
                        <tr>
                            <td class="mono">{{ $d->codigo_serial }}</td>
                            <td>{{ $d->usuario->nome ?? '—' }}</td>
                            <td>{{ $d->versao_firmware ?? '—' }}</td>
                            <td><div class="battery-bar"><div class="battery-level" style="width: {{ $d->nivel_bateria }}%; background: {{ $d->bateria_css_color }};"></div></div> {{ $d->nivel_bateria }}%</td>
                            <td>{{ $d->tipo_conexao ?? '—' }}</td>
                            <td><span class="status-pill {{ $d->is_online ? 'online' : 'offline' }}">{{ $d->status_conexao }}</span></td>
                        </tr>
                        @endforeach
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
                    <div class="kpi-data"><h3>{{ $totalPedidos }}</h3><p>Pedidos Registrados</p></div>
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
                        @foreach($pedidos as $p)
                        <tr>
                            <td class="mono">{{ $p->numero_pedido }}</td>
                            <td>{{ $p->usuario->nome }}</td>
                            <td><span class="plan-tag {{ $p->usuario->plano_css_class }}">{{ $p->usuario->nome_plano ?? 'N/A' }}</span></td>
                            <td>{{ $p->valor }}</td>
                            <td>{{ $p->forma_pagamento }}</td>
                            <td><span class="status-pill {{ $p->status_css_class }}">{{ $p->status }}</span></td>
                        </tr>
                        @endforeach
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
                        <span>Todos os dispositivos ({{ $dispositivosOnline }} online)</span>
                    </label>
                    <label class="ota-option">
                        <input type="radio" name="ota-target" value="outdated">
                        <span>Apenas desatualizados (v2.3.x — {{ $dispositivos->filter(fn($d) => str_starts_with($d->versao_firmware ?? '', 'v2.3'))->count() }} dispositivos)</span>
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
                <div class="kpi-card"><div class="kpi-data"><h3>{{ $ticketsAbertos }}</h3><p>Tickets Abertos</p></div></div>
                <div class="kpi-card"><div class="kpi-data"><h3>{{ $ticketsAlta }}</h3><p>Prioridade Alta</p></div></div>
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
                        @foreach($tickets as $t)
                        <tr>
                            <td class="mono">{{ $t->numero_ticket }}</td>
                            <td>{{ $t->usuario->nome }}</td>
                            <td>{{ $t->assunto }}</td>
                            <td><span class="priority-tag {{ $t->prioridade_css_class }}">{{ $t->prioridade }}</span></td>
                            <td><span class="status-pill {{ $t->status_css_class }}">{{ $t->status }}</span></td>
                            <td><button class="icon-btn sm"><i data-lucide="message-square"></i></button></td>
                        </tr>
                        @endforeach
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
