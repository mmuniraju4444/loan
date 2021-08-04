<?php

namespace Tests\Unit;

use App\Models\LoanType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class APITest extends TestCase
{
    use RefreshDatabase;

    public function healthCheck()
    {
        $this->get('api/health')
            ->assertJson([
                'status' => 'SUCCESS'
            ])->assertOk();
    }

    public function testApplicantRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $response = $this->postJson('api/register',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertCreated()->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'type' => 'Applicant'
        ]);
    }

    public function testExistingApplicantRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $this->postJson('api/register',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        );

        $response = $this->postJson('api/register',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertSuccessful()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testMissingDataApplicantRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $response = $this->postJson('api/register',
            [
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertStatus(200)->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testApproverRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);

        $response = $this->postJson('api/register-approver',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertCreated()->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'type' => 'Approver'
        ]);
    }

    public function testExistingApproverRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);

        $this->postJson('api/register-approver',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        );
        $response = $this->postJson('api/register-approver',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertSuccessful()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testMissingDataApproverRegister()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $response = $this->postJson('api/register',
            [
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertStatus(200)->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testApproverLogin()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $this->postJson('api/register-approver',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        );

        $response = $this->postJson('api/login',
            [
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertOk()->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'type',
                'api_token',
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertEquals('Approver', $response['data']['type']);
    }

    public function testApplicantLogin()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $this->postJson('api/register',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        );

        $response = $this->postJson('api/login',
            [
                'email' => $user->email,
                'password' => $user->password
            ]
        )->assertOk()->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'type',
                'api_token',
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertEquals('Applicant', $response['data']['type']);
    }

    public function testNegativeLogin()
    {
        $response = $this->postJson('api/login',
            [
                'email' => 'approv@yopmail.com',
                'password' => '1234'
            ]
        )->assertOk()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testMissingDataLogin()
    {
        $user = User::factory()->makeOne(['password' => '1234']);
        $this->postJson('api/register',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]
        );
        $response = $this->postJson('api/login',
            [
                'email' => $user->email,
            ]
        )->assertOk()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testLoanInterest()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/loan-interests?api_token=' . $user->api_token)
            ->assertOk()->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'interest_rate'
                    ]
                ],
                'status'
            ]);
        $this->assertTrue($response['status']);
    }

    public function testLoanType()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/loan-types?api_token=' . $user->api_token)
            ->assertOk()->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'name'
                    ]
                ],
                'status'
            ]);
        $this->assertTrue($response['status']);
    }

    public function testRepaymentType()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/repayment-types?api_token=' . $user->api_token)
            ->assertOk()->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'name'
                    ]
                ],
                'status'
            ]);
        $this->assertTrue($response['status']);
    }

    public function testEmptyLoanApplications()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('api/loan-applications?api_token=' . $user->api_token)
            ->assertOk()->assertJsonStructure([
                'data',
                'status'
            ]);
        $this->assertTrue($response['status']);
    }

    public function testCreateLoanApplication()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        )->assertCreated()->assertJsonStructure([
            'data' => [
                'uuid',
                'request_id',
                'term',
                'amount',
                'emi',
                'total',
                'balance',
                'is_approved',
                'payment_count',
                'pending_payment_count'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertEquals(null, $response['data']['emi']);
        $this->assertEquals(false, $response['data']['is_approved']);
        $this->assertEquals(0, $response['data']['payment_count']);
        $this->assertEquals(null, $response['data']['pending_payment_count']);
    }

    public function testCreateLoanApplicationWithMissingData()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'amount' => 10000
            ]
        )->assertSuccessful()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testApproveLoanApplication()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            [
                'status' => 1
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'uuid',
                'request_id',
                'term',
                'amount',
                'emi',
                'total',
                'balance',
                'is_approved',
                'payment_count',
                'pending_payment_count'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertNotEquals(null, $response['data']['emi']);
        $this->assertEquals(true, $response['data']['is_approved']);
        $this->assertEquals(0, $response['data']['payment_count']);
        $this->assertNotEquals(null, $response['data']['pending_payment_count']);

    }

    public function testRejectLoanApplication()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            [
                'status' => 0
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'uuid',
                'request_id',
                'term',
                'amount',
                'emi',
                'total',
                'balance',
                'is_approved',
                'payment_count',
                'pending_payment_count'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertEquals(null, $response['data']['emi']);
        $this->assertEquals(false, $response['data']['is_approved']);
        $this->assertEquals(0, $response['data']['payment_count']);
        $this->assertEquals(null, $response['data']['pending_payment_count']);

    }

    public function testRejectLoanApplicationWithMissingData()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            []
        )->assertSuccessful()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

    public function testRepaymentLoanWithoutAmountParams()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        );

        $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            [
                'status' => 1
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/repayment?api_token=" . $user->api_token,
            []
        );

        $response->assertCreated()->assertJsonStructure([
            'data' => [
                'uuid',
                'transaction_id',
                'loan_application',
                'amount'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertNotEquals(null, $response['data']['amount']);
        $this->assertNotEquals(null, $response['data']['transaction_id']);
    }

    public function testRepaymentLoanAmountParams()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 10000
            ]
        );

        $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            [
                'status' => 1
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/repayment?api_token=" . $user->api_token,
            [
                'amount' => '2000'
            ]
        );

        $response->assertCreated()->assertJsonStructure([
            'data' => [
                'uuid',
                'transaction_id',
                'loan_application',
                'amount'
            ],
            'status'
        ]);
        $this->assertTrue($response['status']);
        $this->assertEquals(2000, $response['data']['amount']);
        $this->assertNotEquals(null, $response['data']['transaction_id']);
    }

    public function testRepaymentLoanExceedPayment()
    {
        $user = User::factory()->create(['type' => 'Approver']);
        $createResponse = $this->actingAs($user)->postJson('api/loan-applications?api_token=' . $user->api_token,
            [
                'loan_type_id' => LoanType::find(1)->uuid,
                'term' => '1',
                'amount' => 1000
            ]
        );

        $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/status?api_token=" . $user->api_token,
            [
                'status' => 1
            ]
        );

        $response = $this->actingAs($user)->postJson("api/loan-applications/{$createResponse['data']['uuid']}/repayment?api_token=" . $user->api_token,
            [
                'amount' => 2000
            ]
        );

        $response->assertSuccessful()->assertJsonStructure([
            'message',
            'status'
        ]);
        $this->assertFalse($response['status']);
    }

}
