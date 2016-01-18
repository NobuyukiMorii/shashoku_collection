<?php
App::uses('AppModel', 'Model');

class Coupon extends AppModel {

    public $name = 'Coupon';

    public $foreignKey = 'coupon_id';

    public $shouldBelongsTo = array(
    	'SetMenu'
    );

}