<?php
App::uses('AppModel', 'Model');

class Menu extends AppModel {

    public $name = 'Menu';

    public $foreignKey = 'menu_id';

}