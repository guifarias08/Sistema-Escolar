@extends('layouts.app')

@section('title', 'Novo aluno')

@section('content')
    <x-page-header eyebrow="Alunos / Novo" title="Cadastrar aluno" description="Preencha os dados pessoais e acadêmicos do novo aluno." />
    <div class="panel form-card"><div class="panel-body">@include('alunos._form')</div></div>
@endsection
