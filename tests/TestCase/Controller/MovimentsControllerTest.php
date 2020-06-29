<?php
namespace App\Test\TestCase\Controller;

use App\Controller\MovimentsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\MovimentsController Test Case
 */
class MovimentsControllerTest extends IntegrationTestCase
{

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
