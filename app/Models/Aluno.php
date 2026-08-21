<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'data_nascimento',
        'foto',
        'turma_id'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class,'aluno_disciplina');
    }

    public function getDataNascimentoAttribute($value)
    {
        if (!$value) return null;
        try {
            return Carbon::parse($value)->format('d/m/Y');
        } catch (\Exception $e) {
            return $value;
        }
    }
}