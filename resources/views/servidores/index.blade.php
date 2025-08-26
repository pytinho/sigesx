@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
  @if (session('success'))
    <div class="help" style="color:#065f46; margin-bottom:8px">{{ session('success') }}</div>
  @endif

  <div class="list-header">
    <a class="btn btn-primary" href="{{ route('servidores.create') }}">+ Novo</a>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>E-mail</th>
          <th>Cidade/UF</th>
          <th>Vínculo</th>
          <th>Entrada</th>
          <th>Função</th>
          <th>Contato</th>
          <th class="col-acoes">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($servidores as $s)
          <tr>
            <td class="truncate">{{ $s->nome }}</td>
            <td>{{ $s->cpf }}</td>
            <td class="truncate">{{ $s->email }}</td>
            <td>{{ $s->cidade }}/{{ $s->uf }}</td>
            <td>{{ $s->vinculo }}</td>
            <td>
              @if(!empty($s->dt_entrada))
                {{ \Illuminate\Support\Carbon::parse($s->dt_entrada)->format('d/m/Y') }}
              @endif
            </td>
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
        @endforeach
        @if ($servidores->isEmpty())
          <tr><td colspan="9" class="empty">Nenhum servidor cadastrado.</td></tr>
        @endif
      </tbody>
    </table>
  </div>

  <div class="pager">
    {{ $servidores->onEachSide(1)->links() }}
  </div>

  <script>
    function confirmarExclusao(form){
      return confirm('Tem certeza que deseja excluir este registro? Esta ação não poderá ser desfeita.');
    }
  </script>
@endsection
