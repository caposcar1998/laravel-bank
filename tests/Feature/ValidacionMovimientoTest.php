<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Movement;
class ValidacionMovimientoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory() -> create();
        $saldoADepositar = 200.00;
        $accountEmisor = Account::create([
            'name' => 'Mi test account Emisor',
            'current_balance' => $saldoADepositar,
            'user_id' => $user->id
        ]);
        $movementEmisor = Movement::create([
            'type' => 1 ,
            'description' => 'Traspaso a Terceros',
            'before_balance' => $accountEmisor->current_balance ,
            'amount' => $saldoADepositar,
            'after_balance' => $accountEmisor->current_balance - $saldoADepositar,
            'account_id' => $accountEmisor->id,
        ]);
        $accountReceptor = Account::create([
            'name' => 'Mi test account Receptor',
            'current_balance' => 0,
            'user_id' => $user->id
        ]);
        $saldoADepositado = 200.00;
        $movementReceptor = Movement::create([
            'type' => 2 ,
            'description' => 'Traspaso de Terceros',
            'before_balance' => $accountReceptor->current_balance ,
            'amount' => $saldoADepositado,
            'after_balance' => $accountReceptor->current_balance + $saldoADepositado,
            'account_id' => $accountReceptor->id,
        ]);
        $this->assertEquals($movementEmisor-> amount, (($movementReceptor -> after_balance) -  $movementReceptor -> before_balance));
    }
}