<?php
App::uses('AppModel', 'Model');
/**
 * Application Model
 *
 * @property Version $Version
 */
class Application extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'main';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Version' => array(
			'className' => 'Version',
			'foreignKey' => 'application_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'version',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
