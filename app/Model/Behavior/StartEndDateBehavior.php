<?php
/**
 * 期限内判定系クラス
 * 'start_date'と'end_date'に関わる関数を集約するため関数
 */
class StartEndDateBehavior extends ModelBehavior {

    /**
     * 'start_date'と'end_date'の両方のキーが配列に存在するかを確認
     */ 
    public function checkStartAndEndDateKey(Model $model, $array){

        //引数がない場合
        if(empty($array)){
            //falseを返却
            return false;
        }

        //'start_date'が存在するかを確認
        $is_start_date_key_existence    = array_key_exists('start_date', $array);

        //'end_date'が存在するかを確認
        $is_end_date_key_existence      = array_key_exists('end_date', $array);

        //'start_date'も'end_date'も存在する場合
        if($is_start_date_key_existence === true && $is_end_date_key_existence === true){
            //trueを返却
            return true;
        } else {
            return false;
        }

    }

    /**
     * 現在の日時が、引数のstart_dateとend_dateの範囲内であるかを判定
     * 範囲内であればtrue、範囲外であればfalse
     */ 
    public function checkTodayIsInPeriod(Model $model, $start_date=NULL, $end_date=NULL){

        //返却値の初期値の設定
        $result = false;

        //引数の確認
        if(is_null($start_date) || is_null($end_date)){
            //引数が不足している場合には、falseで返却
            return $result;
        }

        //本日の日付を取得する
        $now    =   date("Y-m-d H:i:s");

        //期間内ならtrueで返却
        if ($start_date < $now && $end_date > $now) {
            $result = true;
        } else {
            //期間外ならfalseで返却
            $result = false;
        }

        //値を返却
        return $result;

    }

    /**
     * start_dateとend_dateの範囲内のレコードのみを抽出する
     * 配列内にstart_dateとend_dateが含まれている時のみ利用可能
     */ 
    public function extractRecordInPeriod(Model $model, $data){

        //返却値を設定
        $result = array();

        //レコードをループ
        foreach ($data as $key => $value) {

            //キーにstart_dateとend_dateが含まれているかを確認
            $flg = $this->checkStartAndEndDateKey($model, $value);

            //ない場合
            if($flg === false){
                //ループをスキップする
                continue;
            }

            //$data内のレコードが、start_dateとend_date内であるかを判定
            $is_in_period = $this->checkTodayIsInPeriod($model, $value['start_date'], $value['end_date']);

            //start_dateとend_date内であれば
            if($is_in_period === true){
                //返却値にレコードを格納
                $result[$key] = $value;
            }

        }

        return $result;

    }

}