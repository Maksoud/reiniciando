<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\KnowledgesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\KnowledgesTable Test Case
 */
class KnowledgesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\KnowledgesTable
     */
    public $Knowledges;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.knowledges'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Knowledges') ? [] : ['className' => 'App\Model\Table\KnowledgesTable'];
        $this->Knowledges = TableRegistry::get('Knowledges', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Knowledges);

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
}
