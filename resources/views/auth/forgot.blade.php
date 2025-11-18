<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Recuperar acesso SIGES</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/forgot.css') }}">
</head>
<body class="login-bg">
  <main class="login-center">
    <section class="login-card">
      <h1 class="login-title"><strong>Recuperar acesso</strong></h1>
      <p class="forgot-text forgot-text--spaced">
        Para redefinir sua senha, entre em contato com a equipe de suporte informando seu CPF e e-mail institucional.
      </p>
      <p class="forgot-text">
        <strong>Suporte:</strong> <a href="mailto:suporte.siges@gmail.com"> suporte.siges@gmail.com</a><br>
        <strong>Telefone:</strong> (63) 98473-8913
      </p>
      <a href="{{ route('login') }}" class="return-link">Voltar ao login</a>
    </section>
  </main>
</body>
</html>
