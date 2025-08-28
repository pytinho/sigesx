@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
  @if (session('success'))
    <div class="help" style="color:#065f46; margin-bottom:8px">{{ session('success') }}</div>
  @endif

  <div class="list-tools">
    <form method="GET" action="{{ route('servidores.index') }}" class="search-form">
      <input
        type="text"
        name="q"
        value="{{ $q ?? request('q') }}"
        placeholder="Buscar por nome, CPF, e-mail, cidade, UF, vínculo ou função…"
        aria-label="Buscar servidores"
      />
      @if(!empty($q))
        <a class="btn btn-light" href="{{ route('servidores.index') }}">Limpar</a>
      @endif
      <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <a class="btn btn-primary" href="{{ route('servidores.create') }}">+ Novo</a>
  </div>

  @if(!empty($q))
    <div class="help" style="margin:6px 0 12px">Filtrando por: <strong>{{ $q }}</strong></div>
  @endif

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Vínculo</th>
          <th>Entrada</th>
          <th>Função</th>
          <th>Contato</th>
          <th class="col-acoes">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($servidores as $s)
          <tr>
            <td class="truncate">{{ $s->nome }}</td>
            <td>{{ $s->cpf }}</td>
            <td>{{ $s->vinculo }}</td>
            <td>@if($s->dt_entrada) {{ \Illuminate\Support\Carbon::parse($s->dt_entrada)->format('d/m/Y') }} @endif</td>
            <td class="truncate">{{ $s->funcao->nome ?? '—' }}</td>
            <td>{{ $s->contato ?: '—' }}</td>
            <td class="acoes">
              <a href="{{ route('servidores.edit',$s->id) }}" class="btn-pill btn-blue">Editar</a>
              <form action="{{ route('servidores.destroy',$s->id) }}" method="POST" onsubmit="return confirmarExclusao(this)">
                @csrf @method('DELETE')
                <button type="submit" class="btn-pill btn-red">Excluir</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="empty">Nenhum servidor encontrado.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

   <div class="pager">
  @if ($servidores->hasPages())
    <nav class="pagination">
      {{-- Anterior --}}
      @if ($servidores->onFirstPage())
        <span class="page disabled" aria-disabled="true">‹</span>
      @else
        <a class="page" href="{{ $servidores->previousPageUrl() }}" rel="prev">‹</a>
      @endif

      {{-- Números (janela de -2 a +2 da página atual) --}}
      @php
        $start = max(1, $servidores->currentPage() - 2);
        $end   = min($servidores->lastPage(), $servidores->currentPage() + 2);
      @endphp
      @for ($page = $start; $page <= $end; $page++)
        @if ($page == $servidores->currentPage())
          <span class="page active" aria-current="page">{{ $page }}</span>
        @else
          <a class="page" href="{{ $servidores->url($page) }}">{{ $page }}</a>
        @endif
      @endfor

      {{-- Próxima --}}
      @if ($servidores->hasMorePages())
        <a class="page" href="{{ $servidores->nextPageUrl() }}" rel="next">›</a>
      @else
        <span class="page disabled" aria-disabled="true">›</span>
      @endif
    
      <span class="page-info">
        Mostrando {{ $servidores->firstItem() }}–{{ $servidores->lastItem() }} de {{ $servidores->total() }}
      </span>
    </nav>
  @endif
</div>

  <script>
    function confirmarExclusao(){ return confirm('Tem certeza que deseja excluir este registro?'); }
  </script>
@endsection
