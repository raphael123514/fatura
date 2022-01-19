<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ClienteProduto;
use App\Fatura;
use Illuminate\Http\Request;

class ClienteController extends Controller
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
        $cliente = new Cliente();
        $produtos = !empty(json_decode($request->produtosVinc)) ? json_decode($request->produtosVinc, 1) : [];
        $faturas = !empty(json_decode($request->faturas)) ? json_decode($request->faturas, 1) : [];
        
        $dado = [
            'nome' => $request->nome,
            'email' => $request->email,
        ];

        $cliente = $cliente->create($dado);
        if (!empty($produtos)) {
            $arrayProdutosVinc = [];
            for ($i=0; $i < sizeof($produtos); $i++) { 
                $arrayProdutosVinc[$produtos[$i]['id']] = ["cliente_id" => $cliente->id, "produto_id" => $produtos[$i]['id']];
            }
            $cliente->produtos()->sync($arrayProdutosVinc);
        }

        if (!empty($faturas)) {
            $fat = new Fatura();
            foreach ($faturas as $key => $fatura) {
                $dado = [
                    "id_cliente" => $cliente->id,
                    "valor" => !empty($fatura['valor']) ? str_replace("R$ ","",str_replace(",",".", $fatura['valor'])) : null,
                    "data" => date("d-m-Y",strtotime($fatura['data'])),
                    "data_vencimento" => date("d-m-Y",strtotime($fatura['data_vencimento'])),
                ];

                $fat = $fat->create($dado);
            }

        }

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
        $faturas = !empty(json_decode($request->faturas)) ? json_decode($request->faturas, 1) : [];
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

        if (!empty($faturas)) {
            $fat = new Fatura();
            
            foreach ($faturas as $key => $fatura) {
                if ($fatura['inserido']) {
                    $dado = [
                        "id_cliente" => $cliente->id,
                        "valor" => !empty($fatura['valor']) ? str_replace("R$ ","",str_replace(",",".", $fatura['valor'])) : null,
                        "data" => date("d-m-Y",strtotime($fatura['data'])),
                        "data_vencimento" => date("d-m-Y",strtotime($fatura['data_vencimento'])),
                    ];
    
                    $fat = $fat->create($dado);
                } 
            }

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

    public function listarFatura(Request $request)
    {
        $id = $request->id;

        $faturas = Fatura::select(
            'faturas.id', 
            'faturas.valor',
            'faturas.data',
            'faturas.data_vencimento',
            \DB::raw('false as "inserido"'),
            
            )->where('id_cliente', $id)->get();

        return $faturas;
    }

    public function removeFatura( $id )
    {

        $fatura = Fatura::find($id);
        if (isset($fatura)) {
            $fatura->delete();
         
            return response()->json(["msg" => "removido com sucesso"], 200);

        }

    }

}
