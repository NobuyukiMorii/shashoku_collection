<?php
App::uses('AppModel', 'Model');

class RestaurantsTagsRelation extends AppModel {

    public $name = 'RestaurantsTagsRelation';

    public $foreignKey = 'restaurants_tags_relation_id';

}