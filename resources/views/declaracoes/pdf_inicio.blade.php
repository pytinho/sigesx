{{-- resources/views/declaracoes/pdf_inicio.blade.php --}}
@php
  use Carbon\Carbon;
  // Data de início do servidor (dt_entrada), se não tiver usa a data atual
  $dataInicio = $servidor->dt_entrada
      ? Carbon::parse($servidor->dt_entrada)->locale('pt_BR')
      : $agora;
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>{{ $titulo }}</title>
  <style>
    @page { margin: 28mm 20mm 25mm 20mm; }
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#111; font-size:12pt; }
    .cabec { text-align:center; line-height:1.25; margin-bottom:18px; }
    .cabec .l1 { font-weight:700; font-size:12pt; }
    .cabec .l2 { font-weight:700; font-size:11pt; }
    .cabec .l3 { font-weight:700; font-size:10.5pt; }
    .titulo { text-align:center; font-weight:800; font-size:15pt; margin: 18px 0; text-transform:uppercase; }
    .texto  { text-align:justify; margin: 10px 0 14px; }
    .campo  { display:flex; margin: 6px 0; }
    .label  { width: 240px; font-weight:700; }
    .valor  { flex:1; border-bottom:1px solid #222; padding:0 4px 2px; }
    .assin  { text-align:center; margin-top:40px; }
    .assin .linha { margin-top:50px; border-top:1px solid #222; width:70%; margin-inline:auto; padding-top:6px; }
    .rodape { margin-top:22px; font-size:10pt; text-align:center; line-height:1.35; color:#222; }
    .muted  { color:#444; }
  </style>
</head>
<body>

  {{-- Cabeçalho institucional fixo --}}
  <div class="cabec">
    <div class="l1">PREFEITURA MUNICIPAL DE PALMAS</div>
    <div class="l2">SECRETARIA DA EDUCAÇÃO</div>
    <div class="l3">NOME UNIDADE ESCOLAR: ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</div>
  </div>

  <div class="titulo">Declaração de Início de Atividade</div>

  {{-- Texto principal com a data de entrada --}}
  <p class="texto">
    Declaramos, para fins de comprovação junto à Secretaria Municipal da Educação, que o(a) servidor(a)
    abaixo qualificado(a) <strong>INICIOU</strong> suas atividades nesta Unidade Escolar no dia
    <strong>{{ $dataInicio->translatedFormat('d') }} de {{ $dataInicio->translatedFormat('F') }} de {{ $dataInicio->translatedFormat('Y') }}</strong>.
  </p>

  {{-- Campos --}}
  <div class="campo">
    <div class="label">Nome Completo:</div>
    <div class="valor">{{ $servidor->nome }}</div>
  </div>

  <div class="campo">
    <div class="label">C.P.F:</div>
    <div class="valor">{{ $servidor->cpf }}</div>
  </div>

  <div class="campo">
    <div class="label">Vínculo:</div>
    <div class="valor">{{ $servidor->vinculo ?? '' }}</div>
  </div>

  <div class="campo">
    <div class="label">Cargo:</div>
    <div class="valor">{{ $servidor->cargo ?? '' }}</div>
  </div>

  <div class="campo">
    <div class="label">Função:</div>
    <div class="valor">{{ optional($servidor->funcao)->nome ?? '' }}</div>
  </div>

  <div class="campo">
    <div class="label">Carga Horária Semanal:</div>
    <div class="valor">{{ $servidor->carga_horaria ?? '' }}</div>
  </div>

  <div class="campo">
    <div class="label">Unidade Escolar:</div>
    <div class="valor">ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</div>
  </div>

  <div class="campo">
    <div class="label">Código da Unidade Escolar:</div>
    <div class="valor">514.3.28</div>
  </div>

  {{-- Local e data (data de hoje para assinatura) --}}
  <p style="margin-top:16px;">
    Palmas, {{ $agora->translatedFormat('d') }} de {{ $agora->translatedFormat('F') }} de {{ $agora->translatedFormat('Y') }}
  </p>

{{-- Assinatura --}}
<p style="text-align:center; margin-top:60px;">
  _______________________________________<br>
  Gestor Educacional
</p>

  {{-- Rodapé --}}
  <div class="rodape">
    E-mail: escluizgonzaga@semed.palmas.to.gov.br<br>
    End.: 503 NORTE APM 06  AL 05 CEP: 77.001-828   PALMAS-TO<br>
    FONE: (63) 3225-0355
  </div>
</body>
</html>
