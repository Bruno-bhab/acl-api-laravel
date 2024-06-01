<?php

namespace App\Http\Controllers\Api;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\EditUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function index(Request $request): JsonResource
    {
        $users = $this->userRepository->getPaginate(
            totalPerPage: $request->total_per_page ?? 15,
            page: $request->page ?? 1,
            filter: $request->filter ?? '',
        );
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request): JsonResource
    {
        $user = $this->userRepository->createNew(new CreateUserDTO(... $request->validated()));
        return new UserResource($user);
    }

    public function show(string $id): JsonResource|ResponseHttp
    {
        if(!$user = $this->userRepository->findById($id)){
            return response()->json(['message' => 'user not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, string $id): ResponseHttp
    {
        $response = $this->userRepository->update(new EditUserDTO(... [$id, ...$request->validated()]));
        if(!$response){
            return response()->json(['message' => 'user not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'user updated with success'], ResponseHttp::HTTP_OK);
    }

    public function destroy(string $id): ResponseHttp
    {
        if(!$this->userRepository->delete($id)){
            return response()->json(['message' => 'user not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return response()->json([], ResponseHttp::HTTP_NO_CONTENT);
    }
}
