<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegsTable Test Case
 */
class RegsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RegsTable
     */
    public $Regs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.regs',
        'app.parameters',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Regs') ? [] : ['className' => 'App\Model\Table\RegsTable'];
        $this->Regs = TableRegistry::get('Regs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Regs);

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
