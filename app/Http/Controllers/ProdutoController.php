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
            'produtos.nome',
            'produtos.estoque',
            'produtos.preco',
            'categorias.nome as categoria',

        )
        ->join('categorias', 'categorias.id', 'produtos.categoria_id')
        ->get();

        return view('produtos', ['produtos' => $produtos]);

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
        $categorias = Categoria::all();
        return view('novoProduto', ['categorias' =>$categorias]);
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
            'nome' => $request->nomeProduto,
            'categoria_id' => $request->categoria_id,
            'estoque' => $request->qtde,
            'preco' => $request->preco,
        ]);
        $produto->save();
        return json_encode($produto);
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
        $categorias = Categoria::all();
        $produto = Produto::find($id);
        return view('editarProdutos', ['categorias' => $categorias, 'produto' => $produto]);
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
                'nome' => $request->nomeProduto,
                'categoria_id' => $request->categoria_id,
                'estoque' => $request->qtde,
                'preco' => $request->preco,
            ]);
        }

        return json_encode($produto);

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
            return response("OK", 200);
        }

        return response("ERRO", 404);


    }
}
