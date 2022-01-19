@extends('layout.app', ["current" => "clientes"])

@section('body')
  <div class="card border">
    <div class="card-body">
      @if(Request::is('*/editar/*'))

        <form id="form" method="POST" _method="POST" action="{{route('clientes.atualizar', ['id' => $cliente->id]) }}" >
        @method('PATCH')
      @else
        <form id="form" method="POST" action="{{route('clientes.salvar')}}" >
      @endif
        @csrf
        <div class="form-group">
          <label for="nome">Nome do cliente</label>
          <input type="text" class="form-control" name="nome" value="{{$cliente->nome ?? ""}}"
          id="nome" placeholder="Nome" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" value="{{$cliente->email ?? ""}}"
          id="email" placeholder="Email" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a class="btn btn-danger" href="{{route('clientes.index')}}">Cancel</a>
      </form>
    </div>
  </div>
@endsection