<?php

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

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
        $v['sites'] = \Model_Site::fetchAllSite();

        $post = \Input::post();
        if ( !empty($post) && $post['action'] === 'send') {
            ini_set('memory_limit', -1);
            $site_id = $post['site_id'];
            $file = $_FILES['file'];
            $uploadDir = APPPATH."/tmp";
            $dstName = basename($file['name']);
            $dstPath = $uploadDir."/".$dstName;
            move_uploaded_file($file['tmp_name'], $dstPath);
            $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
            $reader->open($dstPath);

            try{
                //\DB::start_transaction();

                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator()  as $key => $row) {
                        // 1行目はスルー
                        if ($key === 1 ) continue;
                        \Service_Pageregister::pagesInseart($site_id,$row);
                        var_dump($key,$row);
                    }
                }
                $reader->close();
                //\DB::commit_transaction();
                \Response::redirect('/', 'location');
            } catch(Exception $e){
                //\DB::rollback_transaction();
            }
            //$pages = \Service_Excel::dump($dstPath);
        }

        $this->template->content = \View::forge("pageinseart/index",$v,FALSE);
    }
}
