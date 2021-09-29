<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Movement;
use Illuminate\Support\Carbon;

class MovementExternalAccount extends Controller
{
        /**
     * Creates a user in the system
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        $timestamp = nowLocal()->getTimestamp();
        $bodyContent = json_decode($request->getContent());
        $fromAccount =  $bodyContent->{'cuentaOrigen'};
        $toAccount =  $bodyContent->{'cuentaDestino'};
        $amount =  $bodyContent->{'cantidad'} * 100;
        $user = auth()->user()->id;
        $userIdFromAccount = Account::where("account_number","=",$fromAccount)->value("user_id");
        $userIdToAccount = Account::where("account_number","=",$toAccount)->value("user_id");
        $accountIdFrom =Account::where("account_number","=",$fromAccount)->value("id");
        $accountIdTo=Account::where("account_number","=",$toAccount)->value("id");
        $nameFrom = User::where("id", "=", $userIdFromAccount)->value("name");
        $accountFrom = Account::where("id", "=", $accountIdFrom)->value("name");
        $nameTo = User::where("id", "=", $userIdToAccount)->value("name");
        $accountTo = Account::where("id", "=", $accountIdTo)->value("name");
        $dataFrom = [];
        $dataTo = [];
        
        
        if($accountIdFrom != null and $accountIdTo != null){
            if($userIdFromAccount != $userIdToAccount){

            
                $previousBalanceFrom = Account::where("account_number","=",$fromAccount)->value("current_balance");
                $previousBalanceTo = Account::where("account_number","=",$toAccount)->value("current_balance");

                if(($previousBalanceFrom-$amount)> 0){
                    Account::where("account_number","=",$fromAccount)->update(["current_balance" => $previousBalanceFrom-$amount]);
                    Account::where("account_number","=",$toAccount)->update(["current_balance" => $previousBalanceTo+$amount]);

                    $dataFrom['type'] = 4;
                    $dataFrom['description'] = "Transferencia Externa al usuario: " . $nameTo . " a la cuenta: " . $accountTo;
                    $dataFrom['before_balance'] = $previousBalanceFrom;
                    $dataFrom['amount'] = $amount;
                    $dataFrom['after_balance'] = $previousBalanceFrom-$amount;
                    $dataFrom['account_id'] = $accountIdFrom;
                    Movement::create($dataFrom);


                    $dataTo['type'] = 4;
                    $dataTo['description'] = "Transferencia Externa proveniente del usuario: " . $nameFrom . " desde la cuenta: " . $accountFrom;
                    $dataTo['before_balance'] = $previousBalanceTo;
                    $dataTo['amount'] = $amount;
                    $dataTo['after_balance'] = $previousBalanceTo+$amount;
                    $dataTo['account_id'] = $accountIdTo;
                    Movement::create($dataTo);


                    return response()->json([
                        'message' => "Transferencia Externa al usuario: " . $nameTo . " a la cuenta: " . $accountTo . ". Transferencia Externa proveniente del usuario: " . $nameFrom . " desde la cuenta: " . $accountFrom
                    ], 201);  
                }else{
                    return response()->json([
                        'message' => "La cuenta ". $accountFrom ." no tiene el balance necesario para hacer esta operación"
                    ], 400);
                }
            }else{
                return response()->json([
                    'message' => "La transferencia debe ser hacia una cuenta externa, no una cuenta propia."
                ]);
            }
            
        }else{
            return response()->json([
                'message' => "Alguna de las 2 cuentas no pertenece al usuario"
            ], 400);   
        }


    }
}
