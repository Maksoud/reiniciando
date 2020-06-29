<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountPlansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountPlansTable Test Case
 */
class AccountPlansTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountPlansTable
     */
    public $AccountPlans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.account_plans',
        'app.parameters',
        'app.users',
        'app.users_parameters',
        'app.rules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AccountPlans') ? [] : ['className' => 'App\Model\Table\AccountPlansTable'];
        $this->AccountPlans = TableRegistry::get('AccountPlans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccountPlans);

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
