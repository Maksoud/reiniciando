<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentBoxesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentBoxesTable Test Case
 */
class MovimentBoxesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentBoxesTable
     */
    public $MovimentBoxes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_boxes',
        'app.parameters',
        'app.boxes',
        'app.costs',
        'app.document_types',
        'app.event_types',
        'app.moviment_checks',
        'app.transfers',
        'app.moviments',
        'app.account_plans',
        'app.coins',
        'app.customers',
        'app.providers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovimentBoxes') ? [] : ['className' => 'App\Model\Table\MovimentBoxesTable'];
        $this->MovimentBoxes = TableRegistry::get('MovimentBoxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentBoxes);

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
