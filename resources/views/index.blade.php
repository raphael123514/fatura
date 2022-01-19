@extends('layout.app', ["current" => "home"])

@section('body')
<div class="jumbotron bg-light border-secondary">
  <div class="row">
    <div class="card-deck border-black">
      <div class="card border border-primary">
        <div class="card-body">
          <h5 class="card-title">Cadastro de Clientes</h5>
          <p class="card-text">
            Cadastre os clientes.
          </p>
          <a href="{{route('clientes.index')}}" class="btn btn-primary">Cadastre seus clientes</a>
        </div>
      </div>
      <div class="card border border-primary">
        <div class="card-body">
          <h5 class="card-title">Cadastro de Produtos</h5>
          <p class="card-text">
            Aqui você cadastra todos os seus produtos.
          </p>
          <a href="{{route('produtos.index')}}" class="btn btn-primary">Cadastre seus produtos</a>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection