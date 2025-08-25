@extends('layouts.app')

@section('content')
  <div class="card">
    <h1 class="header">Servidores</h1>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a class="btn" href="{{ route('servidores.create') }}">Novo</a>

    <table style="width:100%; border-collapse:collapse; margin-top:12px">
      <thead>
        <tr>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Nome</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">CPF</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Função</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Contato</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($servidores as $s)
          <tr>
            <td style="padding:8px; border-bottom:1px solid #eee;">{{ $s->nome }}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">{{ $s->cpf }}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">{{ $s->funcao->nome ?? '-' }}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">{{ $s->contato ?: '—' }}</td>

          </tr>
        @empty
          <tr><td colspan="4" style="padding:8px">Nenhum registro</td></tr>
        @endforelse
      </tbody>
    </table>

    <div style="margin-top:10px">
      {{ $servidores->links() }}
    </div>
  </div>
@endsection
