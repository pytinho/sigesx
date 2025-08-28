@extends('layouts.app')
@section('title','Editar Servidor')

@section('content')
  <form method="POST" action="{{ route('servidores.update', $servidor) }}" id="formPessoa">
    @csrf
    @method('PUT')
    @include('servidores._form') {{-- Aqui $servidor EXISTE e pré-preenche tudo --}}
    <div class="actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
@endsection
