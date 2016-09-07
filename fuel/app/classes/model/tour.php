<?php


class Model_Tour extends \Model
{
	static public function insert($site_id,$user_id,$title,$conditions,$count)
    {
        $params = [
            "site_id" => $site_id,
            "user_id" => $user_id,
            "title" => $title,
            "conditions" => $conditions,
            "count" => $count,
            "updated_at" => date('Y-m-d H:i:s'),
            "created_at" => date('Y-m-d H:i:s'),
        ];
        $sql = "INSERT INTO tours (site_id,user_id,title,conditions,count,updated_at,created_at) VALUES(:site_id,:user_id,:title,:conditions,:count,:created_at,:updated_at)";
        return \DB::query($sql)->parameters($params)->execute();
    }

	static public function updateEnjoyKey($user_id,$tour_id,$hash)
	{
		$sql = "UPDATE tours SET enjoykey = :hash WHERE id = :tour_id AND user_id = :user_id";
		\DB::query($sql)->parameters(['tour_id'=>$tour_id,'user_id'=>$user_id,'hash'=>$hash])->execute();
	}

	static public function generateHash($site_id,$tour_id)
	{
		return md5($tour_id . Config::get('const.enjoy_tour_salt').$site_id);
	}
}
