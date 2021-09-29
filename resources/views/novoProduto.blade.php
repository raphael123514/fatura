@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <form action="/produtos/salvar" method="POST">
        @csrf
        <div class="form-group">
          <div class="col-md-12">
            <label for="categoria_id">Categoria</label>
            <select class="form-control" id="categoria_id" name="categoria_id">
              @foreach ($categorias as $cat)
                <option value="{{$cat->id}}">{{$cat->nome}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <label for="nomeProduto">Nome da Produto</label>
            <input type="text" class="form-control" name="nomeProduto" 
            id="nomeProduto" placeholder="Produto">
          </div>
          <div class="col-md-12">
            <label for="qtde">Quantidade</label>
            <input type="number" class="form-control" name="qtde" 
            id="qtde" placeholder="Quantidade">
          </div>
          <div class="col-md-12">
            <label for="preco">Preço</label>
            <input type="number" class="form-control" name="preco" 
            id="preco" placeholder="Preço">
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
        <button type="cancel" class="btn btn-danger btn-sm">Cancel</button>
      </form>
    </div>
  </div>
@endsection