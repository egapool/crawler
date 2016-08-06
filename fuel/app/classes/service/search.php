<?php

class Service_Search
{
	public static function getPages($site_id,$priority = null,$tags = [])
	{
		$params = ['site_id'=>$site_id];

		$priSql = "";
		if ( !is_null($priority) ) {
			$params += ['priority' => $priority];
			$priSql = "AND priority <= :priority";
		}

		$tagSql = "";
		if ( is_array($tags) && $tags !== [] ) {
			$tags = implode(',',$tags);
			$tagSql = "    inner join" . PHP_EOL;
			$tagSql .= "        (" . PHP_EOL;
			$tagSql .= "            select" . PHP_EOL;
			$tagSql .= "                page_id" . PHP_EOL;
			$tagSql .= "            from" . PHP_EOL;
			$tagSql .= "                page_tags" . PHP_EOL;
			$tagSql .= "            where" . PHP_EOL;
			$tagSql .= "                tag_id IN ({$tags})" . PHP_EOL;
			$tagSql .= "            group by" . PHP_EOL;
			$tagSql .= "                page_id" . PHP_EOL;
			$tagSql .= "        ) as t" . PHP_EOL;
			$tagSql .= "    ON  p.id = t.page_id";
		}

		$sql = "SELECT" . PHP_EOL;
		$sql .= "    p.*" . PHP_EOL;
		$sql .= "from" . PHP_EOL;
		$sql .= "    pages as p" . PHP_EOL;
		$sql .= $tagSql . PHP_EOL;
		$sql .= "where" . PHP_EOL;
		$sql .= "    site_id = :site_id" . PHP_EOL;
		$sql .= $priSql . PHP_EOL;

		return DB::query($sql)->parameters($params)->execute()->as_array();
	}
}