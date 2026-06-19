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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <div style="display:flex; align-items:center; gap:16px;">
                    <h2>Gestão de Usuários</h2>
                    <button class="btn btn-primary" id="new-account-btn" style="white-space:nowrap;">
                        <i data-lucide="user-plus"></i> Nova Conta
                    </button>
                </div>
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
                            <td>
                                <button class="icon-btn sm edit-user-btn" data-id="{{ $u->id_usuario }}"><i data-lucide="pencil"></i></button>
                                <button class="icon-btn sm view-user-btn" data-id="{{ $u->id_usuario }}"><i data-lucide="eye"></i></button>
                            </td>
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
                <table class="data-table" id="pedidos-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Plano</th>
                            <th>Valor</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $p)
                        <tr data-pedido-id="{{ $p->id_pedido }}">
                            <td class="mono">{{ $p->numero_pedido }}</td>
                            <td>{{ $p->usuario->nome }}</td>
                            <td><span class="plan-tag {{ $p->usuario->plano_css_class }}">{{ $p->usuario->nome_plano ?? 'N/A' }}</span></td>
                            <td>{{ $p->valor }}</td>
                            <td>{{ $p->forma_pagamento }}</td>
                            <td><span class="status-pill {{ $p->status_css_class }}">{{ $p->status }}</span></td>
                            <td><button class="icon-btn sm edit-pedido-btn" data-id="{{ $p->id_pedido }}" title="Gerenciar pedido"><i data-lucide="pencil"></i></button></td>
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
                <table class="data-table" id="tickets-table">
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
                        <tr data-ticket-id="{{ $t->id_ticket }}">
                            <td class="mono">{{ $t->numero_ticket }}</td>
                            <td>{{ $t->usuario->nome }}</td>
                            <td>{{ $t->assunto }}</td>
                            <td><span class="priority-tag {{ $t->prioridade_css_class }}">{{ $t->prioridade }}</span></td>
                            <td><span class="status-pill {{ $t->status_css_class }}">{{ $t->status }}</span></td>
                            <td>
                                <button class="icon-btn sm view-ticket-btn" data-id="{{ $t->id_ticket }}" title="Ver detalhes"><i data-lucide="message-square"></i></button>
                                <button class="icon-btn sm delete-ticket-btn" data-id="{{ $t->id_ticket }}" title="Excluir ticket"><i data-lucide="trash-2"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- User Edit Modal -->
    <div id="user-edit-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Editar Usuário</h3>
                <button id="close-user-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="user-edit-form">
                    <input type="hidden" id="edit-user-id">
                    <div class="form-group">
                        <label for="edit-user-name">Nome</label>
                        <input type="text" id="edit-user-name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-email">E-mail</label>
                        <input type="email" id="edit-user-email">
                    </div>
                    <div class="form-group">
                        <label for="edit-user-phone">Telefone</label>
                        <input type="tel" id="edit-user-phone">
                    </div>
                    <div class="form-group">
                        <label for="edit-user-cpf">CPF</label>
                        <input type="text" id="edit-user-cpf">
                    </div>
                    <div class="form-group">
                        <label for="edit-user-dob">Data de Nascimento</label>
                        <input type="date" id="edit-user-dob">
                    </div>
                    <div class="form-group">
                        <label for="edit-user-plan">Plano</label>
                        <select id="edit-user-plan" class="input-field">
                            <option value="Básico">Básico</option>
                            <option value="Premium">Premium</option>
                            <option value="HaaS">HaaS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notificações Ativas</label>
                        <div class="notify-methods">
                            <label class="chip"><input type="checkbox" id="edit-user-push"> Push</label>
                            <label class="chip"><input type="checkbox" id="edit-user-sms"> SMS</label>
                            <label class="chip"><input type="checkbox" id="edit-user-ligacao"> Ligação</label>
                        </div>
                    </div>
                    <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                        <button type="button" class="btn btn-outline" id="cancel-user-modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User View Modal -->
    <div id="user-view-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalhes do Usuário</h3>
                <button id="close-user-view-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div class="user-view-grid" style="display:grid; gap:16px;">
                    <div style="display:flex; align-items:center; gap:16px; margin-bottom:8px;">
                        <div class="user-avatar" id="view-user-avatar" style="width:56px; height:56px; font-size:1.2rem;"></div>
                        <div>
                            <h3 id="view-user-name" style="margin:0;"></h3>
                            <span id="view-user-plan-tag" class="plan-tag" style="margin-top:4px; display:inline-block;"></span>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="form-group"><label>CPF</label><p id="view-user-cpf" class="view-field"></p></div>
                        <div class="form-group"><label>Data de Nascimento</label><p id="view-user-dob" class="view-field"></p></div>
                        <div class="form-group"><label>E-mail</label><p id="view-user-email" class="view-field"></p></div>
                        <div class="form-group"><label>Telefone</label><p id="view-user-phone" class="view-field"></p></div>
                        <div class="form-group" style="grid-column: span 2;"><label>Endereço</label><p id="view-user-address" class="view-field"></p></div>
                    </div>
                    <div>
                        <label>Notificações</label>
                        <div id="view-user-notifications" style="display:flex; gap:8px; margin-top:4px;"></div>
                    </div>
                    <div>
                        <label>Dispositivo Vinculado</label>
                        <div id="view-user-device" class="view-field" style="margin-top:4px;"></div>
                    </div>
                    <div>
                        <label>Cuidadores</label>
                        <div id="view-user-cuidadores" style="margin-top:4px;"></div>
                    </div>
                </div>
                <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                    <button type="button" class="btn btn-outline" id="close-user-view-btn">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Modal -->
    <div id="ticket-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalhes do Ticket</h3>
                <button id="close-ticket-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div style="display:grid; gap:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h4 id="ticket-modal-number" class="mono" style="margin:0;"></h4>
                        <span id="ticket-modal-priority" class="priority-tag"></span>
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <p id="ticket-modal-client" class="view-field"></p>
                    </div>
                    <div class="form-group">
                        <label>Assunto</label>
                        <p id="ticket-modal-subject" class="view-field"></p>
                    </div>
                    <div class="form-group">
                        <label for="ticket-modal-status-select">Status</label>
                        <select id="ticket-modal-status-select" class="input-field">
                            <option value="Aguardando">Aguardando</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Respondido">Respondido</option>
                            <option value="Fechado">Fechado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ticket-modal-priority-select">Prioridade</label>
                        <select id="ticket-modal-priority-select" class="input-field">
                            <option value="Alta">Alta</option>
                            <option value="Média">Média</option>
                            <option value="Baixa">Baixa</option>
                        </select>
                    </div>
                    <input type="hidden" id="ticket-modal-id">
                </div>
                <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                    <button type="button" class="btn btn-outline" id="cancel-ticket-modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="save-ticket-btn">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pedido Modal -->
    <div id="pedido-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalhes do Pedido</h3>
                <button id="close-pedido-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <div style="display:grid; gap:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <h4 id="pedido-modal-number" class="mono" style="margin:0;"></h4>
                        <span id="pedido-modal-status-tag" class="status-pill"></span>
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <p id="pedido-modal-client" class="view-field"></p>
                    </div>
                    <div class="form-group">
                        <label>Valor</label>
                        <p id="pedido-modal-valor" class="view-field"></p>
                    </div>
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <p id="pedido-modal-payment" class="view-field"></p>
                    </div>
                    <div class="form-group">
                        <label for="pedido-modal-status-select">Status</label>
                        <select id="pedido-modal-status-select" class="input-field">
                            <option value="Pend. Pagamento">Pend. Pagamento</option>
                            <option value="Enviado">Enviado</option>
                            <option value="Entregue">Entregue</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    <input type="hidden" id="pedido-modal-id">
                </div>
                <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                    <button type="button" class="btn btn-outline" id="cancel-pedido-modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="save-pedido-btn">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Account Modal -->
    <div id="new-account-modal" class="modal-overlay hidden">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3><i data-lucide="user-plus"></i> Criar Nova Conta</h3>
                <button id="close-new-account-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="new-account-form">
                    <!-- Seção: Dados do Idoso -->
                    <div class="form-section">
                        <h4 class="form-section-title"><i data-lucide="heart"></i> Dados do Idoso</h4>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="new-nome">Nome Completo *</label>
                                <input type="text" id="new-nome" placeholder="Nome completo do idoso" required>
                            </div>
                            <div class="form-group">
                                <label for="new-cpf">CPF</label>
                                <input type="text" id="new-cpf" placeholder="000.000.000-00" maxlength="14">
                            </div>
                            <div class="form-group">
                                <label for="new-email">E-mail</label>
                                <input type="email" id="new-email" placeholder="email@exemplo.com">
                            </div>
                            <div class="form-group">
                                <label for="new-telefone">Telefone</label>
                                <input type="tel" id="new-telefone" placeholder="(11) 91234-5678">
                            </div>
                            <div class="form-group">
                                <label for="new-nascimento">Data de Nascimento</label>
                                <input type="date" id="new-nascimento">
                            </div>
                            <div class="form-group">
                                <label for="new-plano">Plano</label>
                                <select id="new-plano" class="input-field">
                                    <option value="Básico">Básico</option>
                                    <option value="Premium">Premium</option>
                                    <option value="HaaS">HaaS</option>
                                </select>
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="new-endereco">Endereço</label>
                                <input type="text" id="new-endereco" placeholder="Rua, número — Cidade, UF">
                            </div>
                        </div>
                    </div>

                    <!-- Seção: Dados do Responsável -->
                    <div class="form-section">
                        <h4 class="form-section-title"><i data-lucide="shield"></i> Dados do Responsável / Cuidador</h4>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="new-resp-nome">Nome do Responsável</label>
                                <input type="text" id="new-resp-nome" placeholder="Nome completo">
                            </div>
                            <div class="form-group">
                                <label for="new-resp-telefone">Telefone do Responsável</label>
                                <input type="tel" id="new-resp-telefone" placeholder="(11) 98765-4321">
                            </div>
                            <div class="form-group">
                                <label for="new-resp-email">E-mail do Responsável</label>
                                <input type="email" id="new-resp-email" placeholder="responsavel@email.com">
                            </div>
                            <div class="form-group">
                                <label for="new-resp-parentesco">Parentesco</label>
                                <select id="new-resp-parentesco" class="input-field">
                                    <option value="">Selecione...</option>
                                    <option value="Filho(a)">Filho(a)</option>
                                    <option value="Cônjuge">Cônjuge</option>
                                    <option value="Irmão(ã)">Irmão(ã)</option>
                                    <option value="Neto(a)">Neto(a)</option>
                                    <option value="Sobrinho(a)">Sobrinho(a)</option>
                                    <option value="Amigo(a)">Amigo(a)</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seção: Dispositivo -->
                    <div class="form-section">
                        <h4 class="form-section-title"><i data-lucide="cpu"></i> Dispositivo (Colete)</h4>
                        <div id="device-serial-list">
                            <div class="device-serial-row">
                                <div class="form-group" style="flex:1;">
                                    <label>Código Serial do Dispositivo</label>
                                    <input type="text" class="device-serial-input" placeholder="Ex: SGE-0100">
                                </div>
                                <button type="button" class="icon-btn danger remove-device-row" style="margin-top:24px; visibility:hidden;">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline btn-sm" id="add-device-serial-btn" style="margin-top:8px;">
                            <i data-lucide="plus"></i> Adicionar Outro Dispositivo
                        </button>
                        <p class="form-hint">Os dados dos sensores chegarão zerados. Serão preenchidos quando o colete começar a transmitir.</p>
                    </div>

                    <!-- Seção: Notificações -->
                    <div class="form-section">
                        <h4 class="form-section-title"><i data-lucide="bell-ring"></i> Notificações</h4>
                        <div class="notify-methods">
                            <label class="chip"><input type="checkbox" id="new-push"> Push</label>
                            <label class="chip"><input type="checkbox" id="new-sms"> SMS</label>
                            <label class="chip"><input type="checkbox" id="new-ligacao"> Ligação</label>
                        </div>
                    </div>

                    <p id="new-account-error" class="error-msg hidden">Erro ao criar conta. Verifique os campos.</p>

                    <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                        <button type="button" class="btn btn-outline" id="cancel-new-account">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="submit-new-account">
                            <i data-lucide="check"></i> Criar Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('script.js') }}?v={{ time() }}"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
