<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ParametersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ParametersController Test Case
 */
class ParametersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parameters',
        'app.mf_coins',
        'app.mf_document_types',
        'app.mf_carriers',
        'app.mf_event_types',
        'app.mf_costs',
        'app.mf_account_plans',
        'app.mc_coins',
        'app.mc_event_boxes',
        'app.mc_costs',
        'app.mc_account_plans',
        'app.mb_coins',
        'app.mb_event_banks',
        'app.mb_event_types',
        'app.mb_costs',
        'app.mb_account_plans',
        'app.mt_coins',
        'app.mt_event_types',
        'app.mt_costs',
        'app.mt_account_plans',
        'app.mh_coins',
        'app.mh_event_banks',
        'app.mh_event_boxes',
        'app.mh_event_types',
        'app.mh_costs',
        'app.mh_account_plans',
        'app.users',
        'app.users_parameters'
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
