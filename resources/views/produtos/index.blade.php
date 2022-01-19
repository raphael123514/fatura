@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Produtos</h5>
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
        id="tabelaProdutos" 
        class="table table-ordered table-hover"
        data-search="true"
      >
        <thead>
          <tr>
            <th data-field="id">ID</th>
            <th data-field="produto">Nome do produto</th>
            <th data-field="preco">Preço</th>
            <th data-formatter="operateFormatter">Ações</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{route("produtos.novo")}}" class="btn btn-primary">Novo produto</a>
    </div>
  </div>
  @section('javascript')
      <script type="text/javascript">

        var $tabelaProdutos = $("#tabelaProdutos");
        
        $tabelaProdutos.bootstrapTable({
          url:"{{route('produtos.listar')}}",
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
          var urlEdit = "{{ route('produtos.editar', ['id' => ':id']) }}"; 

          urlEdit = urlEdit.replace(":id", row.id);

          var urlDelete = "{{ route('produtos.apagar', ['id' => ':id']) }}"; 

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