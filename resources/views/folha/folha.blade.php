@extends('layouts.app')

@section('title','Folha de Ponto')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/folha.css') }}">
@endpush

@section('content')
<div>
  <form method="GET" class="folha-filtros no-print">
    <div class="form-group">
      <label for="mes">Mês</label>
      <select id="mes" name="mes" class="form-control">
        @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" {{ (int)$mes === $m ? 'selected' : '' }}>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
        @endfor
      </select>
    </div>
    <div class="form-group">
      <label for="ano">Ano</label>
      <input id="ano" name="ano" type="number" class="form-control" value="{{ $ano }}" min="1990" max="2100" />
    </div>
    <div class="col-3 form-group">
      <label for="cpf">CPF</label>
      <input id="cpf" name="cpf" type="text" class="form-control" value="{{ $cpf ?? '' }}" placeholder="Somente números" />
    </div>

    <div class="col-3 form-group">
      <label for="funcao_id">Função</label>
      <select id="funcao_id" name="funcao_id" class="form-control">
        <option value="">Todas</option>
        @foreach($funcoes as $f)
          <option value="{{ $f->id }}" {{ (string)($funcaoId ?? '') === (string)$f->id ? 'selected' : '' }}>{{ $f->nome }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 btn-row">
      <button class="btn-primary" name="gerar" value="1" type="submit">Gerar</button>
      <button class="btn-primary" type="submit" formaction="{{ route('folha.pdf') }}" formmethod="POST">Gerar PDF</button>
    </div>
    @csrf
    <div class="col-6" style="margin-top:4px;">
      <span class="muted">Unidade Escolar: {{ $unidadeUnica ?? '—' }}</span>
    </div>
  </form>

  @if($gerar && $servidores->count())
    @foreach($servidores as $s)
      <div class="sheet">
        <div class="sheet-header">
          <div>
            <div class="sheet-title">Folha de Ponto - {{ sprintf('%02d/%04d', $mes, $ano) }}</div>
            <div class="muted">{{ $s->nome }} — {{ $s->cargo }} {{ optional($s->funcao)->nome ? ' • '.optional($s->funcao)->nome : '' }}</div>
            @if($s->unidade_escolar)
              <div class="muted">Unidade: {{ $s->unidade_escolar }}</div>
            @endif
          </div>
          <div class="muted">CPF: {{ $s->cpf }}</div>
        </div>

        <div class="wrap">
          <table class="tbl">
            <thead>
              <tr>
                <th class="sticky-col">Dia</th>
                @foreach($dias as $d)
                  <th title="{{ \Illuminate\Support\Str::ucfirst($d['dow']) }}">{{ $d['n'] }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr class="row-entrada">
                <td class="sticky-col">Entrada</td>
                @foreach($dias as $d)
                  <td>&nbsp;</td>
                @endforeach
              </tr>
              <tr class="row-saida">
                <td class="sticky-col">Saída</td>
                @foreach($dias as $d)
                  <td>&nbsp;</td>
                @endforeach
              </tr>
              <tr class="row-ass">
                <td class="sticky-col">Obs./Ass.</td>
                @foreach($dias as $d)
                  <td>&nbsp;</td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>

        <div style="display:flex; gap:20px; margin-top:16px;">
          <div style="flex:1; text-align:center;">
            <div style="border-top:1px solid #e5e7eb; width:50%; margin:0 auto;"></div>
            <div class="muted" style="margin-top:6px;">Assinatura do Servidor</div>
          </div>
          <div style="flex:1; text-align:center;">
            <div style="border-top:1px solid #e5e7eb; width:50%; margin:0 auto;"></div>
            <div class="muted" style="margin-top:6px;">Assinatura da Chefia</div>
          </div>
        </div>
      </div>
    @endforeach
  @elseif($gerar)
    <div class="muted">Nenhum servidor encontrado para os filtros informados.</div>
  @else
    <div class="muted">Selecione mês/ano e filtros (CPF/Cargo/Função), depois clique em Gerar.</div>
  @endif
</div>
@endsection
