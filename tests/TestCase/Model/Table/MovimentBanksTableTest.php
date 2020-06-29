<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentBanksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentBanksTable Test Case
 */
class MovimentBanksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentBanksTable
     */
    public $MovimentBanks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_banks',
        'app.parameters',
        'app.banks',
        'app.costs',
        'app.document_types',
        'app.event_types',
        'app.moviment_checks',
        'app.transfers',
        'app.moviments',
        'app.providers',
        'app.customers',
        'app.account_plans',
        'app.coins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovimentBanks') ? [] : ['className' => 'App\Model\Table\MovimentBanksTable'];
        $this->MovimentBanks = TableRegistry::get('MovimentBanks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentBanks);

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
