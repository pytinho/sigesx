@extends('layouts.app')

@section('title','Cadastro')

@section('content')
  <h1 class="form-title"></h1>

  @if (session('success'))
    <div class="help" style="color:#065f46; margin-bottom:8px;">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('servidores.store') }}" id="formPessoa">
    @csrf

    <div class="form-grid">
      {{-- Linha 1 (12 col) --}}
      <div class="form-group col-6">
        <label for="nome">Nome</label>
        <input class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" id="nome"
               placeholder="ex: João Alves Costa da Silva" value="{{ old('nome') }}" required>
        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-3">
        <label for="cpf">CPF</label>
        <input class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" id="cpf"
               placeholder="000.000.000-00" value="{{ old('cpf') }}" required>
        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-3">
        <label for="dt_nascimento">Dt Nascimento</label>
        <input class="form-control @error('dt_nascimento') is-invalid @enderror" type="text" name="dt_nascimento" id="dt_nascimento"
               placeholder="dd/mm/aaaa" value="{{ old('dt_nascimento') }}">
        @error('dt_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 2 (12 col) --}}
      <div class="form-group col-2">
        <label for="uf">UF</label>
        <select class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" data-old-uf="{{ old('uf') }}">
          <option value="">Selecione</option>
        </select>
        @error('uf') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-4">
        <label for="cidade">Cidade</label>
        <select class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade"
                data-old-cidade="{{ old('cidade') }}" disabled>
          <option value="">Selecione a UF primeiro</option>
        </select>
        @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-3">
        <label for="email">E-mail</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email"
               placeholder="exemplo@gmail.com" value="{{ old('email') }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-3">
          <label for="contato">Contato</label>
          <input
            class="form-control @error('contato') is-invalid @enderror"
            type="text"
            name="contato"
            id="contato"
            placeholder="(__) _____-____"
            inputmode="tel"
            value="{{ old('contato') }}"
            required
          >
          @error('contato')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

      {{-- Linha 3 (12 col) — CEP, Endereço, Lote --}}
      <div class="form-group col-3">
        <label for="cep">CEP</label>
        <input class="form-control @error('cep') is-invalid @enderror" type="text" name="cep" id="cep"
               placeholder="00000-000" value="{{ old('cep') }}">
        <small class="help" id="cepHelp"></small>
        @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-6">
        <label for="endereco">Endereço</label>
        <input class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" id="endereco"
               placeholder="Rua Sol Nascente" value="{{ old('endereco') }}">
        @error('endereco') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="form-group col-3">
        <label for="lote">Lote</label>
        <input class="form-control @error('lote') is-invalid @enderror" type="text" name="lote" id="lote"
               placeholder="00" value="{{ old('lote') }}">
        @error('lote') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 4 (12 col) --}}
      <div class="form-group col-3">
        <label for="funcao_id">Função</label>
        <select name="funcao_id" id="funcao_id" class="form-control @error('funcao_id') is-invalid @enderror">
          <option value="">Selecione</option>
          @foreach($funcoes as $f)
            <option value="{{ $f->id }}" @selected(old('funcao_id')==$f->id)>{{ $f->nome }}</option>
          @endforeach
        </select>
        @error('funcao_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="cargo">Cargo</label>
        <input class="form-control @error('cargo') is-invalid @enderror" type="text" name="cargo" id="cargo"
               placeholder="ex: Agente Adm Educacional" value="{{ old('cargo') }}">
        @error('cargo') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="vinculo">Vínculo</label>
        <select class="form-control @error('vinculo') is-invalid @enderror" name="vinculo" id="vinculo">
          <option value="">Selecione</option>
          <option value="Efetivo"      {{ old('vinculo')=='Efetivo' ? 'selected' : '' }}>Efetivo</option>
          <option value="Temporário"   {{ old('vinculo')=='Temporário' ? 'selected' : '' }}>Contrato Temporário</option>
          <option value="Comissionado" {{ old('vinculo')=='Comissionado' ? 'selected' : '' }}>Cargo Comissionado</option>
          <option value="Estagiário"   {{ old('vinculo')=='Estagiário' ? 'selected' : '' }}>Estagiário</option>
          <option value="Voluntário"   {{ old('vinculo')=='Voluntário' ? 'selected' : '' }}>Voluntário</option>
          <option value="Requisitado"  {{ old('vinculo')=='Requisitado' ? 'selected' : '' }}>Servidor Requisitado</option>
          <option value="Cedido"       {{ old('vinculo')=='Cedido' ? 'selected' : '' }}>Servidor Cedido</option>
          <option value="Designado"    {{ old('vinculo')=='Designado' ? 'selected' : '' }}>Designado</option>
          <option value="Substituto"   {{ old('vinculo')=='Substituto' ? 'selected' : '' }}>Professor(a) Substituto(a)</option>
          <option value="Readaptado"   {{ old('vinculo')=='Readaptado' ? 'selected' : '' }}>Readaptado</option>
        </select>
        @error('vinculo') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="dt_entrada">Data de entrada</label>
        <input class="form-control @error('dt_entrada') is-invalid @enderror" type="text" name="dt_entrada" id="dt_entrada"
               placeholder="dd/mm/aaaa" value="{{ old('dt_entrada') }}">
        @error('dt_entrada') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Linha 5 --}}
      <div class="form-group col-6">
        <label for="unidade_escolar">Unidade Escolar</label>
        <input class="form-control @error('unidade_escolar') is-invalid @enderror" type="text" name="unidade_escolar" id="unidade_escolar"
               placeholder="Escola Municipal de Tempo Integral Luiz Gonzaga" value="{{ old('unidade_escolar') }}">
        @error('unidade_escolar') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="form-group col-3">
        <label for="codigo_ue">Código da UE</label>
        <input class="form-control @error('codigo_ue') is-invalid @enderror" type="text" name="codigo_ue" id="codigo_ue"
               placeholder="514.3.28" value="{{ old('codigo_ue') }}">
        @error('codigo_ue') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
@endsection
