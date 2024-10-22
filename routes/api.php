<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request): JsonResponse {
    $user = User::where('email', $request->input('email'))->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(
            [
                'msg' => 'No dijiste la palabra Magica'
            ],
            401
        );
    }
    return response()->json(
        [
            'user' =>
            [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $user->createToken('api')->plainTextToken,
        ]
    );
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/sql', 'App\Http\Controllers\Querys\queryControler@execQuery');
});
