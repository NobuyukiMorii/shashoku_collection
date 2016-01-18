<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/* アプリケーション全体で利用出来る関数をロード */
App::uses('Util', 'Vendor');
App::uses('ArrayControl', 'Vendor');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /* モデルの共通関数を集約するbehaviorロード */
    public $actsAs = array(
        'Common', 
        'CompleteRecords', 
        'StartEndDate', 
        'PriorityOrder'
    );

    /* Findのタイプを格納するメンバ変数 */
    protected $find_type = null;

    /*
     * Findで生成・利用するファイルキャッシュ名を生成する。
     * Findの種類と検索条件をアンダースコアで繋ぎ、ファイル名を生成する。
     */
    protected function generateCacheName($type, $params){

        /* $paramsの中のキャッシュを削除する */
        unset($params['cache']);

        /* $paramsのキーをアルファベットの小文字に変換する */
        $params = array_change_key_case($params);

        /* 多次元配列を１次限配列に変換する */
        $params = Hash::flatten($params);

        /* キーをアルファベットの昇順に変換する */
        ksort($params);

        /* $paramsをアンダースコアで文字列連結する */
        $cacheName = "";
        foreach ($params as $key => $value) {
            if(empty($value)){
                $value = "null";
            }
            $cacheName .= $key."_".$value."_";
        }

        /* ドットをアンダースコアに変換する */
        $cacheName = str_replace('.', '_', $cacheName);

        /* モデル名_Findのタイプ_$paramsの形式で文字列連結をする */
        $cacheName = $this->name . '_' . $type . '_' . $cacheName;

        /* 文字列から半角スペースと全角スペースを除去する */
        $cacheName  = preg_replace("/( |　)/", "", $cacheName );

        return $cacheName;

    }


    /*
     * Findでキャッシュを指定出来るように変更
     * $paramsの中にcachを指定することで、利用出来る。
     * 検索条件がキャッシュファイル名となる。
     */
    function find($type = null, $params = array()) {

        $doQuery = true;

        /* キャッシュを使う場合 */
        if (!empty($params['cache'])) {

            /* キャッシュ名を生成する */
            $cacheName = $this->generateCacheName($type, $params);

            /* キャッシュのパスを指定する */
            Cache::set(array('path' => CACHE."models/"));

            /* キャッシュを取得する */
            $data = Cache::read($cacheName);

            /* キャッシュがない場合 */
            if ($data == false) {

                /* Findで検索する */
                $data = parent::find($type, $params);

                /* キャッシュのパスを指定する */
                Cache::set(array('path' => CACHE."models/"));

                /* 結果をキャッシュに記録する */
                Cache::write($cacheName, $data);

            }
            /* Queryを発行させない */
            $doQuery = false;
        }
        /* キャッシュを使わない場合 */
        if ($doQuery) {

            $data = parent::find($type, $params);

        }
        return $data;
    }

    public function beforeFind($query){

        /* Find('list')で検索した場合 */
        if(!empty($query['list'])){
            $this->find_type = "list";
        }

    }

    /*
     * Findの検索結果を変換
     * ・model名を削除
     * ・削除済みレコードを削除
     * ・del_flgカラムの値を削除する
     * ・主キーを配列のキーとする
     */
    public function afterFind($results, $primary = false) {

        /* --------------- 空の配列の場合、処理せずに返却 ----------------------- */
        if(empty($results)){
            return $results;  
        }

        /* --------------- find('list')で検索された場合にはそのまま返却 --------- */
        if($this->find_type === 'list'){
            return $results;
        }

        /* --------------- 配列の構造を判定する ------------------------------- */
        if(isset($results[0][0])){

            /* Countで取得された場合 */
            $data_type = "array_double_count";

        } else if(count($results) === 1){

            /* Findの結果が１つのキーを持つ配列の場合 */
            $data_type = "array_cnt_one";

        } else if(count($results) > 1){

            /* Findの結果が複数のキーを持つ配列の場合 */
            $data_type = "array_cnt_multiple";

        }

        /* --------------- Countで取得された場合 ------------------------------ */
        if($data_type === "array_double_count"){
            /* 引数と同じ値を返却 */
            return $results;

        }

        /* --------------- Findの結果が１つor複数のキーを持つ配列の場合 ---------- */
        /* Findの戻り値からモデル名を削除 */
        $results = Hash::extract($results,'{n}.'.$this->name);

        /* --------------- Findの結果が１つのキーを持つ配列の場合 --------------- */
        if($data_type === "array_cnt_one"){

            /* 削除済みレコードの場合 */
            if(isset($results[0]['del_flg'])){

                if($results[0]['del_flg'] === Configure::read("RECORD_DELETED")){
                   /* 空の配列を返却 */
                   return array();
                }

                /* キーのdel_flgとその値を削除する */
                unset($results[0]['del_flg']);
            }

            return $results;
        }  


        /* --------------- Findの結果が複数のキーを持つ配列の場合 --------------- */
        foreach ($results as $key => $value) {

            /* 削除済みレコードを削除する */
            if(array_key_exists('del_flg', $value)){

                 /* 削除済みのレコードの場合 */
                if($value['del_flg'] === Configure::read("RECORD_DELETED")){
                    /* 処理をスキップする */
                    continue;
                }

                /* キーのdel_flgとその値を削除する */
                unset($value['del_flg']);
            }

            /* 返却値のキーを、カラムのidに変更する */
            //主キーを設定
            $primary_key = $this->primaryKey;

            //主キーをキーとして、結果を格納する
            $new_results[$value[$primary_key]] = $value;

        }

        return $new_results;


    }

}
