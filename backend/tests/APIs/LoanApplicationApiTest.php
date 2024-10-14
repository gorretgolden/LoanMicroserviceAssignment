<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanApplication;

class LoanApplicationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_application()
    {
        $loanApplication = LoanApplication::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_applications', $loanApplication
        );

        $this->assertApiResponse($loanApplication);
    }

    /**
     * @test
     */
    public function test_read_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_applications/'.$loanApplication->id
        );

        $this->assertApiResponse($loanApplication->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();
        $editedLoanApplication = LoanApplication::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_applications/'.$loanApplication->id,
            $editedLoanApplication
        );

        $this->assertApiResponse($editedLoanApplication);
    }

    /**
     * @test
     */
    public function test_delete_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_applications/'.$loanApplication->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_applications/'.$loanApplication->id
        );

        $this->response->assertStatus(404);
    }
}
