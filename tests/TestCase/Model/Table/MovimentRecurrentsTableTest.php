<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentRecurrentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentRecurrentsTable Test Case
 */
class MovimentRecurrentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentRecurrentsTable
     */
    public $MovimentRecurrents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_recurrents',
        'app.parameters',
        'app.users',
        'app.users_parameters',
        'app.rules',
        'app.moviments',
        'app.banks',
        'app.boxes',
        'app.cards',
        'app.providers',
        'app.costs',
        'app.plannings',
        'app.coins',
        'app.event_types',
        'app.customers',
        'app.document_types',
        'app.account_plans',
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
        $config = TableRegistry::exists('MovimentRecurrents') ? [] : ['className' => 'App\Model\Table\MovimentRecurrentsTable'];
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentRecurrents);

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
