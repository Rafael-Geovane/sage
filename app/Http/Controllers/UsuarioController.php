<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cuidador;
use App\Models\Dispositivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Lista todos os usuários.
     */
    public function index()
    {
        $usuarios = Usuario::with(['dispositivo', 'dispositivos', 'cuidadores'])->get();
        return response()->json($usuarios);
    }

    /**
     * Armazena um novo usuário com cuidador e dispositivos opcionais.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'                 => 'required|string|max:100',
            'cpf'                  => 'nullable|string|max:14|unique:usuario,cpf',
            'data_nascimento'      => 'nullable|date',
            'endereco'             => 'nullable|string|max:255',
            'telefone'             => 'nullable|string|max:20',
            'email'                => 'nullable|email|max:150|unique:usuario,email',
            'senha'                => 'nullable|string|min:6',
            'nome_plano'           => 'nullable|string|max:30',
            'notificar_push'       => 'boolean',
            'notificar_sms'        => 'boolean',
            'notificar_ligacao'    => 'boolean',
            'id_admin_responsavel' => 'nullable|exists:admin,id_admin',

            // Dados do responsável/cuidador (opcionais)
            'nome_responsavel'     => 'nullable|string|max:100',
            'telefone_responsavel' => 'nullable|string|max:20',
            'email_responsavel'    => 'nullable|email|max:150',
            'parentesco'           => 'nullable|string|max:50',

            // Dados da ficha médica (opcionais)
            'tipo_sanguineo'       => 'nullable|string|max:10',
            'condicoes_medicas'    => 'nullable|string|max:500',
            'alergias'             => 'nullable|string|max:500',
            'medicamentos'         => 'nullable|string|max:500',

            // Dispositivos a vincular (array de serials)
            'dispositivos_serial'  => 'nullable|array',
            'dispositivos_serial.*'=> 'string|max:50',
        ]);

        return DB::transaction(function () use ($validated) {
            // 1. Criar o usuário
            $usuarioData = collect($validated)->only([
                'nome', 'cpf', 'data_nascimento', 'endereco', 'telefone',
                'email', 'nome_plano', 'notificar_push', 'notificar_sms',
                'notificar_ligacao', 'id_admin_responsavel',
                'tipo_sanguineo', 'condicoes_medicas', 'alergias', 'medicamentos',
            ])->toArray();

            if (!empty($validated['senha'])) {
                $usuarioData['senha_hash'] = Hash::make($validated['senha']);
            }

            $usuario = Usuario::create($usuarioData);

            // 2. Criar o cuidador/responsável se fornecido
            if (!empty($validated['nome_responsavel'])) {
                Cuidador::create([
                    'nome'       => $validated['nome_responsavel'],
                    'telefone'   => $validated['telefone_responsavel'] ?? '',
                    'email'      => $validated['email_responsavel'] ?? null,
                    'parentesco' => $validated['parentesco'] ?? null,
                    'id_usuario' => $usuario->id_usuario,
                ]);
            }

            // 3. Vincular dispositivos (criar se não existir ou vincular existente)
            if (!empty($validated['dispositivos_serial'])) {
                foreach ($validated['dispositivos_serial'] as $serial) {
                    $serial = trim($serial);
                    if (empty($serial)) continue;

                    $dispositivo = Dispositivo::where('codigo_serial', $serial)->first();

                    if ($dispositivo) {
                        // Dispositivo já existe — vincular ao novo usuário
                        $dispositivo->update(['id_usuario' => $usuario->id_usuario]);
                    } else {
                        // Criar novo dispositivo com dados zerados
                        Dispositivo::create([
                            'codigo_serial'    => $serial,
                            'versao_firmware'  => null,
                            'nivel_bateria'    => null,
                            'tipo_conexao'     => null,
                            'status_conexao'   => 'Offline',
                            'tempo_ultimo_sinal' => '—',
                            'id_usuario'       => $usuario->id_usuario,
                        ]);
                    }
                }
            }

            return response()->json(
                $usuario->load(['cuidadores', 'dispositivos']),
                201
            );
        });
    }

    /**
     * Exibe um usuário específico.
     */
    public function show(int $id)
    {
        $usuario = Usuario::with(['dispositivo', 'cuidadores', 'pedidos', 'tickets', 'eventosSaude'])
                          ->findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Atualiza um usuário.
     */
    public function update(Request $request, int $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'nome'                => 'sometimes|string|max:100',
            'cpf'                 => 'nullable|string|max:14|unique:usuario,cpf,' . $id . ',id_usuario',
            'data_nascimento'     => 'nullable|date',
            'endereco'            => 'nullable|string|max:255',
            'telefone'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:150|unique:usuario,email,' . $id . ',id_usuario',
            'nome_plano'          => 'nullable|string|max:30',
            'notificar_push'      => 'boolean',
            'notificar_sms'       => 'boolean',
            'notificar_ligacao'   => 'boolean',
            'id_admin_responsavel'=> 'nullable|exists:admin,id_admin',
        ]);

        $usuario->update($validated);
        return response()->json($usuario);
    }

    /**
     * Remove um usuário.
     */
    public function destroy(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuário removido com sucesso.']);
    }

    /**
     * Adiciona um cuidador a um usuário.
     */
    public function storeCuidador(Request $request, int $usuarioId)
    {
        $validated = $request->validate([
            'nome'              => 'required|string|max:100',
            'telefone'          => 'required|string|max:20',
            'email'             => 'nullable|email|max:150',
            'parentesco'        => 'nullable|string|max:50',
            'notificar_push'    => 'boolean',
            'notificar_sms'     => 'boolean',
            'notificar_ligacao' => 'boolean',
        ]);

        $validated['id_usuario'] = $usuarioId;
        $cuidador = Cuidador::create($validated);
        return response()->json($cuidador, 201);
    }

    /**
     * Exibe um cuidador específico de um usuário.
     */
    public function showCuidador(int $usuarioId, int $cuidadorId)
    {
        $cuidador = Cuidador::where('id_usuario', $usuarioId)
                            ->where('id_cuidador', $cuidadorId)
                            ->firstOrFail();
        return response()->json($cuidador);
    }

    /**
     * Atualiza um cuidador específico.
     */
    public function updateCuidador(Request $request, int $usuarioId, int $cuidadorId)
    {
        $cuidador = Cuidador::where('id_usuario', $usuarioId)
                            ->where('id_cuidador', $cuidadorId)
                            ->firstOrFail();

        $validated = $request->validate([
            'nome'              => 'sometimes|string|max:100',
            'telefone'          => 'sometimes|string|max:20',
            'email'             => 'nullable|email|max:150',
            'parentesco'        => 'nullable|string|max:50',
            'notificar_push'    => 'boolean',
            'notificar_sms'     => 'boolean',
            'notificar_ligacao' => 'boolean',
        ]);

        $cuidador->update($validated);
        return response()->json($cuidador);
    }

    /**
     * Remove um cuidador.
     */
    public function destroyCuidador(int $usuarioId, int $cuidadorId)
    {
        $cuidador = Cuidador::where('id_usuario', $usuarioId)
                            ->where('id_cuidador', $cuidadorId)
                            ->firstOrFail();
        $cuidador->delete();
        return response()->json(['message' => 'Cuidador removido com sucesso.']);
    }
}

