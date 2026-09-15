@extends('layouts.app')
@section('title', 'Editar lançamento')
@section('content')
    <x-page-header eyebrow="Notas / Editar" title="Editar lançamento" description="Atualize as notas e faltas deste registro acadêmico." />
    <div class="panel form-card"><div class="panel-body">@include('notas._form')</div></div>
@endsection
