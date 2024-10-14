<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\LoanApplication;
use Laravel\Sanctum\Sanctum;
// tests/Feature/LoanApplicationAPIControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\LoanApplication;
use Laravel\Sanctum\Sanctum;

class LoanApplicationAPIControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_apply_for_a_loan()
    {
        // Creating a user
        $user = User::factory()->create();

        // Authenticating with Sanctum
        Sanctum::actingAs($user);

        // Creating a loan application request payload
        $data = [
            'customer_id' => (string) $user->id,
            'loan_amount' => 500000,
            'repayment_period' => 2,
            'loan_purpose' => 'Personal use',
        ];

        // Sending a POST request to the apply route
        $response = $this->postJson('/api/loans/apply', $data);

        // Assert the response
        $response->assertStatus(201)->assertJson([
            'success' => true,
            'loanId' => '1',
            'status' => 'PENDING',
            'message' => 'Dear ' . $user->name . ' your Loan Application has been submitted successfully.',
        ]);


        // Assert the loan application is in the database
        $this->assertDatabaseHas('loan_applications', [
            'customer_id' => (string) $user->id,
            'loan_amount' => 500000, // Ensure this matches the amount in your request
            'repayment_period' => 2,
            'loan_purpose' => 'Personal use',
            'status' => 'PENDING'
        ]);
    }


    // /** @test */
    // public function it_can_retrieve_loan_application_details()
    // {
    //     // Creating a user
    //     $user = User::factory()->create();

    //     // Authenticating with Sanctum
    //     Sanctum::actingAs($user);

    //     // Creating a loan application
    //     $loanApplication = LoanApplication::factory()->create([
    //         'customer_id' => (string) $user->id,
    //         'loan_amount' => 500000,
    //         'repayment_period' => 6,
    //         'loan_purpose' => 'Personal use',
    //     ]);

    //     // Sending a GET request to retrieve the loan application
    //     $response = $this->getJson('/api/loans/' . $loanApplication->id);

    //     // Assertting the response
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'loanId' => (string) $loanApplication->id,
    //             'loanAmount' => $loanApplication->loan_amount,
    //             'repaymentPeriod' => $loanApplication->repayment_period,
    //             'loanPurpose' => $loanApplication->loan_purpose,
    //             'status' => $loanApplication->status,

    //         ]);
    // }


    /** @test */
    public function it_should_return_validation_error_for_invalid_customer_id()
    {

        // Creating a user
        $user = User::factory()->create();

        // Authenticating with Sanctum
        Sanctum::actingAs($user);

        // Defining the request data with an invalid customer id
        $data = [
            'customer_id' => 123,
            'loan_amount' => 10000,
            'repayment_period' => 12,
            'loan_purpose' => 'Testing Loan'
        ];

        // Make the post request to the loan application endpoint
        $response = $this->postJson('/api/loans/apply', $data);

        // Assert that the response status is 422 (Unprocessable Entity)
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'customer_id' => [
                        'The customer id must be a string.'
                    ]
                ]
            ]);
    }


    /** @test */
    public function it_returns_error_when_customer_not_found()
    {
        // Creating a user
        $user = User::factory()->create();

        // Authenticating with Sanctum
        Sanctum::actingAs($user);

        $data = [
            'customer_id' => '999',
            'loan_amount' => 500000,
            'repayment_period' => 6,
            'loan_purpose' => 'Personal use'
        ];

        $response = $this->postJson('/api/loans/apply', $data);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Customer not found.'
            ]);
    }
    /**
     * Summary of it_can_update_loan_application
     * @test
     */
    // public function it_can_update_loan_application()
    // {
    //     // Creating a user and a pending loan application
    //     $userTest = User::factory()->create();

    //     Sanctum::actingAs($userTest);

    //     $loan = LoanApplication::factory()->create([
    //         'customer_id' => $userTest->id,
    //         'status' => 'PENDING',
    //         'loan_amount' => 50000,
    //         'repayment_period' => 6,
    //         'loan_purpose' => 'Home renovation'
    //     ]);

    //     //request body
    //     $resquestBody = [
    //         'loan_amount' => 60000,
    //         'repayment_period' => 8,
    //         'loan_purpose' => 'Business expansion'
    //     ];
    //     // dd($resquestBody);
    //     $response = $this->putJson("/api/loans/{$loan->id}", $resquestBody);

    //     //Asserting the response
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'success' => true,
    //             'message' => "Your loan application has been updated successfully"
    //         ]);

    //     // Asserting that  the loan was updated in the database
    //     $this->assertDatabaseHas('loan_applications', [
    //         'id' => $loan->id,
    //         'loan_amount' => 60000,
    //         'repayment_period' => 8,
    //         'loan_purpose' => 'Business expansion'
    //     ]);
    // }


}

