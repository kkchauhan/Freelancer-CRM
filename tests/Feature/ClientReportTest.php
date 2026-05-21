<?php

namespace Tests\Feature;

use App\Currency;
use App\IncomeSource;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ClientReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Dynamically define the gate so that we bypass dynamic middleware gates in console mode
        Gate::define('client_report_access', function () {
            return true;
        });
    }

    /** @test */
    public function it_can_render_the_client_report_page_successfully()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.client-reports.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.clientReports.index');
    }

    /** @test */
    public function it_can_process_transactions_with_null_relations_without_crashing()
    {
        $user = User::factory()->create();

        // Create a transaction with all nullable relationships set to null
        Transaction::create([
            'name'                => 'Null Relation Transaction',
            'amount'              => 150.00,
            'transaction_date'    => '21-05-2026', // Uses config('panel.date_format') via mutator if default is 'd-m-Y' or Y-m-d
            'currency_id'         => null,
            'income_source_id'    => null,
            'project_id'          => null,
            'transaction_type_id' => null,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.client-reports.index'));

        $response->assertStatus(200);
        $response->assertViewHas('entries');
        $response->assertSee('USD'); // Default fallback currency
        $response->assertSee('150'); // The income amount
    }

    /** @test */
    public function it_can_process_transactions_with_valid_relations()
    {
        $user = User::factory()->create();

        // Create currency and income source
        $currency = Currency::create([
            'name' => 'Euro',
            'code' => 'EUR',
            'main_currency' => 0,
        ]);

        $incomeSource = IncomeSource::create([
            'name'        => 'Upwork',
            'fee_percent' => 10.00,
        ]);

        // Create transaction with relations
        Transaction::create([
            'name'                => 'Full Relation Transaction',
            'amount'              => 500.00,
            'transaction_date'    => '21-05-2026',
            'currency_id'         => $currency->id,
            'income_source_id'    => $incomeSource->id,
            'project_id'          => null,
            'transaction_type_id' => null,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.client-reports.index'));

        $response->assertStatus(200);
        $response->assertViewHas('entries');
        $response->assertSee('EUR');
        $response->assertSee('500'); // Amount
        $response->assertSee('50');  // Fee (10% of 500)
    }
}
