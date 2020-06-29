<?php
namespace App\Test\TestCase\Controller;

use App\Controller\MovimentBanksController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\MovimentBanksController Test Case
 */
class MovimentBanksControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_banks',
        'app.parameters',
        'app.banks',
        'app.costs',
        'app.document_types',
        'app.event_types',
        'app.moviment_checks',
        'app.transfers',
        'app.moviments',
        'app.providers',
        'app.customers',
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
