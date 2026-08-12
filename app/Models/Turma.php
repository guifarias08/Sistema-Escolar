<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    // Autoriza o Laravel a salvar nome e turno no banco
    protected $fillable = ['nome', 'turno'];

    // Relacionamento com Alunos
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}