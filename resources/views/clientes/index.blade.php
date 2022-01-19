@extends('layout.app', ["current" => "clientes"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Clientes</h5>
      @if (session('mensagem_sucesso'))
          <div class="alert alert-success">
              {{ session('mensagem_sucesso') }}
          </div>
      @endif

      @if (session('mensagem_erro'))
          <div class="alert alert-danger">
              {{ session('mensagem_erro') }}
          </div>
      @endif
      <table 
        id="tabelaClientes"
        class="table table-ordered table-hover"
        data-search="true"
        >
        <thead>
          <tr>
            <th data-field="id">ID</th>
            <th data-field="nome">Nome do cliente</th>
            <th data-formatter="operateFormatter">Ações</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{route('clientes.novo')}}" class="btn btn-primary" role="button">Nova cliente</a>
    </div>
  </div>
  @section('javascript')
      <script type="text/javascript">

        var $tabelaClientes = $("#tabelaClientes");
        
        $tabelaClientes.bootstrapTable({
          url:"{{route('clientes.listar')}}",
          locale: 'pt-BR',
          pagination:true,
          sidePagination:"client",
          cache:false,
          onLoadSuccess: function (data) {
          },
          onLoadError: function(data){
            console.log(data);
          },
          queryParams: function (p) {
            return {
              params:p
            };
          },
        });

        function operateFormatter(value, row, index) {
          var urlEdit = "{{ route('clientes.editar', ['id' => ':id']) }}"; 

          urlEdit = urlEdit.replace(":id", row.id);

          var urlDelete = "{{ route('clientes.apagar', ['id' => ':id']) }}"; 

          urlDelete = urlDelete.replace(":id", row.id);
          return [
            `
              <a href="${urlEdit}">Editar</a>
              <a href="${urlDelete}" onclick="event.preventDefault();
                      document.getElementById('delete-form${row.id}').submit();"
              >Apagar</a>
              <form id="delete-form${row.id}" action="${urlDelete}" method="POST" class="d-none">
                  @method('DELETE')
                  @csrf
              </form>
            `]
        
        }

      </script>
  @endsection
@endsection