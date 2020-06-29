<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersParametersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersParametersTable Test Case
 */
class UsersParametersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersParametersTable
     */
    public $UsersParameters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_parameters',
        'app.parameters',
        'app.users',
        'app.rules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersParameters') ? [] : ['className' => 'App\Model\Table\UsersParametersTable'];
        $this->UsersParameters = TableRegistry::get('UsersParameters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersParameters);

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
