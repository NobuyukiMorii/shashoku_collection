<?php
App::uses('AppModel', 'Model');

class RestaurantsGenre extends AppModel {

    public $name = 'RestaurantsGenre';

    public $foreignKey = 'restaurants_genre_id';

}