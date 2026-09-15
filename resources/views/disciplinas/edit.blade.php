@extends('layouts.app')
@section('title', 'Editar disciplina')
@section('content')
    <x-page-header eyebrow="Disciplinas / Editar" title="Editar disciplina" description="Atualize o código ou nome de {{ $disciplina->nome }}." />
    <div class="panel form-card"><div class="panel-body">@include('disciplinas._form')</div></div>
@endsection
