<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentMergedsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentMergedsTable Test Case
 */
class MovimentMergedsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentMergedsTable
     */
    public $MovimentMergeds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_mergeds',
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
        $config = TableRegistry::exists('MovimentMergeds') ? [] : ['className' => 'App\Model\Table\MovimentMergedsTable'];
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentMergeds);

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
