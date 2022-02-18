<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $email = $request->input('email');

        if(User::whereEmail($email)->doesntExist()) {
            return response([
                'message' => 'User Does Not Exists!!',
            ], 404);
        }

        $token = Str::random(10);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);

            // Send Email
            Mail::send('Mails.forgot', [
                'token' => $token,
            ], function (Message $msg) use($email) {
                $msg->to($email);
                $msg->subject('Reset Your Password');
            });

            return response([
                'message' => 'Check Your Email.',
            ]);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function reset(ResetRequest $request)
    {
        $token = $request->input('token');

        if(!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return response([
                'message' => 'Invalid Token!'
            ], 400);
        }

        $user = User::where('email', $passwordResets->email)->first();

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response([
            'message' => 'Success',
        ]);

    }
}
