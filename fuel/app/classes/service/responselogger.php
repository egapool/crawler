<?php

class Service_Responselogger
{
    static public function logging($data)
    {
        \DB::insert('logs')->set([
            "history_id"    => isset($data['history_id']) ? $data['history_id'] : "",
            "url1"          => isset($data['url1']) ? $data['url1'] : "",
            "status_code1"  => isset($data['status_code1']) ? $data['status_code1'] : "",
            "url2"          => isset($data['url2']) ? $data['url2'] : "",
            "status_code2"  => isset($data['status_code2']) ? $data['status_code2'] : "",
            "url3"          => isset($data['url3']) ? $data['url3'] : "",
            "status_code3"  => isset($data['status_code3']) ? $data['status_code3'] : "",
            "title"         => isset($data['title']) ? $data['title'] : "",
            "h1"            => isset($data['h1']) ? $data['h1'] : "",
            "keywords"      => isset($data['keywords']) ? $data['keywords'] : "",
            "description"   => isset($data['description']) ? $data['description'] : "",
            "noindex"       => isset($data['noindex']) ? $data['noindex'] : "",
            "canonical"     => isset($data['canonical']) ? $data['canonical'] : "",
            "next"          => isset($data['next']) ? $data['next'] : "",
            "prev"          => isset($data['prev']) ? $data['prev'] : "",
            "created_at"    => date('Y-m-d H:i:s'),
        ])->execute();
    }
}
