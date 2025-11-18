@extends('layouts.app')
@section('title','Declarações')

@section('content')

  {{-- feedbacks --}}
  @if (session('success'))
    <div class="alert alert-success" style="margin-bottom:10px">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-error" style="margin-bottom:10px">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form id="formDeclaracao" method="POST" action="{{ route('declaracoes.gerar') }}" class="form-grid">
    @csrf

    {{-- Linha 1 --}}
    <div class="form-group col-6">
      <label for="tipo">Tipo de Declaração</label>
      <select name="tipo" id="tipo" class="form-control" required>
        <option value="">Selecione...</option>
        @foreach($tipos as $val => $label)
          <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
      </select>
      <div class="help">Escolha o modelo do documento.</div>
    </div>

    <div class="form-group col-3">
      <label for="cpf">CPF</label>
      <div style="display:flex; gap:6px; align-items:center;">
        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" required style="flex:1 1 auto;">
        <button type="button" id="btnCpfBuscar" class="btn-primary" title="Buscar por CPF">Buscar</button>
      </div>
      <div class="help">Digite o CPF e clique em Buscar.</div>
    </div>

    <div class="form-group col-3"><!-- espa�ador --></div>

    {{-- Linha 2 --}}
    <div class="form-group col-6">
      <label for="nome">Nome</label>
      <input type="text" id="nome" class="form-control" readonly>
    </div>

    <div class="form-group col-4">
      <label for="email">E-mail</label>
      <input type="text" id="email" class="form-control" readonly>
    </div>

    <div class="form-group col-2"><!-- espa�ador --></div>

    {{-- Linha 3 --}}
    <div class="form-group col-4">
      <label for="cargo">Cargo</label>
      <input type="text" id="cargo" class="form-control" readonly>
    </div>

    <div class="form-group col-6">
      <label for="funcao">Função</label>
      <input type="text" id="funcao" class="form-control" readonly>
    </div>

    <div class="form-group col-2"><!-- espaçador --></div>

    {{-- Ações --}}
    <div class="actions col-12">
      <button type="submit" class="btn-primary">Baixar PDF</button>
    </div>
  </form>

  <script>
    const routeLookup = @json(route('declaracoes.lookup'));
    const $cpf = document.getElementById('cpf');
    const $btnBuscar = document.getElementById('btnCpfBuscar');
    const $nome = document.getElementById('nome');
    const $email = document.getElementById('email');
    const $cargo = document.getElementById('cargo');
    const $funcao = document.getElementById('funcao');
    const $cpfHelp = (() => $cpf.closest('.form-group')?.querySelector('.help') || null)();
    function onlyDigits(v){ return (v||'').replace(/\D/g,''); }

    async function lookupCpf() {
      const cpf = onlyDigits($cpf.value);
      if (cpf.length !== 11) return;
      try {
        const r = await fetch(`${routeLookup}?cpf=${cpf}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!r.ok) {
          const e = await r.json().catch(()=>({message:'CPF invalido ou nao encontrado.'}));
          if ($cpfHelp) { $cpfHelp.textContent = e.message || 'CPF invalido ou nao encontrado.'; $cpfHelp.style.color = '#dc2626'; }
          if ($nome) $nome.value = '';
          if ($email) $email.value = '';
          if ($cargo) $cargo.value = '';
          if ($funcao) $funcao.value = '';
          return;
        }
        const s = await r.json();
        if ($cpfHelp) { $cpfHelp.textContent = 'Dados carregados com sucesso.'; $cpfHelp.style.color = '#16a34a'; }
        if ($nome) $nome.value = s.nome || '';
        if ($email) $email.value = s.email || '';
        if ($cargo) $cargo.value = s.cargo || '';
        if ($funcao) $funcao.value = s.funcao || '';
      } catch {
        if ($cpfHelp) { $cpfHelp.textContent = 'Falha na consulta. Verifique sua conexao.'; $cpfHelp.style.color = '#dc2626'; }
      }
    }

    $cpf.addEventListener('blur', lookupCpf);
    if ($btnBuscar) $btnBuscar.addEventListener('click', lookupCpf);
  </script>
@endsection



