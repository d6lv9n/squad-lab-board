<?php

namespace App\Repositories;

use App\Models\Board;
use App\Repositories\BoardMemberRepositoryInterface;
use App\Repositories\BoardTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardRepository implements BoardRepositoryInterface
{
    private $boardMemberRepositoryInterface;
    private $boardTaskRepositoryInterface;

    public function __construct(
        BoardMemberRepositoryInterface $boardMemberRepositoryInterface,
        BoardTaskRepositoryInterface $boardTaskRepositoryInterface,
    ) {
        $this->boardMemberRepositoryInterface = $boardMemberRepositoryInterface;
        $this->boardTaskRepositoryInterface = $boardTaskRepositoryInterface;
    }

    public function store(Request $request): Board
    {
        return DB::transaction(function () use ($request) {
            $board = Board::create($request->only(['title', 'description', 'user_id']));

            // Tasks
            // if ($request->has('tasks')) {

            // }

            $board->tasks = new EloquentCollection([]);

            $members = $this->boardMemberRepositoryInterface->get($request->members ?? null);

            if (! empty($members)) {
                $memberIds = collect($members)->pluck('id')->toArray();

                $this->boardMemberRepositoryInterface->store($board, $memberIds);
            }

            $board->members = new EloquentCollection($members);

            return $board;
        }, 3);
    }

    public function show(Board $board)
    {

    }

    public function destroy(Board $board)
    {

    }

    public function update()
    {
        
    }
}
