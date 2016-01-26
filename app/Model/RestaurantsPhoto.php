<?php
App::uses('AppModel', 'Model');

class RestaurantsPhoto extends AppModel {

    public $name = 'RestaurantsPhoto';

    public $foreignKey = 'restaurants_photo_id';

}