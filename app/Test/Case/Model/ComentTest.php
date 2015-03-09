<?php
App::uses('Coment', 'Model');

/**
 * Coment Test Case
 *
 */
class ComentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.coment',
		'app.users',
		'app.applications'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Coment = ClassRegistry::init('Coment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Coment);

		parent::tearDown();
	}

}
