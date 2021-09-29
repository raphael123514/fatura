@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Produtos</h5>
      <table id="tabelaProdutos" class="table table-ordered table-hover">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome do produto</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Categoria</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <button class="btn btn-sm btn-primary" role="button" onclick="novoProduto()">Novo produto</button>
    </div>
  </div>
  <div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="form-horizontal" id="formProduto">
          <div class="modal-header">
            <h5 class="modal-title">Novo produto</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id" class="form-control">
            <div class="form-group">
              <label for="nomeProduto">Nome da Produto</label>
              <div class="input-group">
                <input type="text" class="form-control" name="nomeProduto" 
                id="nomeProduto" placeholder="Produto">

              </div>
              <label for="qtde">Quantidade</label>
              <div class="input-group">
                <input type="number" class="form-control" name="qtde" 
                id="qtde" placeholder="Quantidade">
              </div>
              <label for="preco">Preço</label>
              <div class="input-group">
                <input type="number" class="form-control" name="preco" 
                id="preco" placeholder="Preço">
              </div>
              
              <label for="categoria_id">Categoria</label>
              <div class="input-group">
                <select class="form-control" id="categoria_id" name="categoria_id">
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="cancel" class="btn btn-secondary" data-dismiss='modal' >Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @section('javascript')
      <script type="text/javascript">

        $.ajaxSetup({
          headers : {
            'X-CSRF-TOKEN': "{{ csrf_token()}}"
          }
        });

        function novoProduto() {
          $("#id").val('');
          $("#nomeProduto").val('');
          $("#qtde").val('');
          $("#preco").val('');
          $('#dlgProdutos').modal('show');
        }

        function carregarCategorias() {
          $.getJSON('/api/categorias', function (data) { 
            for (const dado of data) {
              let opcao = '<option value="' + dado.id + '">' + dado.nome + 
              '</option>';
              $("#categoria_id").append(opcao);
            }
          })
        }

        function carregarProdutos() {
          $.getJSON('/api/produtos', function (data) { 
            for (const dado of data) {
              let linha = montarLinha(dado);
              $("#tabelaProdutos>tbody").append(linha);
            }
          })
        }

        function montarLinha(dado) {
          var linha = 
          "<tr>"+
            "<td>"+ dado.id + "</td>"+
            "<td>"+ dado.nome + "</td>"+
            "<td>"+ dado.estoque + "</td>"+
            "<td>"+ dado.preco + "</td>"+
            "<td>"+ dado.categoria_id + "</td>"+
            "<td>"+
              '<button class="btn btn-sm btn-primary" onClick="editar('+ dado.id + ')"> Editar </button>'+
              '<button class="btn btn-sm btn-danger" onClick="apagar('+ dado.id + ')"> Apagar </button>'+
             "</td>"+
          "</tr>";

          return linha;
        }

        function removeLinha(id) {
          let linha = $("#tabelaProdutos>tbody>tr")

          let elemento = linha.filter(function(i, element) {return element.cells[0].textContent == id;})
          if (elemento) {
            elemento.remove();
            
          }

        }

        function apagar(id) {
          $.ajax({
            type:"DELETE",
            url: "/api/produtos/" + id,
            context: this,
            success: function(data){
              removeLinha(id);
              console.log("Apagado com Sucesso");
            },
            error: function(data){
              console.log(data);
            }
          })
        }

        function editar(id) {
          $.getJSON('/api/produtos/' + id, function (data) { 
            console.log(data);
            $("#id").val(data.id);
            $("#nomeProduto").val(data.nome);
            $("#qtde").val(data.estoque);
            $("#preco").val(data.preco);
            $("#categoria_id").val(data.categoria_id);
            $('#dlgProdutos').modal('show');
          })
        }

        $(function(){
          carregarCategorias();
          carregarProdutos();
        })

        $("#formProduto").submit(function(event){
          event.preventDefault();
          if ($("#id").val() != "") {
            atualizarProduto(id);
          } else {
            criarProduto();
          }
          
          $("#dlgProdutos").modal("hide");
        });
        
        function criarProduto() {
          let produto = {
            nomeProduto: $("#nomeProduto").val(),
            preco: $("#preco").val(),
            qtde: $("#qtde").val(),
            categoria_id: $("#categoria_id").val()
          }

          $.post("api/produtos", produto ,function(data){
            let produto = JSON.parse(data);
            let linha = montarLinha(produto);
            $("#tabelaProdutos>tbody").append(linha);
          })

        }

        function atualizarProduto(id) {
          let produto = {
            id: $("#id").val(),
            nomeProduto: $("#nomeProduto").val(),
            preco: $("#preco").val(),
            qtde: $("#qtde").val(),
            categoria_id: $("#categoria_id").val()
          }

          $.ajax({
            type:"PUT",
            data: produto,
            url: "/api/produtos/" + produto.id,
            context: this,
            success: function(data){
              let produto = JSON.parse(data);
              let linhas = $("#tabelaProdutos>tbody>tr")
              let e = linhas.filter(function(i, e) {
                return (e.cells[0].textContent == produto.id)
              })
              
              if (e) {
                e[0].cells[0].textContent = produto.id;
                e[0].cells[1].textContent = produto.nome;
                e[0].cells[2].textContent = produto.preco;
                e[0].cells[3].textContent = produto.estoque;
                e[0].cells[4].textContent = produto.categoria_id;
              }

            },
            error: function(data){
              console.log(data);
            }
          })
        }
      </script>
  @endsection
@endsection