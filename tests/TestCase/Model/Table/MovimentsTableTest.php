<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentsTable Test Case
 */
class MovimentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentsTable
     */
    public $Moviments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviments',
        'app.parameters',
        'app.users',
        'app.users_parameters',
        'app.rules',
        'app.banks',
        'app.boxes',
        'app.cards',
        'app.providers',
        'app.costs',
        'app.plannings',
        'app.event_types',
        'app.customers',
        'app.document_types',
        'app.account_plans',
        'app.coins',
        'app.moviment_cards',
        'app.moviments_moviment_cards'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Moviments') ? [] : ['className' => 'App\Model\Table\MovimentsTable'];
        $this->Moviments = TableRegistry::get('Moviments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Moviments);

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
