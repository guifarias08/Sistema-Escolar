@extends('layouts.app')
@section('title', 'Nova disciplina')
@section('content')
    <x-page-header eyebrow="Disciplinas / Nova" title="Cadastrar disciplina" description="Adicione um novo componente à grade curricular." />
    <div class="panel form-card"><div class="panel-body">@include('disciplinas._form')</div></div>
@endsection
