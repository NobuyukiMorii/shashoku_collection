<?php
App::uses('AppModel', 'Model');

class SetMenu extends AppModel {

    public $name = 'SetMenu';

    public $foreignKey = 'set_menu_id';

    public $shouldHave = array(
    	'SetMenusPhoto'
    );

}