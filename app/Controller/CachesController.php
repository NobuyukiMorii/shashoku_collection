<?php
class CachesController extends AppController {

	//viewをjsonで返却
	public $view_json_flag = true;

    //コンポーネントをロード
    public $components = array(
        'Caches',
        'Common'
    );

    /**
     * キャッシュフォルダの一覧取得
     * @return array
     */
    public function getFolders(){

        //フォルダの一覧を取得
        $result = $this->Caches->getFolders();

        //結果を格納
        $this->view_data['result'] = $result;

        return $result;

    }

    /**
     * モデルキャッシュの一覧取得api
     * @return array
     */
    public function listByFolder($cache_folder_name=null) {

        //返却値を定義
        $result = array();

        //キーを取得
        if(empty($cache_folder_name)){
           $cache_folder_name = Arguments::getArguments('cache_folder_name');
        }

        //フォルダ名の指定がない場合
        if(empty($cache_folder_name)){

            //エラー情報を格納
            $this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('キャッシュフォルダが指定されていません。'));

            //結果を格納
            $this->view_data['result'] = $result;

            return $result;

        }

        //ファイル一覧を取得
        $result = $this->Caches->listByFolder($cache_folder_name);

        //view_dataを返却
        $this->view_data['result'] = $result;

        return $result;

    }

	/**
	 * キャッシュファイルの全削除
	 * @return array
	 */
    public function clearAll() {

        //キャッシュファイルを全て削除
        $flg = $this->Caches->clearAll();

    	//view_dataを返却
    	$this->view_data['result'] = $flg;

    	return $flg;

    }

	/**
	 * ファイルの１件削除
	 * @return array
	 */
    public function clearOne($cache_folder_name=null, $file_name=null) {

        //返却値を定義
        $result = false;

    	//引数を取得
        if(empty($cache_folder_name)){
           $cache_folder_name = Arguments::getArguments('cache_folder_name');
        }

        if(empty($file_name)){
    	   $file_name = Arguments::getArguments('file_name');
        }

        //引数が設定されていない場合
    	if(empty($cache_folder_name) || empty($file_name)){

            //エラー情報を格納
            $this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('引数が指定されていません。'));

            //結果を格納
            $this->view_data['result'] = $result;

            return $result;

    	}

        //対象キャッシュファイルを削除
        $result = $this->Caches->clearOne($cache_folder_name, $file_name);

        //対象のファイルがない場合
        if($result === false){

            //エラー情報を格納
            $this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('対象のキャッシュファイルがありません。'));

        } 

        //view_dataを返却
        $this->view_data['result'] = $result; 

    	return $result;

    }

    /**
     * 指定のフォルダのキャッシュを削除
     * @param  string 
     * @return array
     */
    public function clearByFolder($cache_folder_name=null){

        //返却値を定義
        $result = false;

        //キーを取得
        if(empty($cache_folder_name)){
           $cache_folder_name = Arguments::getArguments('cache_folder_name');
        }

        //フォルダ名の指定がない場合
        if(empty($cache_folder_name)){

            //エラー情報を格納
            $this->Common->returnError(Configure::read('ERR_CODE_NO_PARAM'), __('キャッシュフォルダが指定されていません。'));

            //結果を格納
            $this->view_data['result'] = $result;

            return $result;

        }

        //フォルダ名でキャッシュを削除
        $result = $this->Caches->clearByFolder($cache_folder_name);

        if($result === false){
            //エラー情報を格納
            $this->Common->returnError(Configure::read('ERR_CODE_NO_DATA'), __('対象のキャッシュフォルダがありません。')); 
        }

        //結果を格納
        $this->view_data['result'] = $result;

        return $result;   

    }

}