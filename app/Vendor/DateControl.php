<?php
/**
 * 日付操作に関する関数群
 * 以下、呼び出し方法
 * DateControl::method_name(xx, yy);
 */	
class DateControl {

	/**
	 * 引数の日付が本日の日付かどうかをチェック
	 * @param  string $date
	 * @return bool
	 */
	public function checkInToday($date) {

		$result = false;

		//引数がない場合
		if(empty($date)){
			return $result;
		}

        //本日の00:00:00
        $date_time['today_start'] 		= strtotime(date('Y-m-d 00:00:00'));

        //明日の00:00:00
        $date_time['tomorrow_start']	= strtotime(date('Y-m-d 00:00:00', strtotime("+1 day")));

        //対象の時間
        $date 							= strtotime($date);

        //更新日が本日の場合
        if($date >= $date_time['today_start'] && $date < $date_time['tomorrow_start']) {
        	$result = true;
        } 

        return $result;

	}

}