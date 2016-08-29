<?php

class Service_Search
{
	public static function getPages($site_id,$priority = null,$tags = [],$freeWord= [],$limit = null)
	{
		$params = ['site_id'=>$site_id];

		$priSql = "";
		$wordSql = "";
		$limitSql = "";
		if ( !is_null($priority) ) {
			$params += ['priority' => $priority];
			$priSql = "AND priority <= :priority";
		}

		if ( !empty($freeWord) && is_array($freeWord)) {
			foreach ( $freeWord as $word ) {
				$wordSql .= " AND url like '%".$word."%'";
			}
		}

		if ( !is_null($limit) ) {
			$params += ['limit' => $limit];
			$limitSql = "LIMIT :limit";
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
		$sql .= $wordSql . PHP_EOL;
		$sql .= $limitSql . PHP_EOL;

		return DB::query($sql)->parameters($params)->/*cached(60*60*24)->*/execute()->as_array();
	}

	/**
	 * ページサーチのPOSTリクエストをサーバーで扱う形にフィルター
	 * @param  array $post input::post
	 * @return array priority and tags
	 * @author egami
	 */
	public static function filterRequest($post)
	{
		$priority = null;
		$tags = [];
		$freeWord = [];
		if (isset($post['priority']) && $post['priority'] !== null && $post['priority'] !== "") {
			$priority = $post['priority'];
		}
		if ( isset($post['tags']) && is_array($post['tags']) && count($post['tags']) > 0 ) {
			$tags = $post['tags'];
		}
		if ( isset($post['freeWord']) && is_array($post['freeWord']) && count($post['freeWord']) > 0 ) {
			$freeWord = $post['freeWord'];
		}
		return [$priority, $tags,$freeWord];
	}
}
