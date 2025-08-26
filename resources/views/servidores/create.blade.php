@extends('layouts.app')

@section('title','Cadastro')

@section('content')
  <h1 class="form-title"></h1>

  @if (session('success'))
    <div class="help" style="color:#065f46; margin-bottom:8px;">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('servidores.store') }}" id="formPessoa" novalidate>
    @csrf

    <div class="form-grid">
      {{-- Linha 1 --}}
      <div class="form-group col-6">
        <label for="nome">Nome*</label>
        <input class="form-control @error('nome') is-invalid @enderror"
               type="text" name="nome" id="nome"
               placeholder="ex: João Alves Costa da Silva"
               value="{{ old('nome') }}" required>
        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="cpf">CPF*</label>
        <input class="form-control @error('cpf') is-invalid @enderror"
               type="text" name="cpf" id="cpf"
               placeholder="000.000.000-00"
               value="{{ old('cpf') }}" required>
        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="dt_nascimento">Dt Nascimento*</label>
        <input class="form-control @error('dt_nascimento') is-invalid @enderror"
               type="text" name="dt_nascimento" id="dt_nascimento"
               placeholder="dd/mm/aaaa"
               value="{{ old('dt_nascimento') }}" required>
        @error('dt_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 2 --}}
      <div class="form-group col-2">
        <label for="uf">UF*</label>
        <select class="form-control @error('uf') is-invalid @enderror"
                name="uf" id="uf"
                data-old-uf="{{ old('uf') }}" required>
          <option value="">Selecione</option>
        </select>
        @error('uf') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-4">
        <label for="cidade">Cidade*</label>
        <select class="form-control @error('cidade') is-invalid @enderror"
                name="cidade" id="cidade"
                data-old-cidade="{{ old('cidade') }}"
                disabled required>
          <option value="">Selecione a UF primeiro</option>
        </select>
        @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="email">E-mail*</label>
        <input class="form-control @error('email') is-invalid @enderror"
               type="email" name="email" id="email"
               placeholder="exemplo@gmail.com"
               value="{{ old('email') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="contato">Contato*</label>
        <input class="form-control @error('contato') is-invalid @enderror"
               type="text" name="contato" id="contato"
               placeholder="(__) _____-____"
               inputmode="tel"
               value="{{ old('contato') }}" required>
        @error('contato') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 3 --}}
      <div class="form-group col-3">
        <label for="cep">CEP*</label>
        <input class="form-control @error('cep') is-invalid @enderror"
               type="text" name="cep" id="cep"
               placeholder="00000-000"
               value="{{ old('cep') }}" required>
        <small class="help" id="cepHelp"></small>
        @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-6">
        <label for="endereco">Endereço*</label>
        <input class="form-control @error('endereco') is-invalid @enderror"
               type="text" name="endereco" id="endereco"
               placeholder="Rua Sol Nascente"
               value="{{ old('endereco') }}" required>
        @error('endereco') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="lote">Lote*</label>
        <input class="form-control @error('lote') is-invalid @enderror"
               type="text" name="lote" id="lote"
               placeholder="00"
               value="{{ old('lote') }}" required>
        @error('lote') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 4 --}}
      <div class="form-group col-3">
        <label for="funcao_id">Função*</label>
        <select name="funcao_id" id="funcao_id"
                class="form-control @error('funcao_id') is-invalid @enderror" required>
          <option value="">Selecione</option>
          @foreach($funcoes as $f)
            <option value="{{ $f->id }}" @selected(old('funcao_id')==$f->id)>
              {{ $f->nome }}
            </option>
          @endforeach
        </select>
        @error('funcao_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="cargo">Cargo*</label>
        <input class="form-control @error('cargo') is-invalid @enderror"
               type="text" name="cargo" id="cargo"
               placeholder="ex: Agente Adm Educacional"
               value="{{ old('cargo') }}" required>
        @error('cargo') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="vinculo">Vínculo</label>
        <select class="form-control @error('vinculo') is-invalid @enderror"
                name="vinculo" id="vinculo" required>
          <option value="">Selecione</option>
          <option value="Efetivo"      @selected(old('vinculo')=='Efetivo')>Efetivo</option>
          <option value="Temporário"   @selected(old('vinculo')=='Temporário')>Contrato Temporário</option>
          <option value="Comissionado" @selected(old('vinculo')=='Comissionado')>Cargo Comissionado</option>
          <option value="Estagiário"   @selected(old('vinculo')=='Estagiário')>Estagiário</option>
          <option value="Voluntário"   @selected(old('vinculo')=='Voluntário')>Voluntário</option>
          <option value="Requisitado"  @selected(old('vinculo')=='Requisitado')>Servidor Requisitado</option>
          <option value="Cedido"       @selected(old('vinculo')=='Cedido')>Servidor Cedido</option>
          <option value="Designado"    @selected(old('vinculo')=='Designado')>Designado</option>
          <option value="Substituto"   @selected(old('vinculo')=='Substituto')>Professor(a) Substituto(a)</option>
          <option value="Readaptado"   @selected(old('vinculo')=='Readaptado')>Readaptado</option>
        </select>
        @error('vinculo') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="dt_entrada">Data de entrada</label>
        <input class="form-control @error('dt_entrada') is-invalid @enderror"
               type="text" name="dt_entrada" id="dt_entrada"
               placeholder="dd/mm/aaaa"
               value="{{ old('dt_entrada') }}" required>
        @error('dt_entrada') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 5 (não obrigatórios) --}}
      <div class="form-group col-6">
        <label for="unidade_escolar">Unidade Escolar</label>
        <input class="form-control @error('unidade_escolar') is-invalid @enderror"
               type="text" name="unidade_escolar" id="unidade_escolar"
               placeholder="Escola Municipal de Tempo Integral Luiz Gonzaga"
               value="{{ old('unidade_escolar') }}">
        @error('unidade_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="codigo_ue">Código da UE</label>
        <input class="form-control @error('codigo_ue') is-invalid @enderror"
               type="text" name="codigo_ue" id="codigo_ue"
               placeholder="514.3.28"
               value="{{ old('codigo_ue') }}">
        @error('codigo_ue') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
  <script>
(function () {
  const form = document.getElementById('formPessoa');
  if (!form) return;

  // Evita os popups nativos e deixamos tudo por conta do nosso JS
  form.setAttribute('novalidate','');

  // Campos obrigatórios segundo o Controller
  const obrigatorios = [
    'nome','cpf','email','dt_nascimento','cep','endereco','lote',
    'cidade','uf','cargo','funcao_id','vinculo','dt_entrada','contato'
  ];

  // Garante required no DOM (caso tenha faltado em algum)
  obrigatorios.forEach(name => {
    const el = form.querySelector(`[name="${name}"]`);
    if (el) el.required = true;
  });

  // Helper: mensagem amigável
  function mensagem(el){
    if (el.validity.valueMissing) return 'Este campo é obrigatório.';
    if (el.type === 'email' && el.validity.typeMismatch) return 'Informe um e-mail válido.';
    if (el.validity.patternMismatch) return 'Formato inválido.';
    if (el.validity.tooShort) return `Mínimo de ${el.minLength} caracteres.`;
    if (el.validity.tooLong) return `Máximo de ${el.maxLength} caracteres.`;
    return el.validationMessage || 'Valor inválido.';
  }

  // Mostra/limpa erro
  function showError(el){
    el.classList.add('is-invalid');
    let fb = el.nextElementSibling;
    if (!fb || !fb.classList.contains('invalid-feedback')) {
      fb = document.createElement('div');
      fb.className = 'invalid-feedback';
      el.after(fb);
    }
    fb.textContent = mensagem(el);
  }
  function clearError(el){
    el.classList.remove('is-invalid');
    const fb = el.nextElementSibling;
    if (fb && fb.classList.contains('invalid-feedback')) fb.textContent = '';
  }

  // Regras de validação por elemento
  function validar(el){
    // Não valida selects desabilitados (ex.: CIDADE antes da UF)
    if (el.disabled) { clearError(el); return true; }

    // Trim para campos de texto
    if (el.matches('input[type="text"], input[type="tel"], input[type="email"]')) {
      el.value = el.value.trim();
    }

    if (!el.checkValidity()) { showError(el); return false; }
    clearError(el); return true;
  }

  // Validação ao sair do campo (BLUR) e enquanto digita/seleciona
  form.querySelectorAll('input, select, textarea').forEach(el => {
    el.addEventListener('blur', () => validar(el));
    el.addEventListener('input', () => {
      // Se ficar válido após digitar, limpa o erro
      if (el.checkValidity()) clearError(el);
    });
    el.addEventListener('change', () => validar(el));
  });

  // Submit: impede envio e foca no primeiro inválido
  form.addEventListener('submit', (e) => {
    let firstInvalid = null;
    form.querySelectorAll('input, select, textarea').forEach(el => {
      const ok = validar(el);
      if (!ok && !firstInvalid) firstInvalid = el;
    });
    if (!form.checkValidity()) {
      e.preventDefault();
      firstInvalid?.focus();
    }
  });

  // Bônus: quando escolher UF, habilita Cidade (mantendo required)
  const uf = form.querySelector('#uf');
  const cidade = form.querySelector('#cidade');
  if (uf && cidade) {
    uf.addEventListener('change', () => {
      const temUF = !!uf.value;
      cidade.disabled = !temUF;
      if (!temUF) { cidade.value = ''; clearError(cidade); }
    });
  }
})();
</script>

@endsection
