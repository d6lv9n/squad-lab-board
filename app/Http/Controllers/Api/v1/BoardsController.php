<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Api\v1\CheckToken;
use App\Http\Requests\Api\v1\StoreBoardRequest;
use App\Http\Requests\Api\v1\UpdateBoardRequest;
use App\Models\Board;
use App\Repositories\BoardRepositoryInterface;
use App\Repositories\BoardMemberRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class BoardsController extends Controller implements HasMiddleware
{
    private $boardRepositoryInterface;
    private $boardMemberRepositoryInterface;

    public function __construct(
        BoardRepositoryInterface $boardRepositoryInterface,
        BoardMemberRepositoryInterface $boardMemberRepositoryInterface,
    ) {
        $this->boardRepositoryInterface = $boardRepositoryInterface;
        $this->boardMemberRepositoryInterface = $boardMemberRepositoryInterface;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(CheckToken::class, only: null, except: ['show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'user_id' => $request->user_id
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request): JsonResponse
    {
        $board = $this->boardRepositoryInterface->store($request);

        return response()->json([
            'board' => $board->except(['primary_id'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Board $board): JsonResponse
    {
        $tasks = [];

        $this->boardMemberRepositoryInterface->get($board);

        return response()->json([
            'item' => $board->except(['primary_id'])
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board): JsonResponse
    {
        return response()->json([
            'item' => $board->except(['primary_id'])
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Board $board): JsonResponse
    {
        return response()->json(null, 204);
    }
}
