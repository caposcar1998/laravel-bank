<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Creates a user in the system
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }


    /**
     * Retrivest hola
     *
     * @return \Illuminate\Http\Response
     */
    public function accounts(Request $request, $account)
    {
        
        $userInfo = \App\Models\Account::where("account_number",$account)->get(); 
        return response()->json([
            'message' => strval($userInfo)
        ], 200);
    }

    public function createAccount(Request $request){
        $bodyContent = json_decode($request->getContent());

        $nombreCuenta =  $bodyContent->{'nombreCuenta'};
        $user = auth()->user()->id;
        Account::create([
            "name" => $nombreCuenta,
            "user_id" => $user,
        ]);
        return response()->json([
            'message' => "Creada con exito la cuenta"
        ], 201);
    }

    public function createMovement(Request $request, $account){
        $bodyContent = json_decode($request->getContent());
        $user = auth()->user()->id;
        $descripcion = $bodyContent->{'description'};
        $tipo = $bodyContent->{'type'};
        $cantidad = $bodyContent -> {'amount'};
        $accountInfoBal = \App\Models\Account::where("account_number",$account)->pluck('current_balance') ;
        $accountInfo = \App\Models\Account::where("account_number",$account)->pluck('id') ;
        $accountId = $accountInfo[0];
        $balance_anterior=$accountInfoBal[0];
        $cantidad_nueva = 0;
        if($tipo==1 ):
            $cantidad_nueva = $balance_anterior + $cantidad * -1;
        else:
            $cantidad_nueva = $balance_anterior + $cantidad * 1;
        endif;

            
        Movement::create([
            "type" => $tipo,
            "description" => $descripcion,
            "before_balance" => $balance_anterior,
            "amount" => $cantidad,
            "after_balance" => ($cantidad_nueva),
            'account_id' => $accountId,
        ]);
        return response()->json([
            'message' => 'Movement created'
        ]);
        


    }

    /**
     * Login the user and retrieve the token
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Logs the user out
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Retrivest the user information
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }
}
