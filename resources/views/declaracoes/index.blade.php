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
      <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" required>
      <div class="help">Informe o CPF e saia do campo para buscar.</div>
    </div>

    <div class="form-group col-3"><!-- espaçador --></div>

    {{-- Linha 2 --}}
    <div class="form-group col-6">
      <label for="nome">Nome</label>
      <input type="text" id="nome" class="form-control" readonly>
    </div>

    <div class="form-group col-4">
      <label for="email">E-mail</label>
      <input type="text" id="email" class="form-control" readonly>
    </div>

    <div class="form-group col-2"><!-- espaçador --></div>

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
      <button type="submit" class="btn-primary">Gerar PDF</button>
    </div>
  </form>

  <script>
    const routeLookup = @json(route('declaracoes.lookup'));
    const $cpf = document.getElementById('cpf');
    function onlyDigits(v){ return (v||'').replace(/\D/g,''); }

    $cpf.addEventListener('blur', async function(){
      const cpf = onlyDigits(this.value);
      if (cpf.length !== 11) return;

      try {
        const r = await fetch(`${routeLookup}?cpf=${cpf}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!r.ok) {
          const e = await r.json().catch(()=>({message:'Erro ao buscar CPF.'}));
          alert(e.message || 'Erro ao buscar CPF.');
          return;
        }
        const s = await r.json();
        nome.value   = s.nome   || '';
        email.value  = s.email  || '';
        cargo.value  = s.cargo  || '';
        funcao.value = s.funcao || '';
      } catch {
        alert('Falha na consulta. Verifique sua conexão.');
      }
    });
  </script>
@endsection
