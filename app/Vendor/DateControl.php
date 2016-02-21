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


	/**
	 * 年月のリストを取得
	 * @param  string $date
	 * @return bool
	 */
	public function getMonthYearList($start_date=null, $list_count=null, $order=null) {

		//返却値
		$result = array();

		//開始年月がない場合
		if(is_null($start_date)){
			//指定がない場合は現在の月
			$start_date = date('Y-m-d');
		}

		//返却数がない場合
		if(is_null($list_count)){
			//指定がない場合は1ヶ月分
			$list_count = 1;
		}

		//並び順がない場合
		if(is_null($order)){
			//指定がない場合は降順
			$order = "desc";
		}

		//フォーマットをyyyymmに変更する
		$start_month = date('Ym', strtotime($start_date));

		//並び順が降順の場合
		if($order === "desc"){
			$next = '-1 month';
		} else {
			$next = '+1 month';		
		}

		$result[0] = $start_month;

		//0から$list_countの回数ループ
		for($i=1; $i<$list_count; $i++){

			$result[$i] = date('Ym', strtotime($start_month . $next));

		}

		return $result;

	}



}