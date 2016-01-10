<?php
class RestaurantsController extends AppController {

	public $uses = array('Restaurant', 'Coupon', 'CouponsMenusRelation', 'Menu', 'RestaurantsGenre', 'RestaurantsGenresRelation', 'RestaurantsTag', 'RestaurantsTagsRelation', 'RestaurantsImagesPhoto', 'RestaurantsImagesMap');

	/**
	*  レストラン一覧表示
	*
	* 【店舗一覧】
	*  レストランに付加する情報は、店名・クーポン名・メニュー名・ジャンル・タグ・店舗の写真・地図の写真。
	*  クーポンが複数ある場合には、メインのクーポンのみ画面に表示させ、「他2つ」等と表示。
	*
	* 【運営からのお知らせ】
	*  運営からのお知らせが存在するかどうかを判定し、viewに送信。
	*
	*/
    public function index() {

        //----------------------------------------
        //レストランをrestaurantsテーブルから全て取得（キャッシュ）
        //----------------------------------------

    	$restaurants = $this->Restaurant->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //クーポンをcouponsテーブルから全て取得（キャッシュ）
        //----------------------------------------

    	$coupons = $this->Coupon->find('all', array(
    		'cache' => true
    	));

		//クーポンの情報を$restaurantsの配列内に追加する
    	foreach ($coupons as $key => $value) {

    		//クーポンのidを追加する
    		$restaurants[$value['restaurant_id']]['coupons'][$value['priority_order']]['id'] 		= $value['id'];

    		//クーポンの価格を追加する
    		$restaurants[$value['restaurant_id']]['coupons'][$value['priority_order']]['price']		= $value['price'];

    	}

    	//クーポンのないレストランがあった場合、レストラン情報を返却値から除外する
    	foreach ($restaurants as $key => $value) {
    		//レストランに対応したクーポンがない場合
    		if(empty($value['coupons'])){
    			//レストラン情報を削除
    			unset($restaurants[$key]);
    			//エラーログを出力
    			$this->log("\n\ndate:" . date('Y-m-d H:i:s'). "\nfile:".__FILE__."\nmethod:".__METHOD__."\nline:".__LINE__."\nmessage:restaurant_id". $value['id'].' に対応するクーポンがありません。', 'original');
    			//ループをスキップ
    			continue;
    		}
    	}

        //----------------------------------------
        //クーポンとメニューの関係性をcoupons_menus_relationsテーブルから全て取得（キャッシュ）
        //----------------------------------------

    	$coupons_menus_relations = $this->CouponsMenusRelation->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //メニューをmenusテーブルから全て取得（キャッシュ）
        //----------------------------------------

    	$menus = $this->Menu->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //メニュー情報をレストランに追加
        //----------------------------------------

    	//クーポンとメニューの関係性をまとめた配列を作成
    	foreach ($coupons_menus_relations as $key => $value) {
    		//クーポンidを１つ目のキーに、クーポンの優先順位を２つ目のキーとする
    		$tmp_coupons_menus_relations[$value['coupon_id']][$value['priority_order']]['menu_id'] 		= $value['menu_id'];
    		$tmp_coupons_menus_relations[$value['coupon_id']][$value['priority_order']]['menu_name'] 	= $menus[$value['menu_id']]['name'];
    		$tmp_coupons_menus_relations[$value['coupon_id']][$value['priority_order']]['description'] 	= $menus[$value['menu_id']]['description'];
    	}

    	//レストランのクーポン情報に、メニューidを追加する
    	foreach ($restaurants as $key => $value) {

    		//レストランに対応したクーポンがある場合
    		if(!empty($restaurants[$key]['coupons'])){
    			//クーポンの配列をループし、メニューidを追加する
	    		foreach ($value['coupons'] as $coupon_key => $coupons_value) {
	    			//クーポンとメニューの関係性の配列に、クーポンidに対応した値が格納されていない場合
	    			if(empty($tmp_coupons_menus_relations[$coupons_value['id']])){
    					//エラーログを出力
    					$this->log("\n\ndate:" . date('Y-m-d H:i:s'). "\nfile:".__FILE__."\nmethod:".__METHOD__."\nline:".__LINE__."\nmessage:restaurant_id". $value['id'].' に対応するクーポンがありません。', 'original');
	    				continue;
	    			}

	    			//メニューidを追加する
	    			$restaurants[$key]['coupons'][$coupon_key]['menus'] = $tmp_coupons_menus_relations[$coupons_value['id']];

	    		}
	    	} else {
	    	//レストランに対応したクーポンがない場合
    			//レストラン情報を削除
    			unset($restaurants[$key]);
    			//エラーログを出力
    			$this->log("\n\ndate:" . date('Y-m-d H:i:s'). "\nfile:".__FILE__."\nmethod:".__METHOD__."\nline:".__LINE__."\nmessage:restaurant_id". $value['id'].' に対応するクーポンがありません。', 'original');
    			//ループをスキップ
    			continue;
	    	}

    	}


        //----------------------------------------
        //ジャンルをrestaurants_genreテーブルから全て取得（キャッシュ）
        //----------------------------------------
        
    	$restaurants_genres = $this->RestaurantsGenre->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //レストランとジャンルの関係性をrestaurants_genres_relationsテーブルから全て取得（キャッシュ）
        //----------------------------------------

    	$restaurants_genres_relations = $this->RestaurantsGenresRelation->find('all', array(
    		'cache' => true
    	));

    	foreach ($restaurants_genres_relations as $key => $value) {
    		$tmp_restaurants_genres_relations[$value['restaurant_id']][] = $value['resaurant_genre_id'];
    	}

    	pr($restaurants);
    	exit;


        //----------------------------------------
        //ジャンル情報をレストランに追加
        //----------------------------------------





        //----------------------------------------
        //タグをrestaurants_tags_relationテーブルから全て取得（キャッシュ）
        //----------------------------------------
        
    	$restaurants_tags_relation = $this->RestaurantsTagsRelation->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //タグをrestaurants_tagsテーブルから全て取得（キャッシュ）
        //----------------------------------------
        
    	$restaurants_tags = $this->RestaurantsTag->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //店舗の写真から全て取得（キャッシュ）
        //----------------------------------------
        
    	$restaurant_images_photos = $this->RestaurantsImagesPhoto->find('all', array(
    		'cache' => true
    	));

        //----------------------------------------
        //地図画像を全て取得（キャッシュ）
        //----------------------------------------
        
    	$restaurant_images_maps = $this->RestaurantsImagesMap->find('all', array(
    		'cache' => true
    	));








    }

    public function detail() {

    }

}