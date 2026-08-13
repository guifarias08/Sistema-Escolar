<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'cpf', 'data_nascimento', 'turma_id'];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class);
    }
}