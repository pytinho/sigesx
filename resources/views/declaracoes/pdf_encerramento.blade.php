{{-- resources/views/declaracoes/pdf_encerramento.blade.php --}}
@php
  use Carbon\Carbon;
  // Data de encerramento do servidor (dt_saida), se não tiver usa a data atual
  $dataFim = $servidor->dt_saida
      ? Carbon::parse($servidor->dt_saida)->locale('pt_BR')
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
    .assin  { text-align:center; margin-top:28px; }
    .assin .linha { margin-top:36px; border-top:1px solid #222; width:60%; margin-inline:auto; padding-top:6px; }
    .rodape { margin-top:12px; font-size:9.5pt; text-align:center; line-height:1.3; color:#222; }
    .sep { border-top:1px solid #e5e7eb; margin:8px 0; }
    /* Tabela de informações */
    .info { width:100%; border-collapse:collapse; margin-top:8px; }
    .info th, .info td { border:1px solid #e5e7eb; padding:6px 8px; }
    .info th { background:#f8fafc; text-align:left; font-weight:700; color:#374151; width:22%; }
    .info td { color:#111827; word-break:break-word; }
  </style>
  </head>
<body>

  {{-- Cabeçalho institucional fixo --}}
  <div class="cabec">
    <div class="l1">PREFEITURA MUNICIPAL DE PALMAS</div>
    <div class="l2">SECRETARIA MUNICIPAL DA EDUCAÇÃO</div>
    <div class="l3">ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</div>
  </div>

  <div class="sep"></div>
  <div class="titulo">{{ $titulo }}</div>
  <div class="sep"></div>

  {{-- Texto principal com a data de saída --}}
  <p class="texto">
    Declaramos, para fins de comprovação junto à Secretaria Municipal da Educação, que o(a) servidor(a) abaixo qualificado(a) 
    <strong>ENCERROU</strong> suas atividades nesta Unidade Escolar no dia
    <strong>{{ $dataFim->translatedFormat('d') }} de {{ $dataFim->translatedFormat('F') }} de {{ $dataFim->translatedFormat('Y') }}</strong>.
  </p>

  {{-- Informações em tabela --}}
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

  {{-- Local e data (data de hoje para assinatura) --}}
  <p style="margin-top:16px;">
    Palmas, {{ $agora->translatedFormat('d') }} de {{ $agora->translatedFormat('F') }} de {{ $agora->translatedFormat('Y') }}
  </p>

  {{-- Assinaturas --}}
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

