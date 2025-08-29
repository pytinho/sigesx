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

        <label for="email">Login:</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}" placeholder="Insira seu e-mail"
               autocomplete="username" autofocus required>

        <label for="password">Senha:</label>
        <div class="field-pass">
          <input type="password" id="password" name="password"
                 placeholder="Insira sua senha de acesso" autocomplete="current-password" required>
          <button type="button" class="eye" aria-label="Mostrar/ocultar senha">👁️</button>
        </div>

        <button type="submit" class="btn-primary">Entrar</button>

        <div class="login-links">
          <a href="#" onclick="alert('Em breve.');return false;">Esqueci minha senha</a>
          <span> | </span>
          <a href="#" onclick="alert('Cadastro via administração.');return false;">Não possuo cadastro</a>
        </div>
      </form>
    </section>
  </main>

  <script>
    // Alternar visibilidade da senha
    document.querySelector('.eye').addEventListener('click', function(){
      const i = document.getElementById('password');
      i.type = i.type === 'password' ? 'text' : 'password';
      this.classList.toggle('on');
    });
  </script>
</body>
</html>
