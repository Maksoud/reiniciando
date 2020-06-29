<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupportContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupportContactsTable Test Case
 */
class SupportContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SupportContactsTable
     */
    public $SupportContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.support_contacts',
        'app.parameters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SupportContacts') ? [] : ['className' => 'App\Model\Table\SupportContactsTable'];
        $this->SupportContacts = TableRegistry::get('SupportContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SupportContacts);

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
