<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        DB::table('admins')->insert([
            ['nome' => 'Carlos Mendes',  'email' => 'carlos.mendes@sage.com.br', 'senha_hash' => bcrypt('admin123'), 'nivel_acesso' => 'superadmin'],
            ['nome' => 'Fernanda Lima',  'email' => 'fernanda.lima@sage.com.br',  'senha_hash' => bcrypt('admin123'), 'nivel_acesso' => 'operador'],
            ['nome' => 'Rafael Souza',   'email' => 'rafael.souza@sage.com.br',   'senha_hash' => bcrypt('admin123'), 'nivel_acesso' => 'operador'],
        ]);

        // 2. USUARIO
        DB::table('usuarios')->insert([
            [
                'nome' => 'Maria Aparecida Santos', 'cpf' => '123.456.789-00', 'data_nascimento' => '1948-03-12',
                'endereco' => 'Rua das Flores, 42 — São Paulo, SP', 'telefone' => '(11) 91234-5678',
                'email' => 'maria.santos@email.com', 'nome_plano' => 'Premium',
                'notificar_push' => true, 'notificar_sms' => true, 'notificar_ligacao' => true,
                'id_admin_responsavel' => 1,
            ],
            [
                'nome' => 'João Batista Oliveira', 'cpf' => '234.567.890-11', 'data_nascimento' => '1952-07-25',
                'endereco' => 'Av. Paulista, 1500 — São Paulo, SP', 'telefone' => '(11) 92345-6789',
                'email' => 'joao.oliveira@email.com', 'nome_plano' => 'HaaS',
                'notificar_push' => true, 'notificar_sms' => false, 'notificar_ligacao' => true,
                'id_admin_responsavel' => 1,
            ],
            [
                'nome' => 'Helena Ferreira Costa', 'cpf' => '345.678.901-22', 'data_nascimento' => '1945-11-08',
                'endereco' => 'Rua XV de Novembro, 300 — Curitiba, PR', 'telefone' => '(41) 93456-7890',
                'email' => 'helena.costa@email.com', 'nome_plano' => 'Básico',
                'notificar_push' => false, 'notificar_sms' => true, 'notificar_ligacao' => false,
                'id_admin_responsavel' => 2,
            ],
            [
                'nome' => 'Antônio Carlos Rocha', 'cpf' => '456.789.012-33', 'data_nascimento' => '1939-05-30',
                'endereco' => 'Rua da Bahia, 200 — Belo Horizonte, MG', 'telefone' => '(31) 94567-8901',
                'email' => 'antonio.rocha@email.com', 'nome_plano' => 'Premium',
                'notificar_push' => true, 'notificar_sms' => true, 'notificar_ligacao' => true,
                'id_admin_responsavel' => 2,
            ],
            [
                'nome' => 'Zilda Pereira Nunes', 'cpf' => '567.890.123-44', 'data_nascimento' => '1955-09-14',
                'endereco' => 'Rua Sete de Setembro, 88 — Recife, PE', 'telefone' => '(81) 95678-9012',
                'email' => 'zilda.nunes@email.com', 'nome_plano' => 'HaaS',
                'notificar_push' => true, 'notificar_sms' => false, 'notificar_ligacao' => false,
                'id_admin_responsavel' => 3,
            ],
        ]);

        // 3. CUIDADOR
        DB::table('cuidadors')->insert([
            ['nome' => 'Paulo Santos',    'telefone' => '(11) 98001-1111', 'email' => 'paulo.santos@email.com',    'parentesco' => 'Filho(a)',  'id_usuario' => 1],
            ['nome' => 'Beatriz Santos',  'telefone' => '(11) 98002-2222', 'email' => 'beatriz.santos@email.com',  'parentesco' => 'Cônjuge',   'id_usuario' => 1],
            ['nome' => 'Carla Oliveira',  'telefone' => '(11) 98003-3333', 'email' => 'carla.oliveira@email.com',  'parentesco' => 'Filho(a)',  'id_usuario' => 2],
            ['nome' => 'Roberto Costa',   'telefone' => '(41) 98004-4444', 'email' => 'roberto.costa@email.com',   'parentesco' => 'Irmão(ã)', 'id_usuario' => 3],
            ['nome' => 'Luciana Rocha',   'telefone' => '(31) 98005-5555', 'email' => 'luciana.rocha@email.com',   'parentesco' => 'Filho(a)',  'id_usuario' => 4],
            ['nome' => 'Marcos Rocha',    'telefone' => '(31) 98006-6666', 'email' => 'marcos.rocha@email.com',    'parentesco' => 'Filho(a)',  'id_usuario' => 4],
            ['nome' => 'Simone Nunes',    'telefone' => '(81) 98007-7777', 'email' => 'simone.nunes@email.com',    'parentesco' => 'Cônjuge',   'id_usuario' => 5],
        ]);

        // 4. DISPOSITIVO
        DB::table('dispositivos')->insert([
            ['codigo_serial' => 'SGE-0042', 'versao_firmware' => 'v2.4.1', 'nivel_bateria' => 87, 'tipo_conexao' => 'Wi-Fi',  'status_conexao' => 'Online',  'tempo_ultimo_sinal' => 'Há 12s',  'id_usuario' => 1],
            ['codigo_serial' => 'SGE-0078', 'versao_firmware' => 'v2.4.1', 'nivel_bateria' => 62, 'tipo_conexao' => 'Wi-Fi',  'status_conexao' => 'Online',  'tempo_ultimo_sinal' => 'Há 1min', 'id_usuario' => 2],
            ['codigo_serial' => 'SGE-0115', 'versao_firmware' => 'v2.3.9', 'nivel_bateria' => 15, 'tipo_conexao' => 'BLE',    'status_conexao' => 'Online',  'tempo_ultimo_sinal' => 'Há 45s',  'id_usuario' => 3],
            ['codigo_serial' => 'SGE-0203', 'versao_firmware' => 'v2.4.0', 'nivel_bateria' => 94, 'tipo_conexao' => 'Wi-Fi',  'status_conexao' => 'Online',  'tempo_ultimo_sinal' => 'Há 8s',   'id_usuario' => 4],
            ['codigo_serial' => 'SGE-0241', 'versao_firmware' => 'v2.3.8', 'nivel_bateria' => 0,  'tipo_conexao' => '—',      'status_conexao' => 'Offline', 'tempo_ultimo_sinal' => 'Há 3h',   'id_usuario' => 5],
        ]);

        // 5. PEDIDO
        DB::table('pedidos')->insert([
            ['numero_pedido' => '#2026-0401', 'valor' => 'R$ 1.299,00', 'forma_pagamento' => 'Pix',     'status' => 'Entregue',        'id_usuario' => 1, 'id_admin_responsavel' => 1],
            ['numero_pedido' => '#2026-0402', 'valor' => 'R$ 149,00',   'forma_pagamento' => 'Cartão',  'status' => 'Entregue',        'id_usuario' => 2, 'id_admin_responsavel' => 1],
            ['numero_pedido' => '#2026-0403', 'valor' => 'R$ 149,00',   'forma_pagamento' => 'Boleto',  'status' => 'Pend. Pagamento', 'id_usuario' => 3, 'id_admin_responsavel' => 2],
            ['numero_pedido' => '#2026-0418', 'valor' => 'R$ 1.299,00', 'forma_pagamento' => 'Pix',     'status' => 'Enviado',         'id_usuario' => 4, 'id_admin_responsavel' => 2],
            ['numero_pedido' => '#2026-0421', 'valor' => 'R$ 149,00',   'forma_pagamento' => 'Cartão',  'status' => 'Entregue',        'id_usuario' => 5, 'id_admin_responsavel' => 3],
            ['numero_pedido' => '#2026-0435', 'valor' => 'R$ 299,00',   'forma_pagamento' => 'Pix',     'status' => 'Enviado',         'id_usuario' => 1, 'id_admin_responsavel' => 1],
        ]);

        // 6. TICKET
        DB::table('tickets')->insert([
            ['numero_ticket' => '#T-0881', 'assunto' => 'Colete não sincroniza com o app',            'prioridade' => 'Alta',  'status' => 'Em Andamento', 'id_usuario' => 1, 'id_admin_responsavel' => 2],
            ['numero_ticket' => '#T-0882', 'assunto' => 'Dúvida sobre cobrança do plano HaaS',        'prioridade' => 'Baixa', 'status' => 'Respondido',   'id_usuario' => 2, 'id_admin_responsavel' => 2],
            ['numero_ticket' => '#T-0885', 'assunto' => 'Bateria descarregando muito rápido',         'prioridade' => 'Média', 'status' => 'Aguardando',   'id_usuario' => 3, 'id_admin_responsavel' => 3],
            ['numero_ticket' => '#T-0888', 'assunto' => 'Falso alerta de queda durante o sono',       'prioridade' => 'Média', 'status' => 'Em Andamento', 'id_usuario' => 4, 'id_admin_responsavel' => 2],
            ['numero_ticket' => '#T-0891', 'assunto' => 'Dispositivo offline há mais de 3 horas',     'prioridade' => 'Alta',  'status' => 'Em Andamento', 'id_usuario' => 5, 'id_admin_responsavel' => 1],
            ['numero_ticket' => '#T-0894', 'assunto' => 'Solicitar troca de dispositivo com defeito', 'prioridade' => 'Alta',  'status' => 'Aguardando',   'id_usuario' => 3, 'id_admin_responsavel' => 1],
        ]);

        // 7. EVENTO_SAUDE
        DB::table('evento_saudes')->insert([
            // Usuário 1 — Maria (SGE-0042)
            ['frequencia_cardiaca' => 72,  'oxigenacao_spo2' => 98, 'temperatura_corporal' => 36.5, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua das Flores, 42 — São Paulo, SP',    'categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Leitura de rotina. Todos os sinais normais.',                       'id_usuario' => 1, 'id_dispositivo' => 1, 'data_hora_registro' => '2026-06-09 08:00:00'],
            ['frequencia_cardiaca' => 110, 'oxigenacao_spo2' => 95, 'temperatura_corporal' => 37.1, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua das Flores, 42 — São Paulo, SP',    'categoria_evento' => 'Alerta Cardíaco', 'descricao_evento' => 'FC elevada detectada. Paciente relatou atividade física leve.',     'id_usuario' => 1, 'id_dispositivo' => 1, 'data_hora_registro' => '2026-06-09 14:32:00'],
            ['frequencia_cardiaca' => 68,  'oxigenacao_spo2' => 97, 'temperatura_corporal' => 36.4, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua das Flores, 42 — São Paulo, SP',    'categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Leitura noturna. Paciente em repouso.',                             'id_usuario' => 1, 'id_dispositivo' => 1, 'data_hora_registro' => '2026-06-09 23:15:00'],

            // Usuário 2 — João (SGE-0078)
            ['frequencia_cardiaca' => 85,  'oxigenacao_spo2' => 96, 'temperatura_corporal' => 36.8, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Av. Paulista, 1500 — São Paulo, SP',    'categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Leitura de rotina.',                                                'id_usuario' => 2, 'id_dispositivo' => 2, 'data_hora_registro' => '2026-06-09 09:10:00'],
            ['frequencia_cardiaca' => 78,  'oxigenacao_spo2' => 93, 'temperatura_corporal' => 36.9, 'quedas_detectadas' => 1, 'localizacao_endereco' => 'Av. Paulista, 1500 — São Paulo, SP',    'categoria_evento' => 'Queda',           'descricao_evento' => 'Queda detectada no banheiro. Paciente acionou alerta manual.',      'id_usuario' => 2, 'id_dispositivo' => 2, 'data_hora_registro' => '2026-06-09 17:45:00'],
            ['frequencia_cardiaca' => 92,  'oxigenacao_spo2' => 94, 'temperatura_corporal' => 37.0, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Av. Paulista, 1500 — São Paulo, SP',    'categoria_evento' => 'Alerta Cardíaco', 'descricao_evento' => 'Arritmia leve detectada. Cuidador notificado por ligação.',         'id_usuario' => 2, 'id_dispositivo' => 2, 'data_hora_registro' => '2026-06-10 06:20:00'],

            // Usuário 3 — Helena (SGE-0115)
            ['frequencia_cardiaca' => 65,  'oxigenacao_spo2' => 97, 'temperatura_corporal' => 36.2, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua XV de Novembro, 300 — Curitiba, PR','categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Leitura de rotina.',                                                'id_usuario' => 3, 'id_dispositivo' => 3, 'data_hora_registro' => '2026-06-08 10:00:00'],
            ['frequencia_cardiaca' => 70,  'oxigenacao_spo2' => 96, 'temperatura_corporal' => 36.3, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua XV de Novembro, 300 — Curitiba, PR','categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Bateria crítica (15%). Alerta enviado ao cuidador.',                'id_usuario' => 3, 'id_dispositivo' => 3, 'data_hora_registro' => '2026-06-09 11:30:00'],

            // Usuário 4 — Antônio (SGE-0203)
            ['frequencia_cardiaca' => 75,  'oxigenacao_spo2' => 98, 'temperatura_corporal' => 36.6, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua da Bahia, 200 — Belo Horizonte, MG','categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Leitura de rotina.',                                                'id_usuario' => 4, 'id_dispositivo' => 4, 'data_hora_registro' => '2026-06-09 07:00:00'],
            ['frequencia_cardiaca' => 80,  'oxigenacao_spo2' => 97, 'temperatura_corporal' => 36.7, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Parque Municipal — Belo Horizonte, MG', 'categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Paciente em caminhada. Sinais dentro do esperado.',                 'id_usuario' => 4, 'id_dispositivo' => 4, 'data_hora_registro' => '2026-06-09 16:00:00'],
            ['frequencia_cardiaca' => 130, 'oxigenacao_spo2' => 92, 'temperatura_corporal' => 37.4, 'quedas_detectadas' => 1, 'localizacao_endereco' => 'Parque Municipal — Belo Horizonte, MG', 'categoria_evento' => 'Queda',           'descricao_evento' => 'Queda e FC muito elevada. Serviço de emergência acionado.',        'id_usuario' => 4, 'id_dispositivo' => 4, 'data_hora_registro' => '2026-06-09 16:18:00'],

            // Usuário 5 — Zilda (SGE-0241 — offline)
            ['frequencia_cardiaca' => 74,  'oxigenacao_spo2' => 97, 'temperatura_corporal' => 36.5, 'quedas_detectadas' => 0, 'localizacao_endereco' => 'Rua Sete de Setembro, 88 — Recife, PE', 'categoria_evento' => 'Monitoramento',   'descricao_evento' => 'Último registro antes do dispositivo ficar offline.',              'id_usuario' => 5, 'id_dispositivo' => 5, 'data_hora_registro' => '2026-06-10 03:05:00'],
        ]);
    }
}
