{{-- resources/views/declaracoes/pdf_vinculo.blade.php --}}
@php
  use Carbon\Carbon;
  $agora = $agora ?? Carbon::now();
  $dtEntrada = $servidor->dt_entrada ? Carbon::parse($servidor->dt_entrada) : null;
  $dtSaida   = $servidor->dt_saida   ? Carbon::parse($servidor->dt_saida)   : null;

  $cpf = preg_replace('/\D/', '', (string)($servidor->cpf ?? ''));
  $cpfFmt = $cpf && strlen($cpf) === 11 ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf) : ($servidor->cpf ?? '');
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
    .titulo { text-align:center; font-family: DejaVu Sans, Arial, Helvetica, sans-serif;font-weight:800; 
      font-size:13.5pt; margin: 10px 0 12px; text-transform:uppercase; color:#262626; }
    .texto  { text-align:justify; margin: 8px 0 10px; }
    .sep { border-top:1px solid #e5e7eb; margin:8px 0; }
    .rodape { margin-top:12px; font-size:9.5pt; text-align:center; line-height:1.3; color:#222; }
    .info { width:100%; border-collapse:collapse; margin-top:8px; }
    .info th, .info td { border:1px solid #e5e7eb; padding:6px 8px; }
    .info th { background:#f8fafc; text-align:left; font-weight:700; color:#374151; }
    .info td { color:#111827; word-break:break-word; }
  </style>
</head>
<body>

  {{-- Cabeçalho institucional fixo --}}
  <div class="cabec">
    <div class="l1">PREFEITURA MUNICIPAL DE PALMAS</div>
    <div class="l2">SECRETARIA DA EDUCAÇÃO</div>
    <div class="l3">ESCOLA MUNICIPAL DE TEMPO INTEGRAL LUIZ GONZAGA</div>
  </div>

  <div class="sep"></div>
  <div class="titulo">{{ $titulo }}</div>
  <div class="sep"></div>

  {{-- Texto principal --}}
  <p class="texto">
    Para fins de comprovação da atividade típica de magistério, DECLARAMOS que o(a) servidor(a)
    <strong>{{ $servidor->nome }}</strong>, inscrito(a) no Cadastro de Pessoas Físicas – CPF sob o nº
    <strong>{{ $cpfFmt }}</strong>,
    @if($dtSaida)
      fez parte do quadro de servidores desta Unidade Escolar, exercendo o cargo de
      <strong>{{ $servidor->cargo }}</strong>, com encerramento em
      <strong>{{ $dtSaida->format('d/m/Y') }}</strong>, conforme o especificado na tabela abaixo:
    @else
      faz parte do quadro de servidores desta Unidade Escolar, exercendo o cargo de
      <strong>{{ $servidor->cargo }}</strong>, conforme o especificado na tabela abaixo:
    @endif
  </p>

  {{-- Tabela com dados do vínculo --}}
  <table class="info">
    <thead>
      <tr>
        <th style="width:24%">Período</th>
        <th style="width:22%">Cargo</th>
        <th style="width:24%">Função</th>
        <th style="width:15%">Carga Horária</th>
        <th style="width:15%">Unidade</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          @if($dtSaida)
            {{-- Período fechado: início a fim --}}
            {{ $dtEntrada ? $dtEntrada->format('d/m/Y') : '-' }} a {{ $dtSaida->format('d/m/Y') }}
          @else
            {{-- Ativo: desde a data inicial --}}
            desde {{ $dtEntrada ? $dtEntrada->format('d/m/Y') : '-' }}
          @endif
        </td>
        <td>{{ $servidor->cargo ?? '-' }}</td>
        <td>{{ optional($servidor->funcao)->nome ?? '-' }}</td>
        <td>{{ $servidor->carga_horaria ? $servidor->carga_horaria.' h/semana' : '-' }}</td>
        <td>{{ $servidor->unidade_escolar ?? 'ETI LUIZ GONZAGA' }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Local e data --}}
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
