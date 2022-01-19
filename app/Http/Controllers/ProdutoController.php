<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        $produtos = Produto::select(
            'produtos.id',
            'produtos.produto',
            'produtos.preco',

        )
        ->get();

        return view('produtos.index', ['produtos' => $produtos]);

    }

    public function index()
    {
        $produtos = Produto::all();

        return $produtos->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('produtos.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new Produto();
        $produto->fill([
            'produto' => $request->nomeProduto,
            'preco' => $request->preco,
        ]);
        $produto->save();
        \Session::flash('mensagem_sucesso','Produto criado com sucesso!');
        return redirect()->route('produtos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::find($id);

        if (isset($produto)) {
            return json_encode($produto);
        }

        return response("ERRO", 404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::find($id);
        return view('produtos.form', ['produto' => $produto]);
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
        $produto = Produto::find($id);

        if (isset($produto)) {
            $produto->update([
                'produto' => $request->nomeProduto,
                'preco' => $request->preco,
            ]);
            \Session::flash('mensagem_sucesso','Produto atualizado com sucesso!');
    
            return redirect()->route('produtos.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produtos = Produto::find($id);

        if (isset($produtos)) {
            $produtos->delete();
            return redirect()->route('produtos.index');
        }

        return response("ERRO", 404);


    }

    public function listar(Request $request)
    {
        $produtos = Produto::all();
        return $produtos;
    }
}
