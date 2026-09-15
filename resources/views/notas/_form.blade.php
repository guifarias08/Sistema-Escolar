@php($editing = isset($nota))
@if($errors->any())
    <div class="alert-errors"><strong><i class="fa-solid fa-circle-exclamation"></i> Revise os campos abaixo</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $editing ? route('notas.update', $nota) : route('notas.store') }}" method="POST">
    @csrf @if($editing) @method('PUT') @endif
    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-solid fa-user-graduate"></i></span><h2>Aluno e disciplina</h2></div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="aluno_id">Aluno *</label>
                <select class="form-select @error('aluno_id') is-invalid @enderror" name="aluno_id" id="aluno_id" required autofocus>
                    <option value="">Selecione o aluno</option>
                    @foreach($alunos as $aluno)<option value="{{ $aluno->id }}" @selected((string) old('aluno_id', $nota->aluno_id ?? '') === (string) $aluno->id)>{{ $aluno->nome }}</option>@endforeach
                </select>
                @error('aluno_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="disciplina_id">Disciplina *</label>
                <select class="form-select @error('disciplina_id') is-invalid @enderror" name="disciplina_id" id="disciplina_id" required>
                    <option value="">Selecione a disciplina</option>
                    @foreach($disciplinas as $disciplina)<option value="{{ $disciplina->id }}" @selected((string) old('disciplina_id', $nota->disciplina_id ?? '') === (string) $disciplina->id)>{{ $disciplina->codigo }} · {{ $disciplina->nome }}</option>@endforeach
                </select>
                @error('disciplina_id')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </section>
    <section class="form-section">
        <div class="form-section-title"><span><i class="fa-solid fa-chart-simple"></i></span><h2>Avaliação e frequência</h2></div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="nota_1">1ª nota</label>
                <input class="form-control @error('nota_1') is-invalid @enderror" type="number" step="0.1" min="0" max="10" name="nota_1" id="nota_1" value="{{ old('nota_1', $nota->nota_1 ?? '') }}" placeholder="0,0 a 10,0" data-grade>
                @error('nota_1')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="nota_2">2ª nota</label>
                <input class="form-control @error('nota_2') is-invalid @enderror" type="number" step="0.1" min="0" max="10" name="nota_2" id="nota_2" value="{{ old('nota_2', $nota->nota_2 ?? '') }}" placeholder="0,0 a 10,0" data-grade>
                @error('nota_2')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="faltas">Total de faltas *</label>
                <input class="form-control @error('faltas') is-invalid @enderror" type="number" min="0" name="faltas" id="faltas" value="{{ old('faltas', $nota->faltas ?? 0) }}" required data-absences>
                <small class="form-hint">Acima de 15 faltas, o aluno será sinalizado.</small>
                @error('faltas')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Prévia do resultado</label>
                <div class="form-control" style="display:flex;align-items:center;gap:10px;background:var(--surface-alt)">
                    <strong data-average>—</strong><span class="badge badge-neutral" data-situation>Preencha as duas notas</span>
                </div>
            </div>
        </div>
    </section>
    <div class="form-footer"><a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i>{{ $editing ? 'Salvar alterações' : 'Salvar lançamento' }}</button></div>
</form>
@push('scripts')
<script>
    const grades = [...document.querySelectorAll('[data-grade]')];
    const absences = document.querySelector('[data-absences]');
    const average = document.querySelector('[data-average]');
    const situation = document.querySelector('[data-situation]');
    const calculatePreview = () => {
        const values = grades.map(input => input.value === '' ? null : Number(input.value));
        if (values.includes(null)) {
            average.textContent = '—';
            situation.textContent = 'Preencha as duas notas';
            situation.className = 'badge badge-neutral';
            return;
        }
        const result = (values[0] + values[1]) / 2;
        const manyAbsences = Number(absences.value) > 15;
        average.textContent = result.toLocaleString('pt-BR', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
        const failed = result < 7 || manyAbsences;
        situation.textContent = failed ? (manyAbsences ? 'Atenção às faltas' : 'Abaixo da média') : 'Aprovado';
        situation.className = 'badge ' + (failed ? 'badge-danger' : 'badge-success');
    };
    [...grades, absences].forEach(input => input.addEventListener('input', calculatePreview));
    calculatePreview();
</script>
@endpush
