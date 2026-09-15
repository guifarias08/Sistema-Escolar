@extends('layouts.app')
@section('title', 'Nova turma')
@section('content')
    <x-page-header eyebrow="Turmas / Nova" title="Cadastrar turma" description="Crie uma turma e defina o período das aulas." />
    <div class="panel form-card"><div class="panel-body">@include('turmas._form')</div></div>
@endsection
