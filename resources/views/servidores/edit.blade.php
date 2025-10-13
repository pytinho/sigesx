@extends('layouts.app')
@section('title','Editar cadastro')

@section('content')
  <form method="POST"
        action="{{ route('servidores.update', $servidor) }}"
        id="formPessoa"
        class="needs-validation"
        data-watch-empty
        novalidate>
    @csrf
    @method('PUT')
    @include('servidores._form')

    <div class="actions mt-3">
      <button type="submit" class="btn btn-primary">Atualizar</button>
    </div>
  </form>
@endsection
