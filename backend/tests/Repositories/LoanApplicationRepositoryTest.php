<?php namespace Tests\Repositories;

use App\Models\LoanApplication;
use App\Repositories\LoanApplicationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanApplicationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanApplicationRepository
     */
    protected $loanApplicationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanApplicationRepo = \App::make(LoanApplicationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_application()
    {
        $loanApplication = LoanApplication::factory()->make()->toArray();

        $createdLoanApplication = $this->loanApplicationRepo->create($loanApplication);

        $createdLoanApplication = $createdLoanApplication->toArray();
        $this->assertArrayHasKey('id', $createdLoanApplication);
        $this->assertNotNull($createdLoanApplication['id'], 'Created LoanApplication must have id specified');
        $this->assertNotNull(LoanApplication::find($createdLoanApplication['id']), 'LoanApplication with given id must be in DB');
        $this->assertModelData($loanApplication, $createdLoanApplication);
    }

    /**
     * @test read
     */
    public function test_read_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();

        $dbLoanApplication = $this->loanApplicationRepo->find($loanApplication->id);

        $dbLoanApplication = $dbLoanApplication->toArray();
        $this->assertModelData($loanApplication->toArray(), $dbLoanApplication);
    }

    /**
     * @test update
     */
    public function test_update_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();
        $fakeLoanApplication = LoanApplication::factory()->make()->toArray();

        $updatedLoanApplication = $this->loanApplicationRepo->update($fakeLoanApplication, $loanApplication->id);

        $this->assertModelData($fakeLoanApplication, $updatedLoanApplication->toArray());
        $dbLoanApplication = $this->loanApplicationRepo->find($loanApplication->id);
        $this->assertModelData($fakeLoanApplication, $dbLoanApplication->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_application()
    {
        $loanApplication = LoanApplication::factory()->create();

        $resp = $this->loanApplicationRepo->delete($loanApplication->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanApplication::find($loanApplication->id), 'LoanApplication should not exist in DB');
    }
}
