<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentsMovimentCardsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentsMovimentCardsTable Test Case
 */
class MovimentsMovimentCardsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentsMovimentCardsTable
     */
    public $MovimentsMovimentCards;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviments_moviment_cards',
        'app.parameters',
        'app.users',
        'app.users_parameters',
        'app.rules',
        'app.cards',
        'app.providers',
        'app.costs',
        'app.moviments',
        'app.banks',
        'app.boxes',
        'app.plannings',
        'app.coins',
        'app.event_types',
        'app.customers',
        'app.document_types',
        'app.account_plans',
        'app.moviment_cards'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovimentsMovimentCards') ? [] : ['className' => 'App\Model\Table\MovimentsMovimentCardsTable'];
        $this->MovimentsMovimentCards = TableRegistry::get('MovimentsMovimentCards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentsMovimentCards);

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
