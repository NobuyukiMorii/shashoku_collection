<?php
/**
 * 優先順位クラス
 * 'priority_order'をキーに持つ配列を操作する関数を集約
 */
class PriorityOrderBehavior extends ModelBehavior {

    /**
     * 優先順位の一番高いレコードを取得する
	 * @param array  $array
	 * @param string $key_name
	 * @return array
     */
	public function getPrimaryRecord(Model $model, $array){

		//返却値を設定
		$result = array();

		//引数がない場合
		if(empty($array)){
			return $result;
		}

		//優先順位順に並べ替える
		$result = Hash::sort($array, '{n}.priority_order', 'asc');

		$result = $result[0];

		return $result;

	}

    /**
     * 対象のキーごとに、優先順位の一番高いレコードを取得する
	 * @param array  $array
	 * @param string $key_name
	 * @return array
     */ 
	public function getPrimaryRecordOfEachKey(Model $model, $array, $key_name){

		//返却値を設定
		$result = array();

    	//引数チェック
    	$flg = ArrayControl::multipleEmptyCheck($array, $key_name);
    	if($flg === false) {
    		return $result;
    	}

		//配列をループする
		foreach ($array as $key => $value) {

			//配列内にpriority_orderが存在するかをチェック
			$flg = array_key_exists('priority_order', $value);
			if($flg === false){
				continue;
			}

			//返却値にキーがない場合は
			if(empty($result[$value[$key_name]])){
				//キーと値を格納
				$result[$value[$key_name]] = $value;
			}

			//priority_orderが小さい場合に、値を格納
			if($value['priority_order'] < $result[$value[$key_name]]['priority_order']){
				//キーと値を格納
				$result[$value[$key_name]] = $value;
			}

		}

		return $result;

	}

    /**
     * 対象のキーごとに、優先順位が高いレコードから順に取得する
	 * @param array  $array
	 * @param string $key_name
	 * @return array
     */ 
	public function getPrimaryRecordsOfEachKey(Model $model, $array, $key_name, $max_count){

		//返却値を設定
		$result = array();
		
    	//引数チェック
    	$flg = ArrayControl::multipleEmptyCheck($array, $key_name, $max_count);
    	if($flg === false) {
    		return $result;
    	}

		//配列をループする
		foreach ($array as $key => $value) {

			//配列内にpriority_orderが存在するかをチェック
			$flg = array_key_exists('priority_order', $value);
			if($flg === false){
				continue;
			}

			//優先順位をキーにして配列を格納
			$tmp[$value[$key_name]][$value['priority_order']] = $value;

			//優先順位順の照昇順に並び替え
			ksort($tmp[$value[$key_name]]);

		}

		//一時的に格納した配列をループ
		foreach ($tmp as $tmp_key => $tmp_value) {

			//配列内で再度ループ
			foreach ($tmp_value as $tmp2_value) {

				//それぞれの、key_nameにいくつづつ$valueがあるかを取得
				if(empty($result[$tmp_key])){
					$result_count = 0;	
				} else {
					$result_count = count($result[$tmp_key]);
				}
				
				//既に配列が、max_count以上ある場合
				if($result_count >= $max_count){
					//スキップ
					continue;
				}

				//返却値に配列を格納
				$result[$tmp_key][$tmp2_value['priority_order']] = $tmp2_value;

			}

		}

		return $result;

	}

}