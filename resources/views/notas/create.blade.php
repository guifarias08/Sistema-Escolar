@extends('layouts.app')
@section('title', 'Novo lançamento')
@section('content')
    <x-page-header eyebrow="Notas / Novo" title="Lançar notas e frequência" description="Registre o desempenho de um aluno em uma disciplina." />
    <div class="panel form-card"><div class="panel-body">@include('notas._form')</div></div>
@endsection
