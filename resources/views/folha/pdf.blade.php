<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Folha de Ponto</title>
  <style>
    @page { margin: 8mm 6mm; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color:#111; }
    .sheet { page-break-after: always; border:1px solid #d1d5db; padding:8px; margin-bottom:10px; }
    .sheet:last-child { page-break-after: auto; }
    .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px; }
    .title { font-weight:700; color:#0b3a73; font-size: 12px; }
    .subtitle { color:#374151; font-size:10px; margin-top:1px; }
    .muted { color:#6b7280; font-size:9px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #d1d5db; padding:3px 5px; text-align:center; }
    th { background:#f6f7fb; }
    /* Larguras por coluna */
    th.dia, td.dia { text-align:left; width:36px; }
    th.dow, td.dow { text-align:center; width:100px; }
    th.ent, td.ent { width:50px; }
    th.sai, td.sai { width:50px; }
    th.ass, td.ass { width:auto; }
    tbody td { height: 18px; }

    /* ===== Assinaturas ===== */
    .signatures {
      margin-top: 25px;
      display: table;
      width: 100%;
    }
    .sig {
      display: table-cell;
      width: 50%;
      text-align: center;
      vertical-align: bottom;
    }
    .sig .line {
      border-top: 1px solid #d1d5db;
      width: 80%;
      margin: 0 auto;
      height: 45px;
    }
    .sig .label {
      margin-top: 0px;
      font-size: 10px;
    }
  </style>
</head>
<body>
@foreach($servidores as $s)
  <div class="sheet">
    <div class="header">
      <div>
        <div class="title">Folha de Ponto</div>
        <div class="subtitle">{{ \Illuminate\Support\Str::ucfirst($mesNome) }} de {{ $ano }}</div>
        <div class="muted">{{ $s->nome }} — {{ $s->cargo }} {{ optional($s->funcao)->nome ? ' • '.optional($s->funcao)->nome : '' }}</div>
        @if($s->unidade_escolar)
          <div class="muted">Unidade: {{ $s->unidade_escolar }}</div>
        @endif
      </div>
      <div class="muted">CPF: {{ $s->cpf }}</div>
    </div>

    <table>
      <thead>
        <tr>
          <th class="dia">Dia</th>
          <th class="dow">Semana</th>
          <th class="ent">Entrada</th>
          <th class="sai">Saída</th>
          <th class="ass">Obs./Ass.</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dias as $d)
        <tr>
          <td class="dia" title="{{ $d['dow'] }}">{{ $d['n'] }}</td>
          <td class="dow">{{ \Illuminate\Support\Str::ucfirst($d['dow']) }}</td>
          <td class="ent"></td>
          <td class="sai"></td>
          <td class="ass"></td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="signatures">
      <div class="sig">
        <div class="line"></div>
        <div class="label">Assinatura do Servidor</div>
      </div>
      <div class="sig">
        <div class="line"></div>
        <div class="label">Assinatura da Chefia</div>
      </div>
    </div>
  </div>
@endforeach
</body>
</html>
