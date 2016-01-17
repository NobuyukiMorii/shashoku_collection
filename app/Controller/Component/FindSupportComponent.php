<?php
App::uses('Component', 'Controller');

/**
 * Findをサポートする関数を集約する
 */
class FindSupportComponent extends Component {

    /**
     * Findを複数回繰り返す
     * $keyはいくつでも指定可能
     * @param  array  $model_name_array
     * @return array
     */
	public function multipleFindCache($model_name_array){

		//モデル名をループ
		foreach ($model_name_array as $model_name) {

			//モデルを呼び出す
			$model = ClassRegistry::init($model_name);

			//テーブル名を取得（配列のキーとする）
			$use_table = $model->useTable;

			//キャッシュでfindする
			$result[$use_table] = $model->find('all', array('cache' => true));

		}

		return $result;

	}

    /**
     * 複数のマスタデータから、不完全なレコードを除去する
     * 不完全なレコードとは、モデルにshouldHaveとして設定されているマスタの情報がないコード
     * @param  array  $model_name_array
     * @param  array  $msts
     * @param  string $file
     * @param  string $mothod
     * @param  string $line
     * @return array
     */
	public function washMasterData($model_name_array, $msts, $file=NULL, $mothod=NULL, $line=NULL){

		//ファイル名がない場合
		if(is_null($file)){
			$file = __FILE__;
		}

		if(is_null($mothod)){
			$mothod = __METHOD__;
		}

		if(is_null($line)){
			$line = __LINE__;
		}

		//モデル名をループ
		foreach ($model_name_array as $model_name) {

			//モデルを呼び出す
			$model 		= ClassRegistry::init($model_name);

			//テーブル名を取得（配列のキーとする）
			$use_table = $model->useTable;

			//外部キー
			$foreign_key = $model->foreignKey;

			//必ず必要な他モデルのデータ
			$should_haves = $model->shouldHave;

			//関連モデルの外部キー名
			$should_belongs_tos = $model->shouldBelongsTo;

			//カラム名の配列
			$culumns = $model->getColumnTypes();

			//もし開始日と終了日のカラムがあれば
			if(array_key_exists('start_date', $culumns) && array_key_exists('end_date', $culumns)){

				//有効期限内のデータのみを取得する
				$msts[$use_table] = $model->extractRecordInPeriod($msts[$use_table]);

			}

			//ShouldHave
			//必要なモデルをループ
			if(!empty($should_haves)){

				foreach ($should_haves as $should_have) {

					//関連モデル
					$should_have_model = ClassRegistry::init($should_have);

					//関連モデルのテーブル名
					$should_have_use_table = $should_have_model->useTable;

					//対象のデータがあれば
					if(!empty($msts[$should_have_use_table])){

						//不完全なデータを削除
						$msts[$use_table]  = $model->removeIncompleteRecords_ShouldHave($msts[$use_table], $msts[$should_have_use_table], $foreign_key, $file, $mothod, $line);

					} else {

		                //エラーログを出力（開発環境のみ）
		                $message = "removeIncompleteRecords_ShouldHaveにより不完全な".$use_table."のデータを除去を試みましたが、必要な".$should_have_use_table."がありませんでした。";
		                Util::OriginalLog($file, $method, $line, $message);

					}

				}

			}

			//ShouldBelongsTo
			if(!empty($should_belongs_tos)){

				foreach ($should_belongs_tos as $should_belongs_to) {

					//関連モデル
					$should_belongs_to_model = ClassRegistry::init($should_belongs_to);

					//関連モデルのテーブル名
					$should_belongs_to_use_table = $should_belongs_to_model->useTable;

					//関連モデルの外部キー名
					$should_belongs_to_foreign_key = $should_belongs_to_model->foreignKey;

					//対象のデータがあれば
					if(!empty($msts[$should_belongs_to_use_table])){

						//不完全なデータを削除
						$msts[$use_table]  = $model->removeIncompleteRecords_ShouldBelongsTo($msts[$use_table], $msts[$should_belongs_to_use_table], $should_belongs_to_foreign_key, $file, $mothod, $line);

					} else {
						
		                //エラーログを出力（開発環境のみ）
		                $message = "removeIncompleteRecords_ShouldBelongsToにより不完全な".$use_table."のデータを除去を試みましたが、必要な".$should_belongs_to_use_table."がありませんでした。";
		                Util::OriginalLog($file, $method, $line, $message);

					}

				}

			}

		}

		return $msts;

	}


}