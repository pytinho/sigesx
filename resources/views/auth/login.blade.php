<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login · SIGES</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-bg">

  <main class="login-center">
    <section class="login-card">
      <h1 class="login-title">SIGES</h1>

      @if ($errors->any())
        <div class="msg-error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login.perform') }}" novalidate>
        @csrf

        <label for="login">Usuário:</label>
<input class="control" type="text" id="login" name="login"
       value="{{ old('login') }}" placeholder="Insira seu usuário de acesso"
       autocomplete="username" autofocus required>

<label for="password">Senha:</label>
<div class="field-pass">
  <input class="control" type="password" id="password" name="password"
         placeholder="Insira sua senha de acesso" autocomplete="current-password" required>
  <button type="button"
        class="eye"
        aria-label="Mostrar senha"
        title="Mostrar senha"
        data-show="🙊"   
        data-hide="🙈">  
</button>
</div>

@if (Route::has('password.request'))
<p class="login-links">
  <a href="{{ route('password.request') }}">Esqueci minha senha</a>
</p>
@endif

<button class="btn-primary" type="submit">Entrar</button>


<script>
  const eye  = document.querySelector('.eye');
  const pass = document.getElementById('password');

  const EMOJI_VISIBLE = eye.dataset.show || '🙊'; 
  const EMOJI_HIDDEN  = eye.dataset.hide || '🙈'; 

 
  function syncButton() {
    const hidden = pass.type === 'password';
    eye.textContent = hidden ? EMOJI_HIDDEN : EMOJI_VISIBLE;
    eye.classList.toggle('on', !hidden);
    eye.setAttribute('aria-label', hidden ? 'Mostrar senha' : 'Ocultar senha');
    eye.title = hidden ? 'Mostrar senha' : 'Ocultar senha';
  }
  syncButton();

  eye.addEventListener('click', () => {
    const willReveal = pass.type === 'password'; 
    pass.type = willReveal ? 'text' : 'password';
    syncButton();

    
    pass.focus();
    const end = pass.value.length;
    pass.setSelectionRange(end, end);
  });
</script>


