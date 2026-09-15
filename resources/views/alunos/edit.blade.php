@extends('layouts.app')

@section('title', 'Editar aluno')

@section('content')
    <x-page-header eyebrow="Alunos / Editar" title="Editar aluno" description="Atualize os dados cadastrais e os vínculos acadêmicos de {{ $aluno->nome }}." />
    <div class="panel form-card"><div class="panel-body">@include('alunos._form')</div></div>
@endsection
