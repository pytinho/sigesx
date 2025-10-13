@extends('layouts.app')

@section('content')
<div class="container">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Filtros --}}
  <form method="GET" class="card p-3 mb-3">
    <div class="row g-2">
      <div class="col-md-2">
        <label class="form-label">Ano</label>
        <input type="number" name="ano" class="form-control" value="{{ request('ano') }}">
      </div>
      <div class="col-md-8">
        <label class="form-label">Buscar por título</label>
        <input type="text" name="q" class="form-control" placeholder="Ex: Contrato 123" value="{{ request('q') }}">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Filtrar</button>
      </div>
    </div>
  </form>

  {{-- Upload --}}
  <form action="{{ route('pdfs.store') }}" method="post" enctype="multipart/form-data" class="card p-3 mb-4">
    @csrf
    <div class="row g-2">
      <div class="col-md-4">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
        @error('titulo')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-2">
        <label class="form-label">Ano</label>
        <input type="number" name="ano" class="form-control" value="{{ date('Y') }}" required>
        @error('ano')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <label class="form-label">Arquivo (PDF)</label>
        <input type="file" name="arquivo" class="form-control" accept="application/pdf" required>
        @error('arquivo')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-success w-100">Enviar</button>
      </div>
    </div>
  </form>

  {{-- Lista --}}
  <div class="row g-3">
    @forelse($pdfs as $p)
      <div class="col-md-3">
        <div class="card h-100 p-2 d-flex">
          <div class="small text-muted">{{ $p->ano }}</div>
          <strong class="mt-1">{{ $p->titulo }}</strong>
          <div class="mt-1 small">{{ number_format($p->size / 1024 / 1024, 2) }} MB</div>
          <div class="mt-auto d-flex gap-2">
            <a href="{{ route('pdfs.download',$p) }}" class="btn btn-sm btn-primary">Baixar</a>
            <form action="{{ route('pdfs.destroy',$p) }}" method="post" onsubmit="return confirm('Remover este PDF?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Excluir</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12"><em>Nenhum PDF encontrado.</em></div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $pdfs->links() }}
  </div>

</div>
@endsection
