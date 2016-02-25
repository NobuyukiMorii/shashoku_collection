<?php
App::uses('Component', 'Controller');

/**
 * キャッシュに関する関数を集約する
 */
class CachesComponent extends Component {

    //----------------------------------------
    //キャッシュのメイン機能
    //----------------------------------------

    /**
     * キャッシュを読む
     * @param  strin $path
     * @param  strin $name 
     * @return array
     */
    public function read($path, $name){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(empty($path) || empty($name)){
            return $result;
        }

        //キャッシュのパスを指定する 
        Cache::set(array('path' => $path));

        //キャッシュを取得する
        $result = Cache::read($name);

        return $result;

    }

    /**
     * キャッシュを読む
     * @param  strin $path
     * @param  strin $name 
     * @return array
     */
    public function write($path, $name, $data, $duration){

        //返却値を設定
        $result = array();

        //引数がない場合
        if(empty($path) || empty($name) || empty($data)){
            return $result;
        }

        //キャッシュの有効期限がない場合
        if(empty($duration)){
            //1年
            $duration = 31536000;
        }

        //キャッシュの有効期限を指定する
        Cache::set(array('path' => $path, 'duration' => '+'.$duration.' seconds'));

        //キャッシュに記録する
        $result = Cache::write($name, 'true');

        return $result;

    }

	/**
	 * キャッシュのフォルダのパスを取得
	 * @param  string $cache_folder_name
	 * @return array
	 */
    public function getCacheFolderPathByName($cache_folder_name, $func_name=null) {

    	$result = "";

    	//引数がない場合
    	if(empty($cache_folder_name)){
    		return $result;
    	}

        //パスを取得
        switch ($cache_folder_name) {
            case 'master':
                $result = CACHE_MASTER;
                break;
            case 'models':
                $result = CACHE_MODELS;
                break;
            case 'persistent':
                $result = CACHE_PERSISTENT;
                break;
            case 'views':
                $result = CACHE_VIEW;
                break;
            case 'transaction':
                $result = CACHE_USERS_TRANSACTION;
                break;
        }

        //関数名がある場合
        if(isset($func_name)){
            $result = $result.$func_name.'/';
        }

        return $result;

    }

	/**
	 * キャッシュファイルの全削除
	 * @return array
	 */
    public function clearAll(){

    	$result = true;

    	//キャッシュの種類を取得
    	$config_list = Cache::configured();

    	//種類をループ
        foreach ($config_list as $value) {

        	//キャッシュをクリア
			$tmp_flg = Cache::clear(false, $value);

			if($tmp_flg === false){
				//クリアに一度でも失敗した場合
				$result = false;
			}

        }

        return $result;

    }

	/**
	 * キャッシュファイルの１件削除
	 * @param  string $cache_folder_name
	 * @param  string $file_name
	 * @return array
	 */
    public function clearOne($cache_folder_name, $file_name, $func_name=null){

    	//返却値を設定
    	$result = false;

    	//引数がない場合
    	if(empty($cache_folder_name) || empty($file_name)){
    		return $result;
    	}

        //フォルダのパスを取得
        $folder_path = $this->getCacheFolderPathByName($cache_folder_name, $func_name);
        //フォルダのパスが取得出来ない場合
        if(empty($folder_path)){
        	return $result;
        }

        //ファイルまでの絶対パスを生成
        $path = $folder_path.$file_name;

        //削除対象のファイルをnew
        $file = new File($path);

        //ファイルを削除
        $result = $file->delete();

        return $result;

    }

	/**
	 * フォルダ内のキャッシュ一覧表示
	 * @param  string $cache_folder_name
	 * @return array
	 */
    public function listByFolder($cache_folder_name){

    	//返却値を設定
    	$result = array();

    	//引数がない場合
    	if(empty($cache_folder_name)){
    		return $result;
    	}

        //フォルダのパスを取得
        $folder_path = $this->getCacheFolderPathByName($cache_folder_name);
        //フォルダのパスが取得出来ない場合
        if(empty($folder_path)){
        	return $result;
        }

        //ディレクトリをnew
        $dir = new Folder($folder_path);

        //ディレクトリ情報を取得（結果をアルファベット順にソート・ファイル名のみ）
        $dir_info = $dir->read(true,true);

        //ファイル情報を抽出
        $result = $dir_info[1];

        return $result;


    }

	/**
	 * キャッシュフォルダの一覧表示
	 * @return array
	 */
    public function getFolders(){

        //ディレクトリをnew
        $dir = new Folder(CACHE);

        //ディレクトリ情報を取得（結果をアルファベット順にソート・フォルダ名のみ）
        $dir_info = $dir->read(true,true);

        //フォルダ名のみ抽出
        $result = $dir_info[0];

        return $result;

    }

	/**
	 * フォルダのファイルを削除
	 * @param  strin $cache_folder_name
	 * @return array
	 */
    public function clearByFolder($cache_folder_name){

    	//返却値を設定
    	$result = false;

    	//引数がない場合
    	if(empty($cache_folder_name)){
    		return $result;
    	}

        //フォルダのパスを取得
        $folder_path = $this->getCacheFolderPathByName($cache_folder_name);
        //フォルダのパスが取得出来ない場合
        if(empty($folder_path)){
        	return $result;
        }

        //ディレクトリをnew
        $dir = new Folder($folder_path);

        //ディレクトリごと削除
        $flg = $dir->delete();
        if($flg === false){
        	return $result;
        }

        //新しくいディレトリをnew
        $new_dir = new Folder();

        //ディレクトリを生成
        $flg = $dir->create($folder_path);
        if($flg === false){
        	return $result;
        }

        //ここまでエラーがなければtrueとする
        $result = true;

    	return $result;


    }

}