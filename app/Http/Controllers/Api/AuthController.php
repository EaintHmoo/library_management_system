<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use App\Models\Member;
use App\Helper\NoGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()
                ], Response::HTTP_FORBIDDEN);
        }

        $registerUserData = $validator->validated();

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $registerUserData['name'],
                'email' => $registerUserData['email'],
                'password' => Hash::make($registerUserData['password']),
            ]);

            $member = Member::create([
                'member_no' => NoGenerator::generateMemberNo(),
                'date_of_membership' => date('Y-m-d'),
                'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
                'address' => $request->address,
                'phone_no' => $request->phone_no,
                'user_id' => $user->id,
            ]);

            $user->roles()->sync(3);
            DB::commit();

            return response()
                ->json([
                    'message' => 'Register Successfully! wait to be approved by admin',
                    'status' => Response::HTTP_CREATED,
                ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()
                ->json([
                    'message' => 'Fail to register',
                    'status'   => Response::HTTP_INTERNAL_SERVER_ERROR,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()
                ], Response::HTTP_FORBIDDEN);
        }

        $loginUserData = $validator->validated();

        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Email or password wrong!!',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($user->approved !== 1) {
            return response()->json([
                'message' => 'Please wait admin approve.',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken($user->id . $user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'data' => new UserResource($user),
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out successfully",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function approve(User $user)
    {
        $user->update([
            'approved' => 1
        ]);

        return response()->json([
            'message' => 'User approved successfully',
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newPassword' => 'required|min:6',
            'oldPassword' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()
                ], Response::HTTP_FORBIDDEN);
        }

        $requestData = $validator->validated();

        $user = auth()->user();
        if (Hash::check($requestData['oldPassword'], $user->password)) {
            auth()->user()->update([
                'password' => Hash::make($requestData['newPassword']),
            ]);
            return response()
                ->json([
                    'message' => 'Change password successfully',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
        } else {
            return response()
                ->json([
                    'errors' => [
                        'oldPassword' => 'Old password is wrong',
                    ],
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            auth()->user()->update([
                'name' => $request->name ?? auth()->user()->name,
                'email' => $request->email ?? auth()->user()->email,
            ]);

            return response()
                ->json([
                    'message' => 'Profile updated successfully',
                    'user' => new UserResource(auth()->user()),
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => 'Fail to update',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function  deleteAccount()
    {
        auth()->user()->delete();
        return response()
            ->json([
                'message' => 'Account deleted successfully',
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
    }
}
