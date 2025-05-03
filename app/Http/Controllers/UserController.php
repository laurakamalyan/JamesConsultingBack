<?php

namespace App\Http\Controllers;

use App\Http\Contracts\UserRepositoryInterface;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(protected UserRepositoryInterface $userRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $user = $this->userRepository->all();
        return response()->json($user);
    }

    /**
     * @param UserUpdateRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request) : JsonResponse {
        $request->validated();

        $this->userRepository->update([
                'name' => $request->input('name') ?? Auth::user()->name,
                'email' => $request->input('email') ?? Auth::user()->email,
                'password' => Hash::make($request->input('password')) ?? Auth::user()->password,
        ], Auth::user()->id);

        return response()->json(['message' => 'User updated successfully.']);
    }

    /**
     * @return JsonResponse
     */
    public function delete() : JsonResponse {
        $this->userRepository->delete(Auth::user()->id);
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
