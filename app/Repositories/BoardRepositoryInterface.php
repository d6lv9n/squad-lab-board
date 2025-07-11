<?php

namespace App\Repositories;

use App\Models\Board;
use Illuminate\Http\Request;

interface BoardRepositoryInterface
{
    public function destroy(Board $board);
    
    public function store(Request $request): Board;

    public function show(Board $board);
}
