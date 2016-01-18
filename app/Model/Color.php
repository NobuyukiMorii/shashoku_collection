<?php
App::uses('AppModel', 'Model');

class Color extends AppModel {

    public $name = 'Color';

    public $foreignKey = 'color_id';

}