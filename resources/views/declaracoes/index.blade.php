@extends('layouts.app')
@section('title','Declarações')

@section('content')
<div class="card">
  <h1 class="header">Declarações</h1>

  {{-- mensagens de feedback --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-error">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form id="formDeclaracao" method="POST" action="{{ route('declaracoes.gerar') }}" class="grid">
    @csrf

    {{-- selecionar tipo --}}
    <div>
      <label for="tipo">Tipo de Declaração</label>
      <select name="tipo" id="tipo" required>
        <option value="">Selecione...</option>
        @foreach($tipos as $val => $label)
          <option value="{{ $val }}">{{ $label }}</option>
        @endforeach
      </select>
    </div>

    {{-- campo CPF --}}
    <div>
      <label for="cpf">CPF</label>
      <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" required>
    </div>

    {{-- auto-preenchidos --}}
    <div>
      <label for="nome">Nome</label>
      <input type="text" id="nome" readonly>
    </div>
    <div>
      <label for="email">E-mail</label>
      <input type="text" id="email" readonly>
    </div>
    <div>
      <label for="contato">Contato</label>
      <input type="text" id="contato" readonly>
    </div>
    <div>
      <label for="cargo">Cargo</label>
      <input type="text" id="cargo" readonly>
    </div>
    <div>
      <label for="funcao">Função</label>
      <input type="text" id="funcao" readonly>
    </div>

    <div style="margin-top:16px">
      <button type="submit" class="btn btn-primary">Gerar PDF</button>
    </div>
  </form>
</div>

<script>
  const routeLookup = @json(route('declaracoes.lookup'));
  const $cpf = document.getElementById('cpf');

  function onlyDigits(v){ return (v||'').replace(/\D/g,''); }

  $cpf.addEventListener('blur', async function(){
    const cpf = onlyDigits(this.value);
    if (cpf.length !== 11) return;

    try {
      const r = await fetch(`${routeLookup}?cpf=${cpf}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      if (!r.ok) {
        const e = await r.json().catch(()=>({message:'Erro ao buscar CPF.'}));
        alert(e.message || 'Erro ao buscar CPF.');
        return;
      }

      const s = await r.json();
      document.getElementById('nome').value    = s.nome    || '';
      document.getElementById('email').value   = s.email   || '';
      document.getElementById('contato').value = s.contato || '';
      document.getElementById('cargo').value   = s.cargo   || '';
      document.getElementById('funcao').value  = s.funcao  || '';
    } catch (err) {
      alert('Falha na consulta. Verifique sua conexão.');
    }
  });
</script>
@endsection
