<?php
App::uses('AppModel', 'Model');

class Restaurant extends AppModel {

    public $name = 'Restaurant';

    public $foreignKey = 'restaurant_id';

    public $shouldHave = array(
    	'Coupon', 'RestaurantsPhoto' ,'RestaurantsGenresRelation'
    );

}