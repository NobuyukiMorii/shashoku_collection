<?php
/**
 * 配列操作に関する関数群
 * 以下、呼び出し方法
 * ArrayControl::method_name(xx, yy);
 */	
class ArrayControl {

    //----------------------------------------
    //キーチェック系
    //----------------------------------------

    /**
     * 対象の変数の中身がemptyかどうかをチェックする
     * @param  string
     * @return array
     */  
    public function multipleEmptyCheck(){

        //返却値を設定
        $result = true;

        //引数を取得
        $variables = func_get_args();

        //引数がない場合
        if(empty($variables)){
            $result = false;
            return $result;
        }

        //配列をループ
        foreach ($variables as $variable) {

            //emptyの変数があった場合
            if(empty($variable)){
                $result = false;
            }

        }

        return $result;

    }

    /**
     * 対象のキー（複数）の中身がemptyかどうかをチェックする
     * @param  string
     * @return array
     */
    public function multipleHashEmptyCheck($msts, $key_names){

        //返却値を指定
        $result = true;

        //引数がない場合
        if(empty($msts) || empty($key_names)){
            //falseでリターン
            $result = false;
            return $result;
        }

        //配列をループ
        foreach ($key_names as $key => $key_name) {

            //１つでもemptyの場合
            if(empty($msts[$key_name])){
                $result = false;
            }

        }

        return $result;

    }


    //----------------------------------------
    //キー追加系
    //----------------------------------------

    /**
     * mst_Aに、対象のmst_Bの値を追加する
     * mst_Aにとmst_Bの第１キーが一致している場合に限る
     * target_keyは「xxx.yyy」形式でピリオド区切りで指定
     * @param  array  $mst_A
     * @param  array  $mst_B
     * @param  string $target_key
     * @return array
     */
    public function arrayMergeToTargetKey($mst_A, $mst_B, $target_key){

        //引数がない場合
        $flg = ArrayControl::multipleEmptyCheck($mst_A, $mst_B, $target_key);
        if($flg === false){
            return array();
        }

        /* $mst_Aに$mst_Bの値を追加する */
        foreach ($mst_A as $key => $value) {

            //$mst_Bに対象のデータがあれば
            if(!empty($mst_B[$key])){

                //結果を格納
                $result[$key] = Hash::insert($mst_A[$key], $target_key, $mst_B[$key]);
                
            } 

        }

        return $result;

    }

    /**
     * xxx_id等の外部キーを、対象の値に変換する
     * @param  array  $replace_data
     * @param  array  $source_data
     * @param  string $key_id_name
     * @param  string $replace_key_name
     * @return array
     */
    public function replaceIdToValue($replace_data, $source_data, $key_id_name, $replace_key_name){

        //キーを取り替えるデータをループする
        foreach ($replace_data as $key => $value) {

            //idと対応した値を格納する
            $replace_data[$key][$replace_key_name] = $source_data[$value[$key_id_name]][$replace_key_name];

            //idは削除する
            unset($replace_data[$key][$key_id_name]);

        }

        return $replace_data;

    }

    //----------------------------------------
    //キー削除系
    //----------------------------------------
    public function removeKeys($array, $key_array){

        //返却値を設定
        $result = array();

        //引数が不足している場合
        if(empty($array) || empty($key_array)){
            return $result;
        }

        $result = $array;

        //キーをループ
        foreach ($key_array as $key_name) {
            //キーを削除する
            $result = Hash::remove($result, '{n}.'.$key_name);
        }

        return $result;

    }

    //----------------------------------------
    //配列情報取得系
    //----------------------------------------

    /**
     * 連想配列の最後のキーを取得
     * @param  array  $array
     * @return array
     */
    public function endKey($array){

        end($array);

        return key($array);

    }

    /**
     * 配列の深さを取得
     * @param  array  $arr
     * @param  bool   $blank
     * @param  int    $depth
     */
    public function array_depth($arr, $blank=false, $depth=0){

        //配列ではない場合
        if( !is_array($arr)){

            //初期値の深さを返却
            return $depth;

        } else {

            //配列なので、深さの初期値は1
            $depth++;

            //trueならarray(array())などの場合にも2階層として扱う、falseなら0階層として扱う。
            $tmp = ($blank) ? array($depth) : array(0);

            //配列の深さを取得する
            foreach($arr as $value){
                $tmp[] = $this->array_depth($value, $blank, $depth);
            }

            return max($tmp);
        }
    }

    //----------------------------------------
    //配列キー取得系
    //----------------------------------------

    //この項目の関数は、Hash::系関数で代用出来るかも。

    /**
     * キーを限定して取得する（単数）
     * $keyはいくつでも指定可能
     * @param  array  $data
     * @param  string $key
     * @return array
     */
    public function extractTargetKey($data, $key_name){

        $result = array();

        //返却値を格納する
        foreach ($data as $key => $value) {

            $result[$key] = $value[$key_name];

        }

        return $result;

    }


    /**
     * キーを限定して取得する（複数）
     * $keyはいくつでも指定可能
     * @param  array  $data
     * @param  string $key
     * @return array
     */
    public function extractTargetKeys(){

        $result = array();

        //引数を取得
        $arguments = func_get_args();

        //引数の0番目は値を抽出する配列
        $data = $arguments[0];

        //対象のキー名を取得する
        for($i = 1; $i < count($arguments) ; $i++){

            $key_names[] = $arguments[$i];

        }

        //キー名の数を取得する
        $key_name_cnt = count($key_names);

        if($key_name_cnt === 1){

            //キー名が１つだけの場合
            if($key_name_cnt === 1){

                //対象のキーを抽出する
                $result = ArrayControl::extractTargetKey($data, $key_names[0]);

            } 

        } else {

            //対象のキーを格納する
            foreach ($data as $key => $value) {

                //キー名が複数の場合

                foreach ($key_names as $key_name) {

                    $result[$key][$key_name] = $value[$key_name];

                }

            }
        }

        return $result;


    }

    //----------------------------------------
    //数量取得系
    //----------------------------------------

	/**
	 * 対象のキーの値がいくつづつ配列に含まれるかを取得
	 * @param array $array
	 * @param string $target_key
	 * @return array
	 */
	public function getCountOfValueOfTargetKey($array, $target_key){

		//返却値を設定
    	$result = array();

    	//$arrayがない場合
    	if(empty($array)){
    		//空配列を返却
    		return $result;
    	}

    	//$target_keyがない場合
        if(empty($target_key)){
        	//空配列を返却
    		return $result;
    	}	

    	//arrayをループする
    	foreach ($array as $key => $value) {

    		//$target_keyのキーが返却値にあるかを判定

    		//ない場合
    		if(!isset($result[$value[$target_key]])){
    			//数量を1とする
    			$result[$value[$target_key]] = 1;
    		} else {
    		//ある場合
    			//インクリメントする
    			$result[$value[$target_key]]++;
    		}

    	}

    	return $result;

	}




}