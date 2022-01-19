<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  
  {{-- Bootstrap table --}}
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
  
  {{-- Select2 --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <title>Cadastro de Produtos</title>
  <meta name="csrf-token" content="{{csrf_token()}}">
  <style>
    body {
      padding: 20px;
    }
    .navbar {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    @component('componentes.componente_navbar', ["current" => $current])
    @endcomponent
    <main role="main">
      @hasSection ('body')
        @yield('body')
      @endif
    </main>
  </div>
  <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
  
  {{-- Bootstrap table --}}
  <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table-locale-all.min.js"></script>
  
  {{-- Select2 --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  @hasSection ('javascript')
    @yield('javascript')
  @endif
</body>
</html>