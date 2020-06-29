<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BoxesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BoxesTable Test Case
 */
class BoxesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BoxesTable
     */
    public $Boxes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.boxes',
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
        $config = TableRegistry::exists('Boxes') ? [] : ['className' => 'App\Model\Table\BoxesTable'];
        $this->Boxes = TableRegistry::get('Boxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Boxes);

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
