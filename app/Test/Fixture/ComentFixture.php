<?php
/**
 * ComentFixture
 *
 */
class ComentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'users_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'applications_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'coment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'visible' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'users_id' => 1,
			'applications_id' => 1,
			'coment' => 'Lorem ipsum dolor sit amet',
			'ip' => 'Lorem ipsum dolor sit amet',
			'created' => '2015-03-09 17:34:19',
			'visible' => 1,
			'modified' => '2015-03-09 17:34:19'
		),
	);

}
