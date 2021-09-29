<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Movement;
use Illuminate\Support\Carbon;

class MovementLocalAccount extends Controller
{
        /**
     * Creates a user in the system
     *
     * @return \Illuminate\Http\Response
     */
    public function hola(Request $request)
    {
        $timestamp = nowLocal()->getTimestamp();
        $bodyContent = json_decode($request->getContent());
        $cuentaOrigen =  $bodyContent->{'cuentaOrigen'};
        $cuentaDestino =  $bodyContent->{'cuentaDestino'};
        $cantidad =  $bodyContent->{'cantidad'};
        $user = auth()->user()->id;
        $idUsuarioCuentaOrigen = Account::where("account_number","=",$cuentaOrigen)->value("user_id");
        $idUsuarioCuentaDestino = Account::where("account_number","=",$cuentaDestino)->value("user_id");
        $idCuentaOrigen=Account::where("account_number","=",$cuentaOrigen)->value("id");
        $idCunetaDestino=Account::where("account_number","=",$cuentaDestino)->value("id");
        $dataOrigin = [];
        $dataDestino = [];
        
        if($idUsuarioCuentaOrigen != null and $idUsuarioCuentaDestino != null){

            $previousBalanceOrigin = Account::where("account_number","=",$cuentaOrigen)->value("current_balance");
            $previousBalanceDestiny = Account::where("account_number","=",$cuentaDestino)->value("current_balance");

            if(($previousBalanceOrigin-$cantidad)> 0){
                Account::where("account_number","=",$cuentaOrigen)->update(["current_balance" => $previousBalanceOrigin-$cantidad]);
                Account::where("account_number","=",$cuentaDestino)->update(["current_balance" => $previousBalanceDestiny+$cantidad]);
                
                $dataOrigin['type'] = 3;
                $dataOrigin['description'] = "Transferencia-";
                $dataOrigin['before_balance'] = $previousBalanceOrigin;
                $dataOrigin['amount'] = $cantidad;
                $dataOrigin['after_balance'] = $previousBalanceOrigin-$cantidad;
                $dataOrigin['account_id'] = $idCuentaOrigen;
                Movement::create($dataOrigin);


                $dataDestino['type'] = 3;
                $dataDestino['description'] = "Transferencia+";
                $dataDestino['before_balance'] = $previousBalanceDestiny;
                $dataDestino['amount'] = $cantidad;
                $dataDestino['after_balance'] = $previousBalanceDestiny+$cantidad;
                $dataDestino['account_id'] = $idCunetaDestino;
                Movement::create($dataDestino);


                return response()->json([
                    'message' => "Transferencia realizada con exito"
                ], 201);  
            }else{
                return response()->json([
                    'message' => "La cuenta origen no tiene el balance necesario para hacer esta operacion"
                ], 400);
            }
            
        }else{
            return response()->json([
                'message' => "Alguna de las 2 cuentas no pertenece al usuario"
            ], 400);   
        }


    }
}
