@extends('layouts.app')
@section('title','Editar Servidor')

@section('content')
  @if (session('success'))
    <div class="help" style="color:#065f46; margin-bottom:8px">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('servidores.update',$servidor) }}" id="formPessoa">
    @csrf
    @method('PUT')

    {{-- ... seu formulário igual ao create, só usando old(..., $servidor->...) --}}
    <div class="actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
@endsection
