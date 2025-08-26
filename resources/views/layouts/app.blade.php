<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','SIGES')</title>

  <link rel="stylesheet" href="{{ asset('css/sige.css') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    /* Ajustes para mensagens de erro individuais */
    .is-invalid {
      border-color: #dc2626 !important; /* vermelho */
      background-color: #fef2f2;
    }
    .invalid-feedback {
      font-size: 12px;
      color: #dc2626;
      margin-top: 2px;
    }
  </style>
</head>
<body class="sige-body">

  <aside class="sige-sidebar">
    <div class="brand">
      <div class="brand-logo">🎓</div>
      <div class="brand-text">SIGES</div>
    </div>

    <nav class="nav">
      <a class="nav-item {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Início</a>
      <a class="nav-item {{ request()->is('servidores/create') ? 'active' : '' }}" href="{{ route('servidores.create') }}">Cadastro</a>
      <a class="nav-item {{ request()->is('servidores') ? 'active' : '' }}" href="{{ route('servidores.index') }}">Servidores</a>
      <a class="nav-item" href="#">Declarações</a>
      <a class="nav-item" href="#">Folha de Ponto</a>
      <a class="nav-item" href="#">Arquivos</a>
      <a class="nav-item" href="#">Sair</a>
    </nav>
  </aside>

  <main class="sige-main">
    <header class="topbar">
      <div class="topbar-title">@yield('title','SIGES')</div>
      <div class="topbar-actions">
        <button class="avatar-btn" title="Perfil">
          <span class="avatar-initial">👤</span>
        </button>
      </div>
    </header>

    <section class="content-card">
      @yield('content')
    </section>
  </main>

</body>
</html>
