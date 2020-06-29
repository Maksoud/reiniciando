<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportersTable Test Case
 */
class TransportersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportersTable
     */
    public $Transporters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.transporters',
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
        $config = TableRegistry::exists('Transporters') ? [] : ['className' => 'App\Model\Table\TransportersTable'];
        $this->Transporters = TableRegistry::get('Transporters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transporters);

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
