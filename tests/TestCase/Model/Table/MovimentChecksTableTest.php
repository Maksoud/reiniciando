<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentChecksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentChecksTable Test Case
 */
class MovimentChecksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentChecksTable
     */
    public $MovimentChecks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_checks',
        'app.parameters',
        'app.banks',
        'app.boxes',
        'app.costs',
        'app.event_types',
        'app.providers',
        'app.account_plans',
        'app.moviments',
        'app.transfers',
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
        $config = TableRegistry::exists('MovimentChecks') ? [] : ['className' => 'App\Model\Table\MovimentChecksTable'];
        $this->MovimentChecks = TableRegistry::get('MovimentChecks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentChecks);

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
