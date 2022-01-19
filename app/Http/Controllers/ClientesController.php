<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ClienteProduto;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cli = new Cliente();
        $cli->nome = $request->input("nome");
        $cli->email = $request->input("email");
        $cli->save();
        \Session::flash('mensagem_sucesso','Cliente criado com sucesso!');
        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);

        if (isset($cliente)) {
            return view('clientes.form', ['cliente' => $cliente]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produtos = !empty(json_decode($request->produtosVinc)) ? json_decode($request->produtosVinc, 1) : [];
        
        $cliente = new Cliente;         
        $cliente = Cliente::find($id);

        if (isset($cliente)) {
            $dado = [
                'nome' => $request->nome,
                'email' => $request->email,
            ];

            $cliente->update($dado);
        }

        if (!empty($produtos)) {
            $arrayProdutosVinc = [];
            for ($i=0; $i < sizeof($produtos); $i++) { 
                $arrayProdutosVinc[$produtos[$i]['id']] = ["cliente_id" => $cliente->id, "produto_id" => $produtos[$i]['id']];
            }
            $cliente->produtos()->sync($arrayProdutosVinc);
        }
        
        \Session::flash('mensagem_sucesso','Cliente atualizado com sucesso!');

        return response('Cliente atualizado com sucesso', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (isset($cliente)) {
            $cliente->delete();
        }

        return redirect()->route('clientes.index');
    }

    public function listar(Request $request)
    {
        $clientes = Cliente::all();
        return $clientes;
    }

    public function listarProdutos(Request $request )
    {
        $id = $request->id;
        $produtos = ClienteProduto::where('cliente_id', $id)
                    ->leftJoin('produtos', 'produtos.id', 'clientes_produtos.produto_id')->get();
        
        return $produtos;
    }

}
