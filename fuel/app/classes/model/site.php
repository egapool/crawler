<?php

class Model_Site extends \Model
{

	static public function fetchAllSite()
	{
		$sql = "SELECT * FROM sites";
		return DB::query($sql)->execute()->as_array();
	}

	static public function fetchSite($site_id)
	{
		$sql = "SELECT * FROM sites WHERE id = :site_id";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->current();
	}

	static public function fetchSiteByUrl($url)
	{
		$sql = "SELECT * FROM sites WHERE url = :url";
		return DB::query($sql)->parameters(['url'=>$url])->execute()->current();
	}
}
