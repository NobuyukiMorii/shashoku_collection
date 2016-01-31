<?php
App::uses('AppModel', 'Model');

class Company extends AppModel {

    public $name = 'Company';

    public $foreignKey = 'company_id';

}