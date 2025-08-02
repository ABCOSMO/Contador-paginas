<?php

namespace Correios\ContadorDePaginas\Cadastrar;

interface MatrizRepositoryInterface
{
    /**
     * Método para salvar uma matriz.
     *
     * @return bool Retorna true se a matriz foi salva com sucesso, false caso contrário.
     */
    public function salvar(): bool;

    public function alterar(): bool;
    
    public function excluir(): bool;

    public function buscarPorId(int $id): ?array;
}