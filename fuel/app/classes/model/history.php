<?php

class Model_History extends \Model
{
	static public function fetchAll()
	{
		$sql = "SELECT * FROM histories ORDER BY start_at DESC";
		return DB::query($sql)->execute()->as_array();
	}
}
