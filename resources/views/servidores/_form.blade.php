@php

  $servidor = $servidor ?? null;
  $v = function ($name, $default = '') use ($servidor) {
      return old($name, $servidor?->$name ?? $default);
  };
@endphp

@if ($errors->any())
  <div class="alert alert-danger">
    <strong>Ops!</strong> Corrija os campos destacados e tente novamente.
  </div>
@endif

<div class="form-grid">
  <div class="form-group col-6">
    <label for="nome">Nome *</label>
    <input type="text" id="nome" name="nome"
           class="form-control @error('nome') is-invalid @enderror"
           placeholder="ex: João Alves Costa da Silva"
           value="{{ $v('nome') }}" required>
    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="cpf">CPF *</label>
    <input type="text" id="cpf" name="cpf"
           class="form-control @error('cpf') is-invalid @enderror"
           placeholder="000.000.000-00"
           value="{{ $v('cpf') }}" required>
    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="dt_nascimento">Dt Nascimento *</label>
    <input type="text" id="dt_nascimento" name="dt_nascimento"
           class="form-control @error('dt_nascimento') is-invalid @enderror"
           placeholder="dd/mm/aaaa"
           value="{{ $v('dt_nascimento') }}" required>
    @error('dt_nascimento')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-2">
    <label for="uf">UF</label>
    <select id="uf" name="uf"
            class="form-control @error('uf') is-invalid @enderror"
            data-old-uf="{{ $v('uf') }}" required>
      <option value="">Selecione *</option>
      @foreach (['AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO'] as $uf)
        <option value="{{ $uf }}" @selected($v('uf') == $uf)>{{ $uf }}</option>
      @endforeach
    </select>
    @error('uf')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-4">
    <label for="cidade">Cidade *</label>
    <select id="cidade" name="cidade"
            class="form-control @error('cidade') is-invalid @enderror"
            data-old-cidade="{{ $v('cidade') }}" {{ $v('uf') ? '' : 'disabled' }} required>
      <option value="">{{ $v('uf') ? 'Selecione a cidade' : 'Selecione a UF primeiro' }}</option>
    </select>
    @error('cidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="email">E-mail *</label>
    <input type="email" id="email" name="email"
           class="form-control @error('email') is-invalid @enderror"
           placeholder="exemplo@gmail.com"
           value="{{ $v('email') }}" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="contato">Contato *</label>
    <input type="text" id="contato" name="contato"
           class="form-control @error('contato') is-invalid @enderror"
           placeholder="(__) _____-____"
           inputmode="tel"
           value="{{ $v('contato') }}" required>
    @error('contato')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="cep">CEP *</label>
    <input type="text" id="cep" name="cep"
           class="form-control @error('cep') is-invalid @enderror"
           placeholder="00000-000"
           value="{{ $v('cep') }}" required>
    <small class="help" id="cepHelp"></small>
    @error('cep')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-6">
    <label for="endereco">Endereço *</label>
    <input type="text" id="endereco" name="endereco"
           class="form-control @error('endereco') is-invalid @enderror"
           placeholder="Rua Sol Nascente"
           value="{{ $v('endereco') }}" required>
    @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="lote">Lote *</label>
    <input type="text" id="lote" name="lote"
           class="form-control @error('lote') is-invalid @enderror"
           placeholder="00"
           value="{{ $v('lote') }}" required>
    @error('lote')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="funcao_id">Função *</label>
    <select id="funcao_id" name="funcao_id"
            class="form-control @error('funcao_id') is-invalid @enderror" required>
      <option value="">Selecione</option>
      @foreach($funcoes as $f)
        <option value="{{ $f->id }}" @selected($v('funcao_id') == $f->id)>{{ $f->nome }}</option>
      @endforeach
    </select>
    @error('funcao_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="cargo">Cargo *</label>
    <input type="text" id="cargo" name="cargo"
           class="form-control @error('cargo') is-invalid @enderror"
           placeholder="ex: Agente Adm Educacional"
           value="{{ $v('cargo') }}" required>
    @error('cargo')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="vinculo">Vínculo *</label>
    <select id="vinculo" name="vinculo"
            class="form-control @error('vinculo') is-invalid @enderror" required>
      <option value="">Selecione</option>
      @foreach (['Efetivo','Temporário','Comissionado','Estagiário','Voluntário','Requisitado','Cedido','Designado','Substituto','Readaptado'] as $vinc)
        <option value="{{ $vinc }}" @selected($v('vinculo') == $vinc)>{{ $vinc }}</option>
      @endforeach
    </select>
    @error('vinculo')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="dt_entrada">Data de entrada *</label>
    <input type="text" id="dt_entrada" name="dt_entrada"
           class="form-control @error('dt_entrada') is-invalid @enderror"
           placeholder="dd/mm/aaaa"
           value="{{ $v('dt_entrada') }}" required>
    @error('dt_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  
  <div class="form-group col-3">
      <label for="carga_horaria">Carga horária * (h/semana)</label>
      <input
        type="number"
        id="carga_horaria"
        name="carga_horaria"
        class="form-control @error('carga_horaria') is-invalid @enderror"
        placeholder="40"
        min="1"
        max="60"
        step="1"
        inputmode="numeric"
        value="{{ $v('carga_horaria') }}"
        required
      >
      <small class="help">Informe em horas semanais (ex.: 20, 30, 40).</small>
      @error('carga_horaria')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
  <div class="form-group col-6">
    <label for="unidade_escolar">Unidade Escolar</label>
    <input type="text" id="unidade_escolar" name="unidade_escolar"
           class="form-control @error('unidade_escolar') is-invalid @enderror"
           placeholder="Escola Municipal Luiz Gonzaga"
           value="{{ $v('unidade_escolar') }}"readonly>
    @error('unidade_escolar')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="form-group col-3">
    <label for="codigo_ue">Código da UE</label>
    <input type="text" id="codigo_ue" name="codigo_ue"
           class="form-control @error('codigo_ue') is-invalid @enderror"
           placeholder="514.3.28"
           value="{{ $v('codigo_ue') }}" readonly>
    @error('codigo_ue')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
