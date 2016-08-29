<?php

class Service_Pageregister
{
    static public $tags = [];
    static public function pagesInseart($site_id,$v)
    {
        self::getTags($site_id);

        $res = Model_Page::insert($site_id, $v[0], $v[1], $v[2]);
        $page_id = $res[0];
        unset($v[0], $v[1], $v[2]);
        self::setTags($site_id,$page_id,$v);

    }

    static public function setTags($site_id,$page_id,$tags)
    {
        foreach ( $tags as $tag ) {
            $tag = trim($tag);
            if ( $tag == "" ) continue;
            $tagId = null;
            // 未登録タグ
            if ( !isset(self::$tags[$tag]) ) {
                $tagRes = \DB::insert('tags')->set(['site_id'=>$site_id,'name'=>$tag])->execute();
                self::$tags[$tag] = $tagRes;
                $tagId = $tagRes[0];
            }
            if ( is_null($tagId) ) {
                $tagId = self::$tags[$tag]['id'];
            }

            \DB::insert('page_tags')->set(['page_id'=>$page_id,'tag_id'=>$tagId])->execute();
        }
    }

    static public function getTags($site_id)
    {
        if ( !empty(self::$tags) ) {
            //return self::$tags;
        }
        return self::$tags = Model_Tag::fetchTagsAsNameKey($site_id);
    }
}
