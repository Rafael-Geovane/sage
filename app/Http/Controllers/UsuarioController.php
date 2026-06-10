<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cuidador;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Lista todos os usuários.
     */
    public function index()
    {
        $usuarios = Usuario::with(['dispositivo', 'cuidadores'])->get();
        return response()->json($usuarios);
    }

    /**
     * Armazena um novo usuário.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'                => 'required|string|max:100',
            'cpf'                 => 'nullable|string|max:14|unique:usuarios,cpf',
            'data_nascimento'     => 'nullable|date',
            'endereco'            => 'nullable|string|max:255',
            'telefone'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:150|unique:usuarios,email',
            'nome_plano'          => 'nullable|string|max:30',
            'notificar_push'      => 'boolean',
            'notificar_sms'       => 'boolean',
            'notificar_ligacao'   => 'boolean',
            'id_admin_responsavel'=> 'nullable|exists:admins,id_admin',
        ]);

        $usuario = Usuario::create($validated);
        return response()->json($usuario, 201);
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
            'cpf'                 => 'nullable|string|max:14|unique:usuarios,cpf,' . $id . ',id_usuario',
            'data_nascimento'     => 'nullable|date',
            'endereco'            => 'nullable|string|max:255',
            'telefone'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:150|unique:usuarios,email,' . $id . ',id_usuario',
            'nome_plano'          => 'nullable|string|max:30',
            'notificar_push'      => 'boolean',
            'notificar_sms'       => 'boolean',
            'notificar_ligacao'   => 'boolean',
            'id_admin_responsavel'=> 'nullable|exists:admins,id_admin',
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
            'nome'       => 'required|string|max:100',
            'telefone'   => 'required|string|max:20',
            'email'      => 'nullable|email|max:150',
            'parentesco' => 'nullable|string|max:50',
        ]);

        $validated['id_usuario'] = $usuarioId;
        $cuidador = Cuidador::create($validated);
        return response()->json($cuidador, 201);
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
