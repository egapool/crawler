<?php

class Service_History
{
    static public function getAllHistories($site_id)
    {
        $sql = "SELECT s.name as site_name,h.* FROM histories as h" . PHP_EOL;
        $sql .= "inner join sites as s ON s.id = h.site_id" . PHP_EOL;
        $sql .= "WHERE h.site_id = :site_id" . PHP_EOL;
        $sql .= "ORDER BY start_at DESC" . PHP_EOL;
        $data = DB::query($sql)->parameters(['site_id'=>$site_id])->execute()->as_array();

        foreach ( $data as $key => $v ) {
            $conditions = json_decode($v['conditions'],true);
            $conditions['tags'] = Model_Tag::idsToNames($site_id,$conditions['tags']);
            $data[$key]['conditions'] = $conditions;
        }
        return $data;
    }
}
