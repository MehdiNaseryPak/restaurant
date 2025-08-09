<?php

namespace App\Http\Controllers\V1\Auth;

use App\Enum\User\UserAdmin;
use App\Enum\User\UserStatus;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\BaseResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRegisterRequest;
use App\Http\Requests\VerifyCodeRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="مستندات وبسرویس پروژه رستوران",
 *      @OA\Contact(
 *          email="mhdynasrypak@gmail.com"
 *      )
 * )
 */
class AuthController extends Controller
{
    /**
     * login_register
     *
     * @param  mixed $request
     * @return void
     */
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login_register",
     *     summary="ثبت نام یا ورود",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mobile"},
     *             @OA\Property(property="mobile", type="number", example="09055318385")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="داده های معتبر",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="کد به شماره 09055318385 ارسال شد"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={})
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="داده‌های نامعتبر",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="سرور با خطا مواجه شد"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={})
     *         )
     *      ),
     * )
     */
    public function login_register(LoginRegisterRequest $request)
    {
        $mobile = $request->mobile;
        $user = User::where('mobile', $mobile)->exists();
        if($user)
            return $this->login($mobile);

        return $this->register($mobile);
    }

    /**
     * verify_code
     *
     * @param  mixed $request
     * @return JsonResponse
     */
        /**
     * @OA\Post(
     *     path="/api/v1/auth/verify_code",
     *     summary="تایید کد تاییده",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mobile","code"},
     *             @OA\Property(property="mobile", type="number", example="09055318385"),
     *             @OA\Property(property="code", type="number", example="1234"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="داده معتبر",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="عملیات ورود با موفقیت انجام شد"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={"first_name": null,"last_name": null,"mobile": "09055318385","status": "active","is_admin": "user","token": "5|3wNqp8NaONkkpa5oSLEglhhaHbb6NpyEMyfhAF3423c3293e"})
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="داده‌های نامعتبر",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="سرور با خطا مواجه شد"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="string"), example={})
     *         )
     *      ),
     * )
     */
    public function verify_code(VerifyCodeRequest $request): JsonResponse
    {
        $mobile = $request->mobile;
        $code = $request->code;
        $user = User::where('mobile', $mobile)->first();
        if(!$user)
            return BaseResponse::error('کاربری یافت نشد',[]);

        $otp = $user->otps()->where([['code' , $code], ['created_at', Carbon::now()->subMinutes(2) ]])->get();
        if(!$otp)
            return BaseResponse::error('کد اشتباه است یا منقضی شده',[]);

        if(!$user->status)
            $user->update(['status' => UserStatus::Active]);

        $token = $user->createToken('token')->plainTextToken;
        $user->token = $token;
        $data = new UserResource($user);

        return BaseResponse::success(' ورود با موفقیت انجام شد', $data);

    }

    private function generate_code()
    {
        $code = rand(1111,9999);
        return $code;
    }
    private function login($mobile)
    {
        $user = User::where('mobile', $mobile)->first();
        $create_otp = $this->create_otp($user);

        if(!$create_otp)
            return BaseResponse::error("کد یافت نشد", []);

        return BaseResponse::success("کد به شماره $mobile ارسال شد", []);
    }
    private function register($mobile)
    {
        $user = User::create([
            'mobile' => $mobile,
            'status' => UserStatus::Inactive,
            'is_admin' => UserAdmin::Inactive
        ]);

        $create_otp = $this->create_otp($user);

        if(!$create_otp)
            return BaseResponse::error("کد یافت نشد", []);

        return BaseResponse::success("کد به شماره $mobile ارسال شد", []);
    }

    private function create_otp($user): bool
    {
        $code = $this->generate_code();
        $otp_code = $user->otps()->create(['code' => $code]);
        // send code
        return $otp_code ? true : false;
    }


}
