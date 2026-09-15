@extends('layouts.app')
@section('title', 'Editar turma')
@section('content')
    <x-page-header eyebrow="Turmas / Editar" title="Editar turma" description="Atualize os dados de {{ $turma->nome }}." />
    <div class="panel form-card"><div class="panel-body">@include('turmas._form')</div></div>
@endsection
