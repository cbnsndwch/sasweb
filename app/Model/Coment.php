<?php
App::uses('AppModel', 'Model');
/**
 * Coment Model
 *
 * @property Users $Users
 * @property Applications $Applications
 */
class Coment extends AppModel {

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
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'users_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		// 'Application' => array(
		// 	'className' => 'Application',
		// 	'foreignKey' => 'applications_id',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => ''
		// )
	);
}
