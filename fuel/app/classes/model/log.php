<?php

class Model_Log extends \Model
{
	static public function fetchByHistoryId($history_id)
	{
		$sql = "SELECT * FROM logs WHERE history_id = :history_id ORDER BY id ASC";
		return DB::query($sql)->parameters(['history_id'=>$history_id])->execute()->as_array();
	}
}
