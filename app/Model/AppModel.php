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

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /*
     * Findの検索結果を変換
     * ・model名を削除
     * ・削除済みレコードを削除
     * ・del_flgカラムの値を削除する
     * ・主キーを配列のキーとする
     */
    public function afterFind($results, $primary = false) {

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
             if($results[0]['del_flg'] === Configure::read("RECORD_DELETED")){
                /* 空の配列を返却 */
                return array();
             }

             /* キーのdel_flgとその値を削除する */
             unset($results[0]['del_flg']);

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
