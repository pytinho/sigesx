<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  @stack('styles')

  <title>@yield('title','SIGES')</title>

  <link rel="stylesheet" href="{{ asset('css/sige.css') }}">

  <style>
    .is-invalid { border-color:#dc2626 !important; background-color:#fef2f2; }
    .invalid-feedback { font-size:12px; color:#dc2626; margin-top:2px; }
  </style>
  @vite(['resources/js/app.js'])

</head>
<script>
  window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
      window.location.reload();
    }
  });
</script>

<body class="sige-body">

  <aside class="sige-sidebar">
    <div class="brand">
      <div class="brand-logo">🎓</div>
      <div class="brand-text">SIGES</div>
    </div>

    <nav class="nav">
      <a class="nav-item {{ request()->is('home') ? 'active' : '' }}" href="{{ url('/') }}">Início</a>
      <a class="nav-item {{ request()->is('servidores/create') ? 'active' : '' }}" href="{{ route('servidores.create') }}">Cadastro</a>
      <a class="nav-item {{ request()->is('servidores') ? 'active' : '' }}" href="{{ route('servidores.index') }}">Servidores</a>
      <a class="nav-item {{ request()->is('declaracoes*') ? 'active' : '' }}" href="{{ route('declaracoes.index') }}">Declarações</a>
      <a class="nav-item" href="#">Folha de Ponto</a>
      <a class="nav-item {{ request()->is('pdfs*') ? 'active' : '' }}" href="{{ route('pdfs.index') }}">Arquivo</a>

      
      <a class="nav-item" href="#"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Sair
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
        @csrf
      </form>
    </nav>
  </aside>

  <main class="sige-main">
    <header class="topbar">
      <div class="topbar-title">@yield('title','SIGES')</div>
      <div class="topbar-actions">
        <button class="avatar-btn" title="Perfil"><span class="avatar-initial">👤</span></button>
      </div>
    </header>

    <section class="content-card">
      @yield('content')
    </section>
  </main>

</body>
</html>
