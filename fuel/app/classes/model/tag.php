<?php

class Model_Tag extends \Model
{
	static public function fetchTags($site_id)
	{
		$sql = "SELECT * FROM tags WHERE site_id = :site_id ORDER BY sort";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array();
	}
}