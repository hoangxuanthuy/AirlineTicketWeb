<?php

namespace App\Http\Controllers\Authenication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessTokenResult;
use App\Business\AuthBiz\AuthBusiness;

class AuthController
{
    protected AuthBusiness $authBusiness;
    public function __construct()
    {
        $this->authBusiness = new AuthBusiness();
    }

    // Đăng ký người dùng mới
    public function register(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tạo token khi đăng ký thành công
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
    public function registercus(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:Account,email',
            'password' => 'required|string|min:6|confirmed',
            'account_name' => 'required|string|max:100',
            'citizen_id' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
        ]);

        try {
            $result = $this->authBusiness->createAccount($request->all());

            return response()->json([
                'message' => 'Đăng ký thành công!',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi đăng ký tài khoản.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Đăng nhập
    public function login(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Kiểm tra thông tin đăng nhập
        $user = User::where('email', $request->email)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }
        $role = DB::table('UserRoles')
            ->join('Roles', 'UserRoles.RoleID', '=', 'Roles.RoleID')
            ->where('UserRoles.UserID', $user->id)
            ->where('UserRoles.IsDeleted', 0)
            ->value('Roles.RoleName');

        if (!$role) {
            $role = 'Unknown'; // Nếu không tìm thấy role, đặt giá trị mặc định
        }
        $accountId = DB::table('Account')
        ->where('UserID', $user->id)
        ->where('IsDeleted', 0)
        ->value('account_id');
        // Tạo token khi đăng nhập thành công
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $role,// Thêm trường role
            'account_id' => $accountId 
        ], 200);
       

    }

    // Lấy thông tin người dùng đã đăng nhập
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
