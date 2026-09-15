@php($editing = isset($aluno))

@if($errors->any())
    <div class="alert-errors" role="alert">
        <strong><i class="fa-solid fa-circle-exclamation"></i> Revise os campos abaixo</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ $editing ? route('alunos.update', $aluno) : route('alunos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($editing) @method('PUT') @endif

    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-regular fa-image"></i></span><h2>Foto de perfil</h2></div>
        <div class="image-upload">
            <div class="image-preview" id="studentImagePreview">
                @if($editing && $aluno->foto)
                    <img src="{{ asset('storage/' . $aluno->foto) }}" alt="Foto atual de {{ $aluno->nome }}">
                @else
                    {{ $editing ? mb_strtoupper(mb_substr($aluno->nome, 0, 1)) : 'A' }}
                @endif
            </div>
            <div style="flex:1">
                <label class="form-label" for="foto">{{ $editing ? 'Alterar foto' : 'Adicionar foto' }}</label>
                <input class="form-control @error('foto') is-invalid @enderror" type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg" data-image-input="#studentImagePreview">
                <small class="form-hint">JPG ou PNG de até 2 MB. Prefira uma foto quadrada.</small>
                @error('foto')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-regular fa-address-card"></i></span><h2>Dados pessoais</h2></div>
        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label" for="nome">Nome completo *</label>
                <input class="form-control @error('nome') is-invalid @enderror" type="text" id="nome" name="nome" value="{{ old('nome', $aluno->nome ?? '') }}" placeholder="Digite o nome completo" required autofocus>
                @error('nome')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">E-mail *</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email', $aluno->email ?? '') }}" placeholder="aluno@exemplo.com" required>
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="cpf">CPF *</label>
                <input class="form-control @error('cpf') is-invalid @enderror" type="text" id="cpf" name="cpf" value="{{ old('cpf', $aluno->cpf ?? '') }}" placeholder="000.000.000-00" inputmode="numeric" required>
                @error('cpf')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="data_nascimento">Data de nascimento *</label>
                <input class="form-control @error('data_nascimento') is-invalid @enderror" type="text" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $aluno->data_nascimento ?? '') }}" placeholder="dd/mm/aaaa" inputmode="numeric" required>
                @error('data_nascimento')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-solid fa-school"></i></span><h2>Dados acadêmicos</h2></div>
        <div class="form-group">
            <label class="form-label" for="turma_id">Turma</label>
            <select class="form-select @error('turma_id') is-invalid @enderror" id="turma_id" name="turma_id">
                <option value="">Selecione uma turma</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" @selected((string) old('turma_id', $aluno->turma_id ?? '') === (string) $turma->id)>{{ $turma->nome }} · {{ $turma->turno }}</option>
                @endforeach
            </select>
            @error('turma_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <label class="form-label">Disciplinas vinculadas</label>
        @if($disciplinas->isNotEmpty())
            <div class="checkbox-grid">
                @foreach($disciplinas as $disciplina)
                    @php($selected = in_array($disciplina->id, old('disciplinas', $editing ? $aluno->disciplinas->pluck('id')->all() : [])))
                    <label class="check-card" for="disciplina_{{ $disciplina->id }}">
                        <input type="checkbox" id="disciplina_{{ $disciplina->id }}" name="disciplinas[]" value="{{ $disciplina->id }}" @checked($selected)>
                        <span><strong>{{ $disciplina->nome }}</strong><small class="form-hint">{{ $disciplina->codigo }}</small></span>
                    </label>
                @endforeach
            </div>
        @else
            <div class="alert-errors" style="background:var(--warning-soft);border-color:#ecd49b;color:var(--warning)">Nenhuma disciplina cadastrada.</div>
        @endif
    </section>

    <div class="form-footer">
        <a href="{{ route('alunos.index') }}" class="btn btn-secondary">Cancelar</a>
        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i>{{ $editing ? 'Salvar alterações' : 'Cadastrar aluno' }}</button>
    </div>
</form>

@push('scripts')
<script src="https://unpkg.com/imask@7.6.1/dist/imask.js"></script>
<script>
    IMask(document.getElementById('cpf'), { mask: '000.000.000-00' });
    IMask(document.getElementById('data_nascimento'), { mask: '00/00/0000' });
</script>
@endpush
