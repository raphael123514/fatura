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
        <div class="form-group">
          <br>
          <div class="col-md-3">
            <button type="button" id="bt-vincular-produto" class="btn btn-primary" onClick="$('#modal-produtos').modal('show')">Vincular produtos</button>
          </div>
          <div class="form-group row">
            <div class="col-lg-12" style="text-align: right;padding-right:30px">
                <button type="button" id="buttonRem" class="btn btn-danger" disabled>
                  <img src="{{url('img/lixeira_branca.png')}}" width="25" alt="">
                </button>
                <br> 
              </div>
          </div>
          <div class="col-md-12">
            <br>
            <table 
              id="tabelaProdutos"
              class="table table-ordered table-hover"
              data-toggle="table"
              data-checkbox-header="false"
              data-click-to-select="true"
              data-height="300"
              >
              <thead>
                <tr>
                  <th data-field="state" data-checkbox="true"></th>
                  <th data-field="id">ID</th>
                  <th data-field="produto">Nome do produto</th>
                </tr>
              </thead>
            </table>

          </div>
        </div>

        <div class="form-group">
          <br>
          <div class="col-md-3">
            <button type="button" id="bt-gerar-fatura" class="btn btn-success" onClick="abrirModalGerarFatura()">Gerar fatura</button>
          </div>
          <div class="form-group row">
            <div class="col-lg-12" style="text-align: right;padding-right:30px">
                <button type="button" id="buttonRemFatura" class="btn btn-danger" disabled>
                  <img src="{{url('img/lixeira_branca.png')}}" width="25" alt="">
                </button>
                <br> 
              </div>
          </div>
          <div class="col-md-12">
            <br>
            <table 
              id="tabelaFatura"
              class="table table-ordered table-hover"
              data-toggle="table"
              data-checkbox-header="false"
              data-click-to-select="true"
              data-height="300"
              >
              <thead>
                <tr>
                  <th data-field="status" data-checkbox="true"></th>
                  <th data-field="valor">Valor</th>
                  <th data-field="data">Data</th>
                  <th data-field="data_vencimento">Data de vencimento</th>
                </tr>
              </thead>
            </table>

          </div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a class="btn btn-danger" href="{{route('clientes.index')}}">Cancel</a>
      </form>
    </div>
  </div>
  {{-- modal produtos vinculados --}}
  <div id="modal-produtos" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Vincular produtos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="msg_modal-produtos"></div>
            <div class="form-group">
              <label for="produto_id">Produtos</label>
              <select id="produto_id"></select>
            </div>
        </div>
        <div class="modal-footer">
          <button id="btnSalvarProduto" type="button" onClick="insereValorProdutos()" class="btn btn-primary">Adicionar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  {{-- modal gerar fatura --}}
  <div id="modal-gerar-fatura" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Gerar fatura</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="msg_modal-gerar-fatura"></div>
            <div class="form-group">
              <label for="valor">Valor</label>
              <input type="text" id="valor" class="form-control">
            </div>
            <div class="form-group">
              <label for="valor">Data</label>
              <input type="datetime" id="data" class="form-control" placeholder="Ex: 10/10/2022">
            </div>
            <div class="form-group">
              <label for="valor">Data de vencimento</label>
              <input type="datetime" class="form-control" id="data_vencimento" placeholder="Ex: 10/10/2022">
            </div>
        </div>
        <div class="modal-footer">
          <button id="btnSalvarGerarFatura" type="button" onClick="gerarFatura()" class="btn btn-primary">Gerar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
  @section('javascript')
      <script type="text/javascript">

        var $tabelaProdutos = $("#tabelaProdutos");
        var $tabelaFatura = $("#tabelaFatura");
        var $buttonRem = $("#buttonRem");
        var $buttonRemFatura = $("#buttonRemFatura");
        
        $tabelaFatura.bootstrapTable({
          url:"{{route('clientes.faturas.listar')}}",
          locale: 'pt-BR',
          pagination:true,
          sidePagination:"client",
          cache:false,
          onLoadSuccess: function (data) {
            console.log(data);
          },
          onLoadError: function(data){
            console.log(data);
          },
          queryParams: function (p) {
            return {
              id: {!!$cliente->id??0!!},
              params:p
            };
          },
        });

        $tabelaProdutos.bootstrapTable({
          url:"{{route('clientes.listarProdutos')}}",
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
              id: {!!$cliente->id??0!!},
              params:p
            };
          },
        });

        function getIDTableProduto(){
          return $.map($tabelaProdutos.bootstrapTable('getSelections'), function (row){
            return row.id
          })
        };

        function getIDTableFatura(){
          return $.map($tabelaFatura.bootstrapTable('getSelections'), function (row){
            return row.id
          })
        };

        $buttonRem.click(function() {
          var id = getIDTableProduto();
          $tabelaProdutos.bootstrapTable('remove', {
            field:'id',
            values:id
          });
          $buttonRem.prop('disabled', true)
        })

        $buttonRemFatura.click(function() {
          var id = getIDTableFatura();
          console.log($tabelaFatura.bootstrapTable('getSelections'));
          var selecionado = $tabelaFatura.bootstrapTable('getSelections');
          for (const dado of selecionado) {
            if (dado.inserido === false) {
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              }); 
              
              $.ajax({
                url: "{{url('/clientes/faturas/remove')}}/" + dado.id,
                type: 'DELETE',
                success: function(result) {
                  console.log(result);
                }
              });
            }
          }
          $tabelaFatura.bootstrapTable('remove', {
            field:'id',
            values:id
          });
          $buttonRemFatura.prop('disabled', true)
        })

        $tabelaProdutos.on('check.bs.table uncheck.bs.table ' +
          'check-all.bs.table uncheck-all.bs.table',
            function () {
              $buttonRem.prop('disabled', !$tabelaProdutos.bootstrapTable('getSelections').length)

        })

        $tabelaFatura.on('check.bs.table uncheck.bs.table ' +
          'check-all.bs.table uncheck-all.bs.table',
            function () {
              $buttonRemFatura.prop('disabled', !$tabelaFatura.bootstrapTable('getSelections').length)

        })

        $("#produto_id").select2({
          width:"100%",
          placeholder: 'Pesquise os produtos',
          ajax: {
            url: "{{route('produtos.autocomplete')}}",
            dataType: 'json',
            data: function (params) {
              return {
                term: params.term
              };
            },
            delay: 250,
            processResults: function (data) {
              return {
                results: data,
              };
            }
          }
        });

        function abrirModalGerarFatura() {
          $produtos = $tabelaProdutos.bootstrapTable('getData');
          
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          }); 
          
          $.post("{{route('produtos.faturas.valor')}}",{produtos:$produtos},function(valor){
            $("#valor").val(valor);
          })

          $('#modal-gerar-fatura').modal('show');
        }

        function insereValorProdutos() {
          if (!$("#produto_id").val()) {
              $("#msg_modal-produtos").html("<div class=\"alert alert-danger\" role=\"alert\">Selecione um produto!</div>");
              return false;
          }

          var data = $tabelaProdutos.bootstrapTable('getData');
          let valida = data.find(ele => ele.id === parseInt($("#produto_id").val()));
          let validaProd = true;

          if(valida){
            $("#msg_modal-produtos").html("<div  class=\"alert alert-danger\" role=\"alert\">Esse produto já foi vinculado!</div>")
            validaProd = false
            return false;
          }

          if (validaProd) {
            $tabelaProdutos.bootstrapTable('insertRow',{
              index: 1,
              row: {
                state:false,
                id: parseInt($("#produto_id").val()),
                produto: $("#produto_id option:selected").text(),
              }
            });

            $("#msg_modal-produtos").html("<div  class=\"alert alert-success\" role=\"alert\">Produto inserido com sucesso</div>")
          }
        }

        function gerarFatura() {
          @if(isset($cliente->id))
          @endif
          
          let idDinamico = parseInt($tabelaFatura.bootstrapTable('getData').length + 1);

          $tabelaFatura.bootstrapTable('getData').forEach(function(obj) {
              if (idDinamico == obj.id) {
                idDinamico = obj.id + 1;
              }
          });

          $tabelaFatura.bootstrapTable('insertRow',{
            index: 1,
            row: {
              state:false,
              id: idDinamico,
              valor: $("#valor").val(),
              data: $("#data").val(),
              data_vencimento: $("#data_vencimento").val(),
              inserido: true,
            }
          });

          $("#msg_modal-gerar-fatura").html("<div class=\"alert alert-success\" role=\"alert\">Produto inserido com sucesso</div>")

        }

        $("#form").submit(function(e) {
          e.preventDefault();
          var produtosVinc = $tabelaProdutos.bootstrapTable('getData');
          var faturas = $tabelaFatura.bootstrapTable('getData');

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          }); 

          var form = new FormData(this);
          form.append('produtosVinc',JSON.stringify(produtosVinc));
          form.append('faturas',JSON.stringify(faturas));

          $.ajax({ 
            data: form, 
            type: 'POST',
            processData: false,
            contentType:false,
            url: $(this).attr('action'),
            success: function(data) {
              window.location.href = "{{route('clientes.index')}}";
            },
            error: function(data) {
              console.log(data);
            },
          });
        });

      </script>
  @endsection
@endsection