<?php
App::uses('AppModel', 'Model');
/**
 * Version Model
 *
 * @property Application $Application
 */
class Version extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'main';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	// public $belongsTo = array(
	// 	'Application' => array(
	// 		'className' => 'Application',
	// 		'foreignKey' => 'application_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => 'version'
	// 	)
	// );
}
