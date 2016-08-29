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
            $data[$key]['conditions'] = self::convConditions($site_id,$v['conditions']);
        }
        return $data;
    }

    static public function getHistory($site_id,$history_id)
    {
        $sql = "SELECT" . PHP_EOL;
        $sql .= "	s. NAME AS site_name," . PHP_EOL;
        $sql .= "	h.*" . PHP_EOL;
        $sql .= "FROM" . PHP_EOL;
        $sql .= "	`histories` AS h" . PHP_EOL;
        $sql .= "INNER JOIN sites AS s ON h.site_id = s.id" . PHP_EOL;
        $sql .= "WHERE" . PHP_EOL;
        $sql .= "	h.id = :history_id;" . PHP_EOL;
        $data = \DB::query($sql)->parameters(['history_id'=>$history_id])->execute()->current();
        $data['conditions'] = self::convConditions($site_id,$data['conditions']);
        return $data;

    }

    static public function convConditions($site_id,$condition)
    {
        $output = json_decode($condition,true);
        $output['tags'] = Model_Tag::idsToNames($site_id,$output['tags']);
        return $output;
    }
}
