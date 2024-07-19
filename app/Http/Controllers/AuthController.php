<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Message as MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        //if (Gate::allows('permission-adm')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users', // Added unique validation
                'password' => 'required|max:255',
                'name' => 'required|max:256',
                'login' => 'required|unique:users|max:50',
                'is_admin' => 'boolean',
                'enable' => 'boolean'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] =  $user->user;

            return $this->sendResponse($success, 'User register successfully.');
       // }else{
            return response()->json([
                "message"=> "Usuário sem permissão"
            ],403);
        //}
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['login' => $request->login, 'password' => $request->password])) {
            $user = Auth::user();
            if($user->enable == 0 ){
                return response()->json(['message' => 'User disable!'],202);
            }

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            session()->put('cnp', $user->cnp);
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Usuário ou senha incorretos', ['error' => 'Usuário ou senha incorretos']);
        }
    }

    public function forgot(Request $request)
    {
        DB::setDefaultConnection('SegundaVia');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $email = $request->input('email');

        /*
        if (User::where('email', $email)->doesntExists()) {
            return response(
                [
                    'message' => 'User doen\'t exists!',

                ],
                404
            );*/

        $token = Str::random(10);
        try {
            DB::connection('SegundaVia')->table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]);
        } catch (\Exception $exception) {
            if (Str::contains($exception->getMessage(), 'insert duplicate')) {
                DB::connection('SegundaVia')->table('password_reset_tokens')->where('email', $email)->update([
                    'token' => $token
                ]);
            }
        }

        try {
            Mail::send('Mails.forgot', ['token' => $token], function (MailMessage $message) use ($email) {
                $message->to($email);
                $message->subject('Alterar senha');
            });

            return response([
                'message' => 'Checked you email!'
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function reset(Request $request)
    {
        DB::setDefaultConnection('SegundaVia');
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $token = $request->input('token');

        if (!$passwordResets = DB::connection('SegundaVia')->table('password_reset_tokens')->where('token', $token)->first()) {
            return response([
                'message' => 'Invalid token!'
            ], 400);
        }

        if (!$user = DB::connection('SegundaVia')->table('users')->where('email', $passwordResets->email)->first()) {
            return response([
                'message' => 'User does\'t exist!'
            ], 404);
        }

        $password = Hash::make($request->input('password'));


        if (DB::connection('SegundaVia')->table('users')->where('id', $user->id)->update(['password' => $password])) {
            return response([
                'message' => 'sucess'
            ]);
        }
    }
}
