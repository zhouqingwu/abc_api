<?php

namespace Tests\Unit;

use App\Models\PurchaseTransaction;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEligibleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * user eligible participate check
     *
     * @return void
     */
    public function test_user_is_eligible_to_participate()
    {
        $user = $this->createUser();

        for ($i = 0; $i< 3; $i++) {
            $this->createPurchaseTransaction(
                [
                    'user_id' => $user->id,
                    'total_spent' => 35,
                    'total_saving' => 3,
                    'transaction_at' => $this->faker->dateTimeBetween(startDate:'-30days', endDate:'now', timezone:'Asia/Singapore'),
                ]
            );
        }

        $this->assertTrue($user->isEligible());
    }


    public function test_user_is_not_eligible_to_participate()
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $user3 = $this->createUser();

        // transactions less than 3
        for ($i = 0; $i< 2; $i++) {
            $this->createPurchaseTransaction(
                [
                    'user_id' => $user1->id,
                    'total_spent' => 35,
                    'total_saving' => 3,
                    'transaction_at' => $this->faker->dateTimeBetween(startDate:'-30days', endDate:'now', timezone:'Asia/Singapore'),
                ]
            );
        }

        // date brefore 30 days
        for ($i = 0; $i< 3; $i++) {
            $this->createPurchaseTransaction(
                [
                    'user_id' => $user2->id,
                    'total_spent' => 35,
                    'total_saving' => 3,
                    'transaction_at' => $this->faker->dateTimeBetween(startDate:'-60days', endDate:'-31days', timezone:'Asia/Singapore'),
                ]
            );
        }

        // amount less than 100
        for ($i = 0; $i< 3; $i++) {
            $this->createPurchaseTransaction(
                [
                    'user_id' => $user3->id,
                    'total_spent' => 30,
                    'total_saving' => 3,
                    'transaction_at' => $this->faker->dateTimeBetween(startDate:'-30days', endDate:'now', timezone:'Asia/Singapore'),
                ]
            );
        }

        $this->assertFalse($user1->isEligible());
        $this->assertFalse($user2->isEligible());
        $this->assertFalse($user3->isEligible());
    }
}
