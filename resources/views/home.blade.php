@extends('layouts.app')

@section('title', 'Início')
@push('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
  <h2 class="dashboard-title">Seja Bem-vindo(a) <br> ao Sistema Integrado de Gestão Escolar</h2>

  <div class="dashboard-chart">

  </div>

  <div class="cards-row">
    <div class="stat-card blue-card">
      {{ $totalServidores ?? 0 }}
      <span>Cadastros</span>
    </div>
    <div class="stat-card yellow-card">
      {{ $totalPdfs ?? 0 }}
      <span>Arquivos</span>
    </div>
  </div>

  <div class="dashboard-grid">
    <div class="panel">
      <h3 class="panel-title">Últimos PDFs</h3>
      @if(!empty($pdfsRecentes) && count($pdfsRecentes))
        <ul class="panel-list">
          @foreach($pdfsRecentes as $p)
            <li>
              <div class="small" title="{{ $p->titulo }}">{{ $p->ano }} • {{ \Illuminate\Support\Str::limit($p->titulo, 38) }}</div>
              <div>
                <a href="{{ route('pdfs.download',$p) }}" class="muted">baixar</a>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="muted">Sem PDFs recentes.</div>
      @endif
      <div style="margin-top:8px"><a href="{{ route('pdfs.index') }}">Ver todos</a></div>
    </div>

    <div class="panel">
      <h3 class="panel-title">Últimos Cadastros</h3>
      @if(!empty($servidoresRecentes) && count($servidoresRecentes))
        <ul class="panel-list">
          @foreach($servidoresRecentes as $s)
            <li>
              <div class="small" title="{{ $s->nome }}">{{ \Illuminate\Support\Str::limit($s->nome, 38) }}</div>
              <div class="muted">{{ $s->cargo }}</div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="muted">Sem cadastros recentes.</div>
      @endif
      <div style="margin-top:8px"><a href="{{ route('servidores.index') }}">Ver todos</a></div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart');
const dashboardData = @json([
  'cadastros' => (int)($totalServidores ?? 0),
  'pdfs'      => (int)($totalPdfs ?? 0),
]);
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Cadastros', 'Arquivos'],
    datasets: [{
      label: 'Indicadores',
      data: [dashboardData.cadastros, dashboardData.pdfs],
      backgroundColor: ['#1848c9', '#fcd84f'],
      borderRadius: 8,
    }]
  },
  options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } } }
});
</script>
@endpush
