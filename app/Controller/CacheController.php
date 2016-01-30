<?php
class CacheController extends AppController {

	//viewをjsonで返却
	public $view_json_flag = true;

	/**
	 * ファイルの全削除
	 * @return array
	 */
    public function clear_all_cache() {

    	//キャッシュの種類を取得
    	$config_list = Cache::configured();

    	//種類をループ
        foreach ($config_list as $value) {
        	//キャッシュをクリア
			Cache::clear(false, $value);

        }

        //viewキャッシュを削除
        clearCache();

    	//view_dataを返却
    	$this->view_data['result'] = 1;

    	return 1;

    }

	/**
	 * ファイルの１件削除
	 * @return array
	 */
    public function clear_one_cache() {

    	//キーを取得
    	$key = Arguments::getArguments('key');
    	if(empty($key)){

    	}

    	//キャッシュを削除
    	var_dump($key);
		$flg = Cache::delete($key);    	
		var_dump($flg);exit;
    	//view_dataを返却
    	$this->view_data['result'] = 1;

    	return 1;

    }
    
    
	/**
	 * モデルキャッシュの一覧取得api
	 * @return array
	 */
    public function list_table_cache() {

    	//ファイルのパスを取得
    	$cache_file_path = $_SERVER['DOCUMENT_ROOT'].'/shashoku_collection/app/tmp/cache/models/*';

    	//ファイルを取得
    	$cache_files = glob($cache_file_path);

    	//ファイル名を抽出
    	foreach ($cache_files as $key => $value) {

    		$result[$key] = basename($value);

    	}

    	//view_dataを返却
    	$this->view_data['result'] = $result;

    	return 1;

    }









}