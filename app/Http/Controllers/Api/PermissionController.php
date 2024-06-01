<?php

namespace App\Http\Controllers\Api;

use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\EditPermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePermissionRequest;
use App\Http\Requests\Api\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionRepository $permissionRepository)
    {
    }

    public function index(Request $request): JsonResource
    {
        $permissions = $this->permissionRepository->getPaginate(
            totalPerPage: $request->total_per_page ?? 15,
            page: $request->page ?? 1,
            filter: $request->filter ?? '',
        );
        return PermissionResource::collection($permissions);
    }

    public function store(StorePermissionRequest $request): JsonResource
    {
        $permission = $this->permissionRepository->createNew(new CreatePermissionDTO(... $request->validated()));
        return new PermissionResource($permission);
    }

    public function show(string $id): JsonResource|ResponseHttp
    {
        if(!$permission = $this->permissionRepository->findById($id)){
            return response()->json(['message' => 'permission not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, string $id): ResponseHttp
    {
        $response = $this->permissionRepository->update(new EditPermissionDTO(... [$id, ...$request->validated()]));
        if(!$response){
            return response()->json(['message' => 'permission not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'permission updated with success'], ResponseHttp::HTTP_OK);
    }

    public function destroy(string $id): ResponseHttp
    {
        if(!$this->permissionRepository->delete($id)){
            return response()->json(['message' => 'permission not found'], ResponseHttp::HTTP_NOT_FOUND);
        }

        return response()->json([], ResponseHttp::HTTP_NO_CONTENT);
    }
}
