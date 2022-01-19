@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      @if(Request::is('*/editar/*'))

          <form id="form" method="POST" _method="POST" action="{{route('produtos.atualizar', ['id' => $produto->id]) }}" >
          @method('PATCH')
      @else
          <form id="form" method="POST" action="{{route('produtos.salvar')}}" >
      @endif
        @csrf
        <div class="form-group">
          <div class="col-md-12">
            <label for="nomeProduto">Nome da Produto</label>
            <input type="text" class="form-control" name="nomeProduto" 
            id="nomeProduto" placeholder="Produto" value="{{$produto->produto ?? ""}}" required>
          </div>
          <div class="col-md-12">
            <label for="preco">Preço</label>
            <input type="text" class="form-control" name="preco" 
            id="preco" placeholder="Preço" value="{{$produto->preco ?? ""}}" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a class="btn btn-danger" href="{{route('produtos.index')}}">Cancel</a>
      </form>
    </div>
  </div>
@endsection