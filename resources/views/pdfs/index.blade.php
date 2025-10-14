@extends('layouts.app')
@section('title', 'Arquivos')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/arquivo.css') }}">
@endpush

@section('content')

@php
  // Valores do formulário de upload 
  $vUpload = fn ($name, $default = '') => old($name, $default);

  // Valores do filtro (lidos do GET)
  $f = [
    'ano' => request()->query('ano'),
    'q'   => request()->query('q'),
  ];
@endphp

<div class="container pdfs-page">

  {{-- Feedbacks --}}
  @if (session('success'))
    <div class="alert alert-success" style="margin-bottom:10px">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-error" style="margin-bottom:10px">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- ================= UPLOAD PRIMEIRO ================= --}}
  <h4 class="section-title section-title--upload mt-4 mb-2">📂 Upload de Arquivos</h4>

  <form
    action="{{ route('pdfs.store') }}"
    method="post"
    enctype="multipart/form-data"
    class="form-grid upload"
    style="margin-bottom:25px"
  >
    @csrf

    {{-- Dropzone ocupa a linha toda --}}
    <div class="form-group col-12">
      <label for="arquivo" class="mb-1">Arquivo (PDF) *</label>

      <div id="dropzone" class="uploader-dropzone" tabindex="0" role="button" aria-describedby="arquivo_help">
        <div class="uploader-icon">📄</div>
        <div class="uploader-text">
          <strong>Clique para selecionar</strong> ou solte aqui (PDF, até ~25MB)
        </div>
        <input
          type="file"
          id="arquivo"
          name="arquivo"
          accept="application/pdf"
          class="uploader-input @error('arquivo') is-invalid @enderror"
          required>
      </div>

      <div id="arquivo_nome" class="uploader-filename" aria-live="polite"></div>
      @error('arquivo')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror

    </div>

    {{-- Linha com Título (4), Ano (2) e Botão (2) --}}
    <div class="form-group col-4">
      <label for="titulo">Título *</label>
      <input
        type="text"
        id="titulo"
        name="titulo"
        class="form-control @error('titulo') is-invalid @enderror"
        value="{{ $vUpload('titulo') }}"
        placeholder="Ex: Contratações 2001"
        required>
      @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group col-2">
      <label for="ano">Ano *</label>
      <input
        type="number"
        id="ano"
        name="ano"
        class="form-control @error('ano') is-invalid @enderror"
        value="{{ $vUpload('ano', date('Y')) }}"
        min="1990" max="2100"
        step="1" inputmode="numeric"
        required
      >
      @error('ano')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group col-2 align-end">
      <label class="label-placeholder">&nbsp;</label>
      <button type="submit" class="btn-primary full-w" style="height:40px">Enviar PDF</button>
    </div>
  </form> {{-- fecha upload --}}

  {{-- ================= FILTROS ABAIXO ================= --}}
  <h4 class="section-title section-title--upload mt-4 mb-2">🔍 Busca de Arquivos</h4>
  <form method="GET" class="form-grid filters" style="margin-bottom:30px">
   
    {{-- mesma largura do campo "Título" --}}
   <div class="form-group col-4">
    <label for="filtro_q">Buscar por título</label>
    <input
      type="text"
      id="filtro_q"
      name="q"
      class="form-control"
      placeholder="Ex: Contrato 123"
      value="{{ $f['q'] ?? '' }}">
    </div>


    <div class="form-group col-2">
      <label for="filtro_ano">Ano</label>
      <input
        type="number"
        id="filtro_ano"
        name="ano"
        class="form-control"
        value="{{ $f['ano'] ?? '' }}"
        placeholder="{{ date('Y') }}"
        inputmode="numeric">
    </div>

    {{-- botão alinhado ao rodapé dos campos --}}
    <div class="form-group col-2 align-end">
      <label class="label-placeholder">&nbsp;</label>
      <button class="btn-primary full-w" style="height:40px">Filtrar</button>
    </div>

    {{-- ocupa o restante da linha no desktop --}}
    <div class="spacer"></div>
  </form>

  {{-- ================= LISTA (TABELA ESTILO SIGES + ORDENAR) ================= --}}
  @php
    $sort = request('sort','ano');
    $dir  = request('dir','desc');
    $is   = fn($f) => $sort === $f ? 'is-active '.$dir : '';
    $url  = fn($f,$d) => request()->fullUrlWithQuery(['sort'=>$f,'dir'=>$d]);
    $next = fn($f) => ($sort === $f && $dir === 'asc') ? 'desc' : 'asc';
  @endphp

  @if ($pdfs->count())
    <div class="table-wrap slim">
      <table class="tbl tbl-pdfs">
        <thead>
          <tr>
            <th style="width:72px;">
              <a class="th-sort {{ $is('ano') }}"
                 href="{{ $url('ano', $next('ano')) }}">
                <span>Ano</span><span class="arrow" aria-hidden="true"></span>
              </a>
            </th>

            <th>
              <a class="th-sort {{ $is('titulo') }}"
                 href="{{ $url('titulo', $next('titulo')) }}">
                <span>Título</span><span class="arrow" aria-hidden="true"></span>
              </a>
            </th>

            <th style="width:120px;">
              <a class="th-sort {{ $is('size') }}"
                 href="{{ $url('size', $next('size')) }}">
                <span>Tamanho</span><span class="arrow" aria-hidden="true"></span>
              </a>
            </th>

            <th style="width:160px;" class="ta-right">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pdfs as $p)
            <tr>
              <td class="muted">{{ $p->ano }}</td>
              <td class="cell-title" title="{{ $p->titulo }}">{{ $p->titulo }}</td>
              <td class="muted">{{ number_format($p->size / 1024 / 1024, 2) }} MB</td>
              <td class="ta-right nowrap">
                <a href="{{ route('pdfs.download',$p) }}" class="pill pill-primary">Baixar</a>

                <form action="{{ route('pdfs.destroy',$p) }}"
                      method="post"
                      class="inline"
                      onsubmit="return confirm('Remover este PDF?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="pill pill-danger">Excluir</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="pager">
      {{ $pdfs->appends(request()->query())->links() }}
    </div>
  @else
    <div class="empty"><em>Nenhum PDF encontrado.</em></div>
  @endif

@push('scripts')
<script>
  (function () {
    const dz = document.getElementById('dropzone');
    const input = document.getElementById('arquivo');
    const fileName = document.getElementById('arquivo_nome');

    function updateName(f) {
      if (!f) { fileName.textContent = ''; return; }
      fileName.textContent = `Selecionado: ${f.name} (${(f.size/1024/1024).toFixed(2)} MB)`;
    }

    dz.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
    });

    input.addEventListener('change', () => updateName(input.files?.[0]));

    ['dragenter','dragover'].forEach(evt => {
      dz.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.add('dragover');
      });
    });
    ['dragleave','drop'].forEach(evt => {
      dz.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.remove('dragover');
      });
    });
    dz.addEventListener('drop', (e) => {
      const files = e.dataTransfer.files;
      if (!files?.length) return;
      const file = files[0];
      if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        alert('Apenas arquivos PDF são permitidos.');
        return;
      }
      input.files = files;
      updateName(file);
    });
  })();
</script>
@endpush
@endsection
