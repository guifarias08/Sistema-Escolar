@php($editing = isset($turma))
@if($errors->any())
    <div class="alert-errors"><strong><i class="fa-solid fa-circle-exclamation"></i> Revise os campos abaixo</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $editing ? route('turmas.update', $turma) : route('turmas.store') }}" method="POST">
    @csrf @if($editing) @method('PUT') @endif
    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-solid fa-people-roof"></i></span><h2>Identificação da turma</h2></div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="nome">Nome da turma *</label>
                <input class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $turma->nome ?? '') }}" placeholder="Ex.: 2º Ano A" required autofocus>
                <small class="form-hint">Use um nome fácil de identificar em relatórios.</small>
                @error('nome')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="turno">Turno *</label>
                <select class="form-select @error('turno') is-invalid @enderror" id="turno" name="turno" required>
                    <option value="">Selecione o turno</option>
                    @foreach(['Manhã', 'Tarde', 'Noite', 'Integral'] as $opcao)<option value="{{ $opcao }}" @selected(old('turno', $turma->turno ?? '') === $opcao)>{{ $opcao }}</option>@endforeach
                </select>
                @error('turno')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </section>
    <div class="form-footer"><a href="{{ route('turmas.index') }}" class="btn btn-secondary">Cancelar</a><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i>{{ $editing ? 'Salvar alterações' : 'Cadastrar turma' }}</button></div>
</form>
