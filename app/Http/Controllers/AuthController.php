<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    public function register(UserCreateRequest $request) : JsonResponse {
        try {
            DB::beginTransaction();
            $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return response()->json(['status' => 'Registration completed successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Something went wrong!'], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request) : JsonResponse {
        $user = $this->userRepository->find([
            'email' => $request->input('email'),
        ]);

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken('token');
            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'Invalid credentials',
        ], 404);
    }
}
