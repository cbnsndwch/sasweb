<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Noticy $Noticy
 * @property Upload $Upload
 */
class User extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'main';

    public $displayField = 'username';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Noticy' => array(
			'className' => 'Noticy',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'user_id',
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

	public $validate = array(
		'password' => array(
			'Not Empty' => array(
				'rule' => 'notEmpty',
				'messsage' => 'Debe escribir la clave.'
				),
			'Match_Password' => array(
				'rule' => 'matchPassword',
				'message' => 'Las claves deben coincidir.'
				)
			),
		'password_confirmation' => array(
			'Not Empty' => array(
				'rule' => 'notEmpty',
				'messsage' => 'Por favor confirme la clave.'
				)
			),
		);

	public function matchPassword($data){//debug($this->data);
		if($data['password'] == $this->data['User']['password_confirmation']){
			return true;
		}
		$this->invalidate('password_confirmation', 'Las claves deben coincidir.');
		return false;
	}

	public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }        
        return true;
    }

}
