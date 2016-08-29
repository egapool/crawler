<?php

class Controller_Pageinseart extends Controller_Base
{
    public $columns = [
        "A" => "title",
        "B" => "url",
        "C" => "priority",
        "D" => "tag",
    ];

	public function action_index()
	{
        $v = [];
        $v['sites'] = Model_Site::fetchAllSite();

        $post = Input::post();
        if ( !empty($post) && $post['action'] === 'send') {
            ini_set('memory_limit', -1);
            $site_id = $post['site_id'];
            $file = $_FILES['file'];
            $uploadDir = APPPATH."/tmp";
            $dstName = basename($file['name']);
            $dstPath = $uploadDir."/".$dstName;
            move_uploaded_file($file['tmp_name'], $dstPath);
            $pages = Service_Excel::dump($dstPath);

            Service_Pageregister::pagesInseart($site_id,$pages);
            Response::redirect('/', 'location');
        }

        $this->template->content = View::forge("pageinseart/index",$v,FALSE);
    }
}
