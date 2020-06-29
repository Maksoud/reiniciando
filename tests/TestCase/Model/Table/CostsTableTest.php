<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CostsTable Test Case
 */
class CostsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CostsTable
     */
    public $Costs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.costs',
        'app.parameters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Costs') ? [] : ['className' => 'App\Model\Table\CostsTable'];
        $this->Costs = TableRegistry::get('Costs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Costs);

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
