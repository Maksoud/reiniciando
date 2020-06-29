<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParametersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParametersTable Test Case
 */
class ParametersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParametersTable
     */
    public $Parameters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parameters',
        'app.mf_coins',
        'app.mf_document_types',
        'app.mf_carriers',
        'app.mf_event_types',
        'app.mf_costs',
        'app.mf_account_plans',
        'app.mc_coins',
        'app.mc_event_boxes',
        'app.mc_costs',
        'app.mc_account_plans',
        'app.mb_coins',
        'app.mb_event_banks',
        'app.mb_event_types',
        'app.mb_costs',
        'app.mb_account_plans',
        'app.mt_coins',
        'app.mt_event_types',
        'app.mt_costs',
        'app.mt_account_plans',
        'app.mh_coins',
        'app.mh_event_banks',
        'app.mh_event_boxes',
        'app.mh_event_types',
        'app.mh_costs',
        'app.mh_account_plans',
        'app.users',
        'app.users_parameters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Parameters') ? [] : ['className' => 'App\Model\Table\ParametersTable'];
        $this->Parameters = TableRegistry::get('Parameters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parameters);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
