<?php

namespace App\Repositories;

use App\Models\Board;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BoardMemberRepository implements BoardMemberRepositoryInterface
{
    public function get(Board $board): void
    {
        $board->members = new EloquentCollection([]);
    }

    public function search(array|null $userIds): array
    {
        if ($userIds === null) {
            return [];
        }

        $response = Http::timeout(10)
        ->post(
            'http://localhost:8000/api/v1/users/get-by-ids',
            [
                'ids' => $userIds
            ]
        );

        if (! $response->ok()) {
            throw new Exception('Failed to validate users from User service');
        }

        return $response->json('users');
    }

    public function store(Board $board, array $memberIds): void
    {
        // Insert members
        $data = [];

        foreach ($memberIds as $userId) {
            $data[] = [
                'board_id' => $board->primary_id,
                'user_id' => (int) $userId,
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ];
        }

        DB::table('board_user')->insert($data);
    }
}