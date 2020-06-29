<?php
namespace App\Test\TestCase\Controller;

use App\Controller\MovimentChecksController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\MovimentChecksController Test Case
 */
class MovimentChecksControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moviment_checks',
        'app.parameters',
        'app.banks',
        'app.boxes',
        'app.costs',
        'app.event_types',
        'app.providers',
        'app.account_plans',
        'app.moviments',
        'app.transfers',
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
