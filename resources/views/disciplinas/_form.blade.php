@php($editing = isset($disciplina))
@if($errors->any())
    <div class="alert-errors"><strong><i class="fa-solid fa-circle-exclamation"></i> Revise os campos abaixo</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $editing ? route('disciplinas.update', $disciplina) : route('disciplinas.store') }}" method="POST">
    @csrf @if($editing) @method('PUT') @endif
    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-solid fa-book-open"></i></span><h2>Identificação da disciplina</h2></div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="codigo">Código *</label>
                <input class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo', $disciplina->codigo ?? '') }}" placeholder="Ex.: MAT-101" maxlength="20" required autofocus>
                <small class="form-hint">O código deve ser único.</small>
                @error('codigo')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="nome">Nome da disciplina *</label>
                <input class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $disciplina->nome ?? '') }}" placeholder="Ex.: Matemática" required>
                @error('nome')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </section>
    <div class="form-footer"><a href="{{ route('disciplinas.index') }}" class="btn btn-secondary">Cancelar</a><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i>{{ $editing ? 'Salvar alterações' : 'Cadastrar disciplina' }}</button></div>
</form>
