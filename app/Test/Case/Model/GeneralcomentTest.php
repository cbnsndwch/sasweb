<?php
App::uses('Generalcoment', 'Model');

/**
 * Generalcoment Test Case
 *
 */
class GeneralcomentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.generalcoment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Generalcoment = ClassRegistry::init('Generalcoment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Generalcoment);

		parent::tearDown();
	}

}
