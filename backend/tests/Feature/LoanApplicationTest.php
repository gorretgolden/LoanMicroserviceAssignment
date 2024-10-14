<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanApplicationTest extends TestCase
{
    public function testLoanApplication()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/loans/apply');

        $response->assertStatus(201);
    }
}
