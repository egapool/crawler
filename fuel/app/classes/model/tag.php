<?php

class Model_Tag extends \Model
{
	static public function fetchTags($site_id)
	{
		$sql = "SELECT * FROM tags WHERE site_id = :site_id ORDER BY sort";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array();
	}

	static public function fetchTagsAsNameKey($site_id)
	{
		$sql = "SELECT * FROM tags WHERE site_id = :site_id ORDER BY sort";
		return DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array('name');
	}

	static public function idsToNames($site_id,$tagIds)
	{
		$names = [];
		$newTag = [];
		$tags = self::fetchTags($site_id);
		foreach ( $tags as $tag ) {
			$newTag[$tag['id']] = $tag['name'];
		}
		foreach ( $tagIds as $id ) {
			$names[] = $newTag[$id];
		}
		return $names;
	}
}
