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
		),
		'Coment' => array(
			'className' => 'Coment',
			'foreignKey' => 'applications_id',
			'dependent' => false,
			'conditions' => array('Coment.visible' => 1),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'categories_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'users_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
