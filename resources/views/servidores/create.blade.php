@extends('layouts.app')
@section('title','Cadastro')

@section('content')
  <form method="POST" action="{{ route('servidores.store') }}" id="formPessoa">
    @csrf
    @include('servidores._form') {{-- $servidor NÃO existe aqui, mas o parcial trata isso --}}
    <div class="actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
@endsection
