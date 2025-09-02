<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>{{ $titulo }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12pt; color:#111; }
    .cabec { text-align:center; margin-bottom:28px; }
    .cabec h1 { font-size: 18pt; margin:0; }
    .linha { margin: 8px 0; }
    .assin { margin-top:60px; text-align:center; }
    .muted { color:#666; font-size:10pt; }
  </style>
</head>
<body>
  <div class="cabec">
    <h1>{{ $titulo }}</h1>
    <div class="muted">{{ $agora->translatedFormat('d \\d\\e F \\d\\e Y') }}</div>
  </div>

  <p>Declaramos, para os devidos fins, que <strong>{{ $servidor->nome }}</strong>,
  CPF {{ $servidor->cpf }}, exerce o cargo de <strong>{{ $servidor->cargo ?? '—' }}</strong>
  e a função de <strong>{{ optional($servidor->funcao)->nome ?? '—' }}</strong>
  nesta instituição.</p>

  @if($tipo === 'frequencia')
    <p>Conforme registros, o(a) servidor(a) encontra-se em regular exercício de suas atividades.</p>
  @endif

  <div class="linha">E-mail: {{ $servidor->email ?? '—' }}</div>
  <div class="linha">Contato: ({{ $servidor->ddd }}) {{ $servidor->celular }}</div>

  <div class="assin">
    _______________________________________<br>
    Responsável<br>
    <span class="muted">SIGES – Sistema Integrado de Gestão Escolar</span>
  </div>
</body>
</html>
