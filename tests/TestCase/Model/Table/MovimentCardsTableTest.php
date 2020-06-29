<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentCardsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentCardsTable Test Case
 */
class MovimentCardsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentCardsTable
     */
    public $MovimentCards;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_cards',
        'app.parameters',
        'app.cards',
        'app.providers',
        'app.costs',
        'app.moviments',
        'app.moviments_moviment_cards',
        'app.banks',
        'app.boxes',
        'app.document_types',
        'app.event_types',
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
        $config = TableRegistry::exists('MovimentCards') ? [] : ['className' => 'App\Model\Table\MovimentCardsTable'];
        $this->MovimentCards = TableRegistry::get('MovimentCards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentCards);

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
