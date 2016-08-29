<?php

class Service_Pageregister
{
    static public $tags = [];
    static public function pagesInseart($site_id,$data)
    {
        self::getTags($site_id);
        foreach ( $data as $v ) {
            $res = Model_Page::insert($site_id, $v['A'], $v['B'], $v['C']);
            $page_id = $res[0];
            unset($v['A'], $v['B'], $v['C']);
            self::setTags($site_id,$page_id,$v);
        }
    }

    static public function setTags($site_id,$page_id,$tags)
    {
        foreach ( $tags as $tag ) {
            $tagId = null;
            // 未登録タグ
            if ( !isset(self::$tags[$tag]) ) {
                $tagRes = \DB::insert('tags')->set(['site_id'=>$site_id,'name'=>$tag])->execute();
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
            return $this->tags;
        }
        return self::$tags = Model_Tag::fetchTagsAsNameKey($site_id);
    }
}
