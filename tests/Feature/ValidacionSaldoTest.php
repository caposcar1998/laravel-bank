<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Movement;
class ValidacionSaldoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory() -> create();
        $saldoADepositar = 100.00;
        $account = Account::create([
            'name' => 'Mi test account Saldo',
            'current_balance' => 1500,
            'user_id' => $user->id
        ]);
        $saldoActual = $account->current_balance;
        $this->assertTrue( $saldoActual >= $saldoADepositar);
    }
}
