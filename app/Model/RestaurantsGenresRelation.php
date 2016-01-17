<?php
App::uses('AppModel', 'Model');

class RestaurantsGenresRelation extends AppModel {

    public $name = 'RestaurantsGenresRelation';

    public $foreignKey = 'restaurants_genres_relation_id';

}