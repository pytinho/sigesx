{{-- resources/views/declaracoes/pdf_inicio.blade.php --}}
@php
  use Carbon\Carbon;
  // Data de inÃ­cio do servidor (dt_entrada), se nÃ£o tiver usa a data atual
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
    @page { margin: 16mm 14mm 16mm 14mm; }
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#232323; font-size:11pt; }
    .cabec { text-align:center; line-height:1.2; margin-bottom:10px; }
    .cabec .l1 { font-weight:700; font-size:11pt; }
    .cabec .l2 { font-weight:700; font-size:10pt; }
    .cabec .l3 { font-weight:700; font-size:9.5pt; }
    .titulo { text-align:center; font-family: DejaVu Sans, Arial, Helvetica, sans-serif;font-weight:800; font-size:13.5pt; margin: 10px 0 12px; text-transform:uppercase; color:#262626; }
    .texto  { text-align:justify; margin: 8px 0 10px; }
    .campo  { display:flex; margin: 4px 0; }
    .label  { width: 200px; font-weight:700; }
    .valor  { flex:1; border-bottom:1px solid #222; padding:0 3px 2px; }
    .assin  { text-align:center; margin-top:28px; }
    .assin .linha { margin-top:36px; border-top:1px solid #222; width:60%; margin-inline:auto; padding-top:6px; }
    .rodape { margin-top:12px; font-size:9.5pt; text-align:center; line-height:1.3; color:#222; }

    .sep { border-top:1px solid #e5e7eb; margin:8px 0; }
    /* Tabela de informaÃ§Ãµes */
    .info { width:100%; border-collapse:collapse; margin-top:8px; }
    .info th, .info td { border:1px solid #e5e7eb; padding:6px 8px; }
    .info th { background:#f8fafc; text-align:left; font-weight:700; color:#374151; width:22%; }
    .info td { color:#111827; word-break:break-word; }
  </style>
</head>
<body>

  {{-- CabeÃ§alho institucional fixo --}}
  <div class="cabec">
    <div class="l1">PREFEITURA MUNICIPAL DE PALMAS</div>
    <div class="l2">SECRETARIA DE EDUCAÇÃO</div>
    <div class="l3">ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</div>
  </div>

  <div class="sep"></div>
  <div class="titulo">Declaração de Início de Atividade</div>

  <div class="sep"></div>
  {{-- Texto principal com a data de entrada --}}
  <p class="texto">
    Declaramos, para fins de comprovação junto à Secretaria Municipal da Educação, que o(a) servidor(a)
    abaixo qualificado(a) <strong>INICIOU</strong> suas atividades nesta Unidade Escolar no dia
    <strong>{{ $dataInicio->translatedFormat('d') }} de {{ $dataInicio->translatedFormat('F') }} de {{ $dataInicio->translatedFormat('Y') }}</strong>.
  </p>
  
  {{-- Informações em tabela (layout mais agradável) --}}
  <table class="info">
    <tr>
      <th>Nome Completo</th>
      <td colspan="3">{{ $servidor->nome }}</td>
    </tr>
    <tr>
      <th>C.P.F</th>
      <td>{{ $servidor->cpf }}</td>
      <th>Vínculo</th>
      <td>{{ $servidor->vinculo ?? '' }}</td>
    </tr>
    <tr>
      <th>Cargo</th>
      <td>{{ $servidor->cargo ?? '' }}</td>
      <th>Função</th>
      <td>{{ optional($servidor->funcao)->nome ?? '' }}</td>
    </tr>
    <tr>
      <th>Carga Horária Semanal</th>
      <td>{{ $servidor->carga_horaria ?? '' }}</td>
      <th>Código da Unidade</th>
      <td>514.3.28</td>
    </tr>
    <tr>
      <th>Unidade Escolar</th>
      <td colspan="3">ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</td>
    </tr>
  </table>

  {{-- Campos (ocultos; tabela acima) --}}<div style="display:none">
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

  </div>

  <p style="margin-top:16px;">
    Palmas, {{ $agora->translatedFormat('d') }} de {{ $agora->translatedFormat('F') }} de {{ $agora->translatedFormat('Y') }}
  </p>


<p style="text-align:center; margin-top:60px;">
  _______________________________________<br>
  Gestor Educacional
</p>


  <div class="rodape">
    E-mail: escluizgonzaga@semed.palmas.to.gov.br<br>
    End.: 503 NORTE APM 06  AL 05 CEP: 77.001-828   PALMAS-TO<br>
    FONE: (63) 3225-0355
  </div>
</body>
</html>
