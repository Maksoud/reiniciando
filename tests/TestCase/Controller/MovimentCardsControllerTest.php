<?php
namespace App\Test\TestCase\Controller;

use App\Controller\MovimentCardsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\MovimentCardsController Test Case
 */
class MovimentCardsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
