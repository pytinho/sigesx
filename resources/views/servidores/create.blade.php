@extends('layouts.app')
@section('title','Cadastro')

@section('content')
  <form method="POST"
        action="{{ route('servidores.store') }}"
        id="formPessoa"
        class="needs-validation"
        novalidate>
    @csrf
    @include('servidores._form')

    <div class="actions mt-3">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
@endsection
