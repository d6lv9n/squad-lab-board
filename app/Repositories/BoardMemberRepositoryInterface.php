<?php

namespace App\Repositories;

use App\Models\Board;

interface BoardMemberRepositoryInterface
{
    public function get(Board $board): void;

    public function search(array|null $userIds): array;

    public function store(Board $board, array $memberIds): void;
}