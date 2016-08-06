<?php

class Model_Site extends \Model
{
	static public function fetchSite($site_id)
	{
		$sql = "SELECT * FROM sites WHERE id = :site_id";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->current();
	}
}