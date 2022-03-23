<?php

namespace App\Http\Controllers;

use App\Interfaces\TodoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class TodoController  extends Controller 
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository) 
    {
        $this->todoRepository = $todoRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->todoRepository->getAllTodos()
        ]);
    }

    public function store(Request $request): JsonResponse 
    {
        $todoDetails = $request->only([
            'name',
            'description'
        ]);

        return response()->json(
            [
                'data' => $this->todoRepository->createTodo($todoDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse 
    {
        $todoId = $request->route('id');

        return response()->json([
            'data' => $this->todoRepository->getTodoById($TodoId)
        ]);
    }

    public function update(Request $request): JsonResponse 
    {
        $todoId = $request->route('id');
        $todoDetails = $request->only([
            'name',
            'description'
        ]);

        return response()->json([
            'data' => $this->todoRepository->updateTodo($todoId, $todoDetails)
        ]);
    }

    public function destroy(Request $request): JsonResponse 
    {
        $todoId = $request->route('id');
        $this->todoRepository->deleteTodo($todoId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}