<?php
App::uses('AppModel', 'Model');
/**
 * Data Model
 *
 */
class Data extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'main';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'datas';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'inList' => array(
				'rule' => array('inList', array('other','data','obb-path','obb-main')),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
