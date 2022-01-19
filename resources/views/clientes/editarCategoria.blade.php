@extends('layout.app', ["current" => "categorias"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <form action="/categorias/salvar/{{$categoria->id}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="nomeCategoria">Nome da categoria</label>
          <input type="text" class="form-control" name="nomeCategoria" value="{{$categoria->nome}}"
          id="nomeCategoria" placeholder="Categoria">
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
        <button type="cancel" class="btn btn-danger btn-sm">Cancel</button>
      </form>
    </div>
  </div>
@endsection