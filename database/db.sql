-- USUARIOS
CREATE TABLE USUARIOS (
    id_usuario   INT PRIMARY KEY AUTO_INCREMENT,
    nome         VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    senha_hash   VARCHAR(255) NOT NULL,
    telefone     VARCHAR(20)
);

-- MONITORADOS
CREATE TABLE MONITORADOS (
    id_monitorado  INT PRIMARY KEY AUTO_INCREMENT,
    nome           VARCHAR(100) NOT NULL,
    data_nasc      DATE,
    detalhes_med   TEXT
);

-- RESPONSAVEIS_MONITORADOS (tabela associativa N:N)
CREATE TABLE RESPONSAVEIS_MONITORADOS (
    id_usuario     INT NOT NULL,
    id_monitorado  INT NOT NULL,
    eh_principal   BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id_usuario, id_monitorado),
    FOREIGN KEY (id_usuario)    REFERENCES USUARIOS(id_usuario),
    FOREIGN KEY (id_monitorado) REFERENCES MONITORADOS(id_monitorado)
);

-- CONFIGURACOES_ALERTAS
CREATE TABLE CONFIGURACOES_ALERTAS (
    id_configuracao  INT PRIMARY KEY AUTO_INCREMENT,
    id_monitorado    INT NOT NULL,
    batimento_min    INT,
    batimento_max    INT,
    temp_min         DECIMAL(4,1),
    temp_max         DECIMAL(4,1),
    atualizado_por   INT,
    FOREIGN KEY (id_monitorado)  REFERENCES MONITORADOS(id_monitorado),
    FOREIGN KEY (atualizado_por) REFERENCES USUARIOS(id_usuario)
);

-- HISTORICO_SAUDE
CREATE TABLE HISTORICO_SAUDE (
    id_registro    INT PRIMARY KEY AUTO_INCREMENT,
    id_monitorado  INT NOT NULL,
    bat_cardiaco   INT,
    spo2           DECIMAL(5,2),
    temp_corporal  DECIMAL(4,1),
    latitude       DECIMAL(10,7),
    longitude      DECIMAL(10,7),
    registrado_em  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_monitorado) REFERENCES MONITORADOS(id_monitorado)
);

-- ALERTAS_EVENTOS
CREATE TABLE ALERTAS_EVENTOS (
    id_alerta      INT PRIMARY KEY AUTO_INCREMENT,
    id_monitorado  INT NOT NULL,
    tipo_evento    VARCHAR(50) NOT NULL,
    descricao      TEXT,
    data_evento    DATETIME DEFAULT CURRENT_TIMESTAMP,
    falso_pos      BOOLEAN NOT NULL DEFAULT FALSE,
    resolvido_em   DATETIME,
    FOREIGN KEY (id_monitorado) REFERENCES MONITORADOS(id_monitorado)
);

-- COLETES
CREATE TABLE COLETES (
    id_colete       INT PRIMARY KEY AUTO_INCREMENT,
    id_monitorado   INT NOT NULL,
    codigo_serial   VARCHAR(100) NOT NULL UNIQUE,
    versao_firmw    VARCHAR(50),
    nivel_bateria   DECIMAL(5,2),
    status_conexao  VARCHAR(30),
    FOREIGN KEY (id_monitorado) REFERENCES MONITORADOS(id_monitorado)
);
