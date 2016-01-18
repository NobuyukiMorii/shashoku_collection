<?php
/**
 * 他テーブルとの整合性を確認し、誤りがあった場合にレコードを削除するための関数群
 */
class CompleteRecordsBehavior extends ModelBehavior {

    /**
     * 不完全なレコードを削除
     * $mst_Aが、必ず、$mst_Bのレコードに属していなければならないのに、そのレコードが存在しない場合
     * $mst_Aの該当のレコードを削除する
     */ 
    public function removeIncompleteRecords_ShouldBelongsTo(Model $model, $mst_A, $mst_B, $should_belongs_to_foreign_key, $file=NULL, $method=NULL, $line=NULL){

        //ファイル名がない場合
        if(is_null($file)){
            $file = __FILE__;
        }

        if(is_null($method)){
            $method = __METHOD__;
        }

        if(is_null($line)){
            $line = __LINE__;
        }

        //$mst_Aをループする
        foreach ($mst_A as $key => $value) {

            //属する対象のデータがない場合
            if(empty($mst_B[$value[$should_belongs_to_foreign_key]])) {

                //$mmt_Aのデータを削除する
                unset($mst_A[$key]);

            }


        }

        return $mst_A;

    }


    /**
     * 不完全なレコードを削除
     * $mst_Aが、必ず、$mst_Bのレコードを所持しなければならないのに、そのレコードが存在しない場合
     * $mst_Aの該当のレコードを削除する
     */ 
    public function removeIncompleteRecords_ShouldHave(Model $model, $mst_A, $mst_B, $foreign_key, $file=NULL, $method=NULL, $line=NULL){

        //ファイル名がない場合
        if(is_null($file)){
            $file = __FILE__;
        }

        if(is_null($method)){
            $method = __METHOD__;
        }

        if(is_null($line)){
            $line = __LINE__;
        }

        //mst_Bで使われているmst_Aの一覧
        foreach ($mst_B as $key => $value) {
            $mst_A_ids[] = $value[$foreign_key];
        }

        //重複したmst_Aのidを除去する
        $mst_A_ids = array_unique($mst_A_ids);

        //キーを振りなおす
        $mst_A_ids = array_values($mst_A_ids);

        //mst_Aがmst_Bに使われていない場合
        foreach ($mst_A as $key => $value) {
            //セットメニューに対応したクーポンがあるかを判定
            $flg = in_array($value['id'], $mst_A_ids);

            //ない場合
            if($flg === false){

                //エラーログを出力
                $message = $foreign_key."が不整合のため、".$model->useTable."テーブルから取得したレコードからid=".$mst_A[$key]['id']."を除去しました。";
                Util::OriginalLog($file, $method, $line, $message);

                //使われていないmst_Aを除外
                unset($mst_A[$key]);
            }
        }

        return $mst_A;

    }

}