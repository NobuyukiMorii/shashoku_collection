<?php
App::uses('AppModel', 'Model');

class RestaurantsTag extends AppModel {

    public $name = 'RestaurantsTag';

    public $foreignKey = 'restaurants_tag_id';

}