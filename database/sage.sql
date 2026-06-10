USE	sage;



-- 1. ADMIN
CREATE TABLE admin (
    id_admin          INT PRIMARY KEY AUTO_INCREMENT,
    nome              VARCHAR(100) NOT NULL,
    email             VARCHAR(150) NOT NULL UNIQUE,
    senha_hash        VARCHAR(255) NOT NULL,
    nivel_acesso      VARCHAR(30)  NOT NULL DEFAULT 'operador', -- 'superadmin', 'operador'
    criado_em         TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- 2. USUARIO (paciente que usa o colete)
CREATE TABLE usuario (
    id_usuario            INT PRIMARY KEY AUTO_INCREMENT,
    nome                  VARCHAR(100) NOT NULL,
    cpf                   VARCHAR(14)  NULL UNIQUE,
    data_nascimento       DATE         NULL,
    endereco              VARCHAR(255) NULL,
    telefone              VARCHAR(20)  NULL,
    email                 VARCHAR(150) NULL UNIQUE,
    nome_plano            VARCHAR(30)  NULL,          -- 'Premium', 'HaaS', 'Básico'
    notificar_push        BOOLEAN      DEFAULT FALSE,
    notificar_sms         BOOLEAN      DEFAULT FALSE,
    notificar_ligacao     BOOLEAN      DEFAULT FALSE,
    id_admin_responsavel  INT          NULL,          -- admin que cadastrou/gerencia
    criado_em             TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_admin
        FOREIGN KEY (id_admin_responsavel) REFERENCES admin (id_admin)
        ON DELETE SET NULL
);

-- 3. CUIDADOR (contato de emergência vinculado a um usuário)
CREATE TABLE cuidador (
    id_cuidador   INT PRIMARY KEY AUTO_INCREMENT,
    nome          VARCHAR(100) NOT NULL,
    telefone      VARCHAR(20)  NOT NULL,
    email         VARCHAR(150) NULL,
    parentesco    VARCHAR(50)  NULL,                  -- 'Filho(a)', 'Cônjuge', etc.
    id_usuario    INT          NOT NULL,
    criado_em     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_cuidador_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
        ON DELETE CASCADE
);

-- 4. DISPOSITIVO (colete IoT vinculado a um usuário)
CREATE TABLE dispositivo (
    id_dispositivo    INT PRIMARY KEY AUTO_INCREMENT,
    codigo_serial     VARCHAR(50)  NOT NULL UNIQUE,   -- 'SGE-0042'
    versao_firmware   VARCHAR(20)  NULL,
    nivel_bateria     INT          NULL,              -- 0–100
    tipo_conexao      VARCHAR(20)  NULL,              -- 'Wi-Fi', 'BLE'
    status_conexao    VARCHAR(20)  NULL,              -- 'Online', 'Offline'
    tempo_ultimo_sinal VARCHAR(30) NULL,              -- 'Há 12s', 'Há 3h'
    id_usuario        INT          NULL,
    atualizado_em     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
                      ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_dispositivo_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
        ON DELETE SET NULL
);

-- 5. PEDIDO (faturamento e vendas)
CREATE TABLE pedido (
    id_pedido            INT PRIMARY KEY AUTO_INCREMENT,
    numero_pedido        VARCHAR(50)  NOT NULL UNIQUE, -- '#2026-0421'
    valor                VARCHAR(30)  NULL,            -- 'R$ 1.299,00'
    forma_pagamento      VARCHAR(30)  NULL,            -- 'Pix', 'Cartão', 'Boleto'
    status               VARCHAR(30)  NULL,            -- 'Entregue', 'Enviado', 'Pend. Pagamento'
    id_usuario           INT          NOT NULL,
    id_admin_responsavel INT          NULL,
    criado_em            TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_pedido_admin
        FOREIGN KEY (id_admin_responsavel) REFERENCES admin (id_admin)
        ON DELETE SET NULL
);

-- 6. TICKET (suporte ao cliente)
CREATE TABLE ticket (
    id_ticket            INT PRIMARY KEY AUTO_INCREMENT,
    numero_ticket        VARCHAR(50)  NOT NULL UNIQUE, -- '#T-0891'
    assunto              VARCHAR(255) NULL,
    prioridade           VARCHAR(20)  NULL,            -- 'Alta', 'Média', 'Baixa'
    status               VARCHAR(30)  NULL,            -- 'Em Andamento', 'Respondido', 'Aguardando'
    id_usuario           INT          NOT NULL,
    id_admin_responsavel INT          NULL,
    criado_em            TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_ticket_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_ticket_admin
        FOREIGN KEY (id_admin_responsavel) REFERENCES admin (id_admin)
        ON DELETE SET NULL
);

-- 7. EVENTO_SAUDE (sinais vitais, quedas, logs do colete)

CREATE TABLE evento_saude (
    id_evento             INT PRIMARY KEY AUTO_INCREMENT,
    frequencia_cardiaca   INT          NULL,           -- bpm
    oxigenacao_spo2       INT          NULL,           -- %
    temperatura_corporal  DECIMAL(4,1) NULL,           -- °C
    quedas_detectadas     INT          NULL,
    localizacao_endereco  VARCHAR(255) NULL,
    categoria_evento      VARCHAR(50)  NULL,           -- 'Queda', 'Alerta Cardíaco', etc.
    descricao_evento      TEXT         NULL,
    id_usuario            INT          NOT NULL,
    id_dispositivo        INT          NULL,
    data_hora_registro    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_evento_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
        ON DELETE CASCADE,
    CONSTRAINT fk_evento_dispositivo
        FOREIGN KEY (id_dispositivo) REFERENCES dispositivo (id_dispositivo)
        ON DELETE SET NULL
);

-- ============================================================
-- SAGE — dados de teste
-- ============================================================

USE sage;

-- ============================================================
-- 1. ADMIN
-- ============================================================
INSERT INTO admin (nome, email, senha_hash, nivel_acesso) VALUES
('Carlos Mendes',    'carlos.mendes@sage.com.br',   '$2b$12$xK9mLpQrTvNwYzAaBbCcDe', 'superadmin'),
('Fernanda Lima',    'fernanda.lima@sage.com.br',    '$2b$12$aB3cDeF4gHiJkLmNoPqRsT', 'operador'),
('Rafael Souza',     'rafael.souza@sage.com.br',     '$2b$12$uVwXyZ1A2B3C4D5E6F7G8H', 'operador');


-- ============================================================
-- 2. USUARIO
-- ============================================================
INSERT INTO usuario (nome, cpf, data_nascimento, endereco, telefone, email, nome_plano, notificar_push, notificar_sms, notificar_ligacao, id_admin_responsavel) VALUES
('Maria Aparecida Santos',  '123.456.789-00', '1948-03-12', 'Rua das Flores, 42 — São Paulo, SP',       '(11) 91234-5678', 'maria.santos@email.com',    'Premium', TRUE,  TRUE,  TRUE,  1),
('João Batista Oliveira',   '234.567.890-11', '1952-07-25', 'Av. Paulista, 1500 — São Paulo, SP',       '(11) 92345-6789', 'joao.oliveira@email.com',   'HaaS',    TRUE,  FALSE, TRUE,  1),
('Helena Ferreira Costa',   '345.678.901-22', '1945-11-08', 'Rua XV de Novembro, 300 — Curitiba, PR',   '(41) 93456-7890', 'helena.costa@email.com',    'Básico',  FALSE, TRUE,  FALSE, 2),
('Antônio Carlos Rocha',    '456.789.012-33', '1939-05-30', 'Rua da Bahia, 200 — Belo Horizonte, MG',   '(31) 94567-8901', 'antonio.rocha@email.com',   'Premium', TRUE,  TRUE,  TRUE,  2),
('Zilda Pereira Nunes',     '567.890.123-44', '1955-09-14', 'Rua Sete de Setembro, 88 — Recife, PE',    '(81) 95678-9012', 'zilda.nunes@email.com',     'HaaS',    TRUE,  FALSE, FALSE, 3);


-- ============================================================
-- 3. CUIDADOR
-- ============================================================
INSERT INTO cuidador (nome, telefone, email, parentesco, id_usuario) VALUES
('Paulo Santos',        '(11) 98001-1111', 'paulo.santos@email.com',      'Filho(a)',  1),
('Beatriz Santos',      '(11) 98002-2222', 'beatriz.santos@email.com',    'Cônjuge',   1),
('Carla Oliveira',      '(11) 98003-3333', 'carla.oliveira@email.com',    'Filho(a)',  2),
('Roberto Costa',       '(41) 98004-4444', 'roberto.costa@email.com',     'Irmão(ã)', 3),
('Luciana Rocha',       '(31) 98005-5555', 'luciana.rocha@email.com',     'Filho(a)',  4),
('Marcos Rocha',        '(31) 98006-6666', 'marcos.rocha@email.com',      'Filho(a)',  4),
('Simone Nunes',        '(81) 98007-7777', 'simone.nunes@email.com',      'Cônjuge',   5);


-- ============================================================
-- 4. DISPOSITIVO
-- ============================================================
INSERT INTO dispositivo (codigo_serial, versao_firmware, nivel_bateria, tipo_conexao, status_conexao, tempo_ultimo_sinal, id_usuario) VALUES
('SGE-0042', 'v2.4.1', 87, 'Wi-Fi',  'Online',  'Há 12s',  1),
('SGE-0078', 'v2.4.1', 62, 'Wi-Fi',  'Online',  'Há 1min', 2),
('SGE-0115', 'v2.3.9', 15, 'BLE',    'Online',  'Há 45s',  3),
('SGE-0203', 'v2.4.0', 94, 'Wi-Fi',  'Online',  'Há 8s',   4),
('SGE-0241', 'v2.3.8',  0, '—',      'Offline', 'Há 3h',   5);


-- ============================================================
-- 5. PEDIDO
-- ============================================================
INSERT INTO pedido (numero_pedido, valor, forma_pagamento, status, id_usuario, id_admin_responsavel) VALUES
('#2026-0401', 'R$ 1.299,00', 'Pix',     'Entregue',         1, 1),
('#2026-0402', 'R$ 149,00',   'Cartão',  'Entregue',         2, 1),
('#2026-0403', 'R$ 149,00',   'Boleto',  'Pend. Pagamento',  3, 2),
('#2026-0418', 'R$ 1.299,00', 'Pix',     'Enviado',          4, 2),
('#2026-0421', 'R$ 149,00',   'Cartão',  'Entregue',         5, 3),
('#2026-0435', 'R$ 299,00',   'Pix',     'Enviado',          1, 1);


-- ============================================================
-- 6. TICKET
-- ============================================================
INSERT INTO ticket (numero_ticket, assunto, prioridade, status, id_usuario, id_admin_responsavel) VALUES
('#T-0881', 'Colete não sincroniza com o app',             'Alta',  'Em Andamento', 1, 2),
('#T-0882', 'Dúvida sobre cobrança do plano HaaS',         'Baixa', 'Respondido',   2, 2),
('#T-0885', 'Bateria descarregando muito rápido',          'Média', 'Aguardando',   3, 3),
('#T-0888', 'Falso alerta de queda durante o sono',        'Média', 'Em Andamento', 4, 2),
('#T-0891', 'Dispositivo offline há mais de 3 horas',      'Alta',  'Em Andamento', 5, 1),
('#T-0894', 'Solicitar troca de dispositivo com defeito',  'Alta',  'Aguardando',   3, 1);


-- ============================================================
-- 7. EVENTO_SAUDE
-- ============================================================
INSERT INTO evento_saude (frequencia_cardiaca, oxigenacao_spo2, temperatura_corporal, quedas_detectadas, localizacao_endereco, categoria_evento, descricao_evento, id_usuario, id_dispositivo, data_hora_registro) VALUES
-- Usuário 1 — Maria (SGE-0042)
(72,  98, 36.5, 0, 'Rua das Flores, 42 — São Paulo, SP',      'Monitoramento',    'Leitura de rotina. Todos os sinais normais.',                        1, 1, '2026-06-09 08:00:00'),
(110, 95, 37.1, 0, 'Rua das Flores, 42 — São Paulo, SP',      'Alerta Cardíaco',  'FC elevada detectada. Paciente relatou atividade física leve.',      1, 1, '2026-06-09 14:32:00'),
(68,  97, 36.4, 0, 'Rua das Flores, 42 — São Paulo, SP',      'Monitoramento',    'Leitura noturna. Paciente em repouso.',                              1, 1, '2026-06-09 23:15:00'),

-- Usuário 2 — João (SGE-0078)
(85,  96, 36.8, 0, 'Av. Paulista, 1500 — São Paulo, SP',      'Monitoramento',    'Leitura de rotina.',                                                 2, 2, '2026-06-09 09:10:00'),
(78,  93, 36.9, 1, 'Av. Paulista, 1500 — São Paulo, SP',      'Queda',            'Queda detectada no banheiro. Paciente acionou alerta manual.',       2, 2, '2026-06-09 17:45:00'),
(92,  94, 37.0, 0, 'Av. Paulista, 1500 — São Paulo, SP',      'Alerta Cardíaco',  'Arritmia leve detectada. Cuidador notificado por ligação.',          2, 2, '2026-06-10 06:20:00'),

-- Usuário 3 — Helena (SGE-0115)
(65,  97, 36.2, 0, 'Rua XV de Novembro, 300 — Curitiba, PR',  'Monitoramento',    'Leitura de rotina.',                                                 3, 3, '2026-06-08 10:00:00'),
(70,  96, 36.3, 0, 'Rua XV de Novembro, 300 — Curitiba, PR',  'Monitoramento',    'Bateria crítica (15%). Alerta enviado ao cuidador.',                 3, 3, '2026-06-09 11:30:00'),

-- Usuário 4 — Antônio (SGE-0203)
(75,  98, 36.6, 0, 'Rua da Bahia, 200 — Belo Horizonte, MG',  'Monitoramento',    'Leitura de rotina.',                                                 4, 4, '2026-06-09 07:00:00'),
(80,  97, 36.7, 0, 'Parque Municipal — Belo Horizonte, MG',   'Monitoramento',    'Paciente em caminhada. Sinais dentro do esperado.',                  4, 4, '2026-06-09 16:00:00'),
(130, 92, 37.4, 1, 'Parque Municipal — Belo Horizonte, MG',   'Queda',            'Queda e FC muito elevada. Serviço de emergência acionado.',         4, 4, '2026-06-09 16:18:00'),

-- Usuário 5 — Zilda (SGE-0241 — offline)
(74,  97, 36.5, 0, 'Rua Sete de Setembro, 88 — Recife, PE',   'Monitoramento',    'Último registro antes do dispositivo ficar offline.',               5, 5, '2026-06-10 03:05:00');