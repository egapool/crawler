<?php

class Model_Page extends \Model
{
	static public function fetchPages($site_id)
	{
		$sql = "SELECT * FROM pages WHERE site_id = :site_id LIMIT 100";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array();
	}
}