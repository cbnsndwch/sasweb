<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'main';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $hasMany = array(
		'Application' => array(
			'className' => 'Application',
			'foreignKey' => 'categories_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
