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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="dashboard-page" data-user-id="{{ $usuario->id_usuario ?? '' }}">

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
            <a href="#" class="nav-item" data-section="devices">
                <i data-lucide="cpu"></i><span>Dispositivos</span>
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
                <h1>Olá, {{ $usuario->nome ?? 'Cuidador' }} 👋</h1>
                <p>Último dado recebido: <strong>{{ $ultimaLeitura ? $ultimaLeitura->recebido_em->diffForHumans() : 'Sem dados recentes' }}</strong></p>
            </div>

            <!-- Vital Cards -->
            <div class="vitals-grid">
                <div class="vital-card heart-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-primary"><i data-lucide="heart-pulse"></i></div>
                        <span class="vital-badge normal">{{ $ultimaLeitura && $ultimaLeitura->frequencia_cardiaca > 100 ? 'Alerta' : 'Normal' }}</span>
                    </div>
                    <div class="vital-value"><span id="bpm-value">{{ $ultimaLeitura->frequencia_cardiaca ?? '—' }}</span> <small>bpm</small></div>
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
                        <span class="vital-badge normal">{{ $ultimaLeitura && $ultimaLeitura->oxigenacao_spo2 < 95 ? 'Atenção' : 'Normal' }}</span>
                    </div>
                    <div class="vital-value"><span id="spo2-value">{{ $ultimaLeitura->oxigenacao_spo2 ?? '—' }}</span><small>%</small></div>
                    <p class="vital-label">Oxigenação (SpO2)</p>
                    <div class="vital-range">
                        <div class="range-bar" style="width: {{ $ultimaLeitura ? min(100, max(0, $ultimaLeitura->oxigenacao_spo2)) : 0 }}%;"></div>
                    </div>
                </div>
                <div class="vital-card temp-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-warning"><i data-lucide="thermometer"></i></div>
                        <span class="vital-badge normal">{{ $ultimaLeitura && $ultimaLeitura->temperatura_corporal > 37.2 ? 'Atenção' : 'Normal' }}</span>
                    </div>
                    <div class="vital-value"><span id="temp-value">{{ $ultimaLeitura->temperatura_corporal ?? '—' }}</span><small>°C</small></div>
                    <p class="vital-label">Temperatura Corporal</p>
                    <div class="vital-range">
                        <div class="range-bar warning-range" style="width: {{ $ultimaLeitura ? min(100, max(0, ($ultimaLeitura->temperatura_corporal - 34) * 33)) : 0 }}%;"></div>
                    </div>
                </div>
                <div class="vital-card fall-card">
                    <div class="vital-header">
                        <div class="vital-icon pulse-danger"><i data-lucide="person-standing"></i></div>
                        <span class="vital-badge ok">{{ $quedasHoje > 0 ? 'Alerta' : 'Seguro' }}</span>
                    </div>
                    <div class="vital-value"><span>{{ $quedasHoje }}</span></div>
                    <p class="vital-label">Quedas Detectadas Hoje</p>
                    @php $ultimaQueda = $eventos->firstWhere('categoria_evento', 'Queda'); @endphp
                    <p class="vital-sub">Última queda: <strong>{{ $ultimaQueda ? $ultimaQueda->data_hora_registro->format('d/m/Y H:i') : 'Nenhuma registrada' }}</strong></p>
                </div>
            </div>

            <!-- Location Map -->
            <div class="map-section">
                <div class="map-header">
                    <h3><i data-lucide="map-pin"></i> Localização Atual</h3>
                    <span class="map-timestamp">Atualizado {{ $ultimaLeitura ? $ultimaLeitura->recebido_em->diffForHumans() : 'sem atualização' }}</span>
                </div>
                <div class="map-container">
                    <div class="map-placeholder">
                        <div class="map-pin-animated">
                            <i data-lucide="map-pin"></i>
                        </div>
                        <p>{{ $ultimaLeitura && $ultimaLeitura->latitude ? "Lat: {$ultimaLeitura->latitude}, Lng: {$ultimaLeitura->longitude}" : 'Localização indisponível' }}</p>
                        <span>Localização aproximada via Wi-Fi</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Devices -->
        <section class="dash-section" id="section-devices">
            <div class="section-top-bar">
                <div style="display:flex; align-items:center; gap:16px;">
                    <h2>Dispositivos</h2>
                    <button class="btn btn-primary" id="add-device-btn" style="white-space:nowrap;">
                        <i data-lucide="plus"></i> Adicionar Dispositivo
                    </button>
                </div>
            </div>

            @if(isset($dispositivos) && $dispositivos->count() > 0)
            <div class="data-table-wrapper">
                <table class="data-table" id="devices-table">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Firmware</th>
                            <th>Bateria</th>
                            <th>Conexão</th>
                            <th>Status</th>
                            <th>Último Sinal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispositivos as $d)
                        <tr>
                            <td class="mono">{{ $d->codigo_serial }}</td>
                            <td>{{ $d->versao_firmware ?? '<span class="no-data-badge">Sem dados</span>' }}</td>
                            <td>
                                @if($d->nivel_bateria !== null)
                                    <div class="battery-bar"><div class="battery-level" style="width: {{ $d->nivel_bateria }}%; background: {{ $d->bateria_css_color }};"></div></div> {{ $d->nivel_bateria }}%
                                @else
                                    <span class="no-data-badge">Sem dados</span>
                                @endif
                            </td>
                            <td>{{ $d->tipo_conexao ?? '<span class="no-data-badge">—</span>' }}</td>
                            <td><span class="status-pill {{ $d->is_online ? 'online' : 'offline' }}">{{ $d->status_conexao ?? 'Offline' }}</span></td>
                            <td>{{ $d->tempo_ultimo_sinal ?? '—' }}</td>
                            <td>
                                <button class="icon-btn sm danger delete-device-btn" data-id="{{ $d->id_dispositivo }}" title="Remover dispositivo">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i data-lucide="cpu" style="width:48px; height:48px; color:var(--text-secondary); margin-bottom:16px;"></i>
                <h3>Nenhum dispositivo vinculado</h3>
                <p>Clique em "Adicionar Dispositivo" para vincular um colete.</p>
            </div>
            @endif

            <div class="device-info-note" style="margin-top:20px; padding:16px; background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius:12px;">
                <p style="color: var(--text-secondary); font-size: 0.85rem; display:flex; align-items:center; gap:8px;">
                    <i data-lucide="info" style="width:16px; height:16px;"></i>
                    Os dados dos sensores serão preenchidos automaticamente quando o colete começar a transmitir via JSON.
                </p>
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
                @forelse($eventos as $evento)
                <div class="event-item {{ $evento->categoria_css_class }}">
                    <div class="event-icon"><i data-lucide="{{ $evento->categoria_icone }}"></i></div>
                    <div class="event-content">
                        <h4>{{ $evento->categoria_evento }}</h4>
                        <p>{{ $evento->descricao_evento }} @if($evento->frequencia_cardiaca) <strong>{{ $evento->frequencia_cardiaca }} bpm</strong>@endif</p>
                    </div>
                    <span class="event-time">{{ $evento->data_hora_registro->format('d/m/Y, H:i') }}</span>
                </div>
                @empty
                <p>Nenhum evento de saúde registrado.</p>
                @endforelse
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
                        <div class="notify-methods" id="user-alert-methods">
                            <label class="chip {{ optional($usuario)->notificar_push ? 'active' : '' }}"><input type="checkbox" id="user-push" {{ optional($usuario)->notificar_push ? 'checked' : '' }}> Push</label>
                            <label class="chip {{ optional($usuario)->notificar_sms ? 'active' : '' }}"><input type="checkbox" id="user-sms" {{ optional($usuario)->notificar_sms ? 'checked' : '' }}> SMS</label>
                            <label class="chip {{ optional($usuario)->notificar_ligacao ? 'active' : '' }}"><input type="checkbox" id="user-ligacao" {{ optional($usuario)->notificar_ligacao ? 'checked' : '' }}> Ligação</label>
                        </div>
                    </div>
                    <div class="setting-toggle">
                        <label>Ativo</label>
                        <input type="checkbox" class="toggle-switch" checked>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-4" id="save-alert-settings">Salvar Configurações</button>
        </section>

        <!-- Section: Emergency Contacts -->
        <section class="dash-section" id="section-contacts">
            <h2>Contatos de Emergência</h2>
            <p class="section-desc">As pessoas listadas abaixo serão notificadas automaticamente em caso de alerta.</p>
            <div class="contacts-list">
                @if(session('cuidadores_ids'))
                <div class="session-ids" style="margin-bottom:16px; padding:12px; background:#f8fafc; border-radius:12px; border:1px solid #e5e7eb;">
                    <strong style="color:#374151;">IDs de cuidadores na sessão:</strong>
                    <div style="margin-top:8px; display:flex; flex-wrap:wrap; gap:8px;">
                        @foreach(session('cuidadores_ids', []) as $cid)
                            <span class="chip" style="padding:6px 10px; background:#e2e8f0; border-radius:999px; font-size:.85rem;">ID {{ $cid }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($cuidadores && $cuidadores->count() > 0)
                    @foreach($cuidadores as $c)
                    <div class="contact-card" data-id="{{ $c->id_cuidador }}">
                        <div class="contact-avatar">{{ $c->iniciais }}</div>
                        <div class="contact-info">
                            <h4>{{ $c->nome }}</h4>
                            <p>{{ $c->telefone }}</p>
                            <div class="contact-methods">
                                @if($c->notificar_push)<span class="chip active">Push</span>@endif
                                @if($c->notificar_sms)<span class="chip active">SMS</span>@endif
                                @if($c->notificar_ligacao)<span class="chip active">Ligação</span>@endif
                            </div>
                        </div>
                        <div class="contact-actions">
                            <button class="icon-btn edit-contact-btn" data-id="{{ $c->id_cuidador }}"><i data-lucide="pencil"></i></button>
                            <button class="icon-btn danger delete-contact-btn" data-id="{{ $c->id_cuidador }}"><i data-lucide="trash-2"></i></button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p>Nenhum contato de emergência cadastrado.</p>
                @endif
            </div>
            <button class="btn btn-outline mt-4" id="add-contact-btn"><i data-lucide="plus"></i> Adicionar Contato</button>
        </section>
    </div>

    <!-- Contact Modal -->
    <div id="contact-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Adicionar Contato de Emergência</h3>
                <button id="close-contact-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="contact-form">
                    <input type="hidden" id="contact-id">
                    <div class="form-group">
                        <label for="contact-name">Nome</label>
                        <input type="text" id="contact-name" placeholder="Nome do contato" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-phone">Telefone</label>
                        <input type="tel" id="contact-phone" placeholder="(11) 98765-4321" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">E-mail</label>
                        <input type="email" id="contact-email" placeholder="email@exemplo.com">
                    </div>
                    <div class="form-group">
                        <label>Notificar via</label>
                        <div class="notify-methods">
                            <label class="chip"><input type="checkbox" id="contact-push"> Push</label>
                            <label class="chip"><input type="checkbox" id="contact-sms"> SMS</label>
                            <label class="chip"><input type="checkbox" id="contact-ligacao"> Ligação</label>
                        </div>
                    </div>
                    <p id="contact-form-error" class="error-msg hidden" style="margin-top: 4px;">Preencha o nome e o telefone para continuar.</p>
                    <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                        <button type="button" class="btn btn-outline" id="cancel-contact-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Contato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Device Modal (Dashboard) -->
    <div id="add-device-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="cpu"></i> Adicionar Dispositivo</h3>
                <button id="close-device-modal" class="close-btn"><i data-lucide="x"></i></button>
            </div>
            <div class="modal-body">
                <form id="add-device-form">
                    <div class="form-group">
                        <label for="device-serial">Código Serial do Colete *</label>
                        <input type="text" id="device-serial" placeholder="Ex: SGE-0100" required>
                        <p class="form-hint">Informe o código serial impresso no colete Sage.</p>
                    </div>
                    <p id="device-form-error" class="error-msg hidden">Erro ao adicionar dispositivo.</p>
                    <div class="contact-modal-actions" style="display:flex; justify-content:flex-end; gap:12px; margin-top:16px;">
                        <button type="button" class="btn btn-outline" id="cancel-device-modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i data-lucide="check"></i> Vincular Dispositivo</button>
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
