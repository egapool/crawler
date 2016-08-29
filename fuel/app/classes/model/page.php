<?php

class Model_Page extends \Model
{
	static public function fetchPages($site_id,$limit)
	{
		$sql = "SELECT * FROM pages WHERE site_id = :site_id LIMIT {$limit}";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array();
	}

	static public function insert($site_id,$title,$url,$priority)
	{
		$res = \DB::insert('pages')->set([
			"site_id" => $site_id,
			"title" => $title,
			"url" => $url,
			"priority" => $priority
		])->execute();
		return $res;
	}
}
