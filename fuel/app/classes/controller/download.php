<?php

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

class Controller_Download extends Controller_Base
{
	public function action_index($history_id)
	{
		// すでにfileあれば返す
		$filePath = APPPATH . "/tmp/logs_{$history_id}.xlsx";

		if ( !file_exists($filePath) ) {
			$logs = \DB::select('url1','status_code1','url2','status_code2','url3','status_code3','title','h1','keywords','description','robots','canonical','next','prev')->from('logs')->where('history_id','=',$history_id)->execute()->as_array();
			if ( empty($logs) ) {
				return;
			}

			$writer = WriterFactory::create(Type::XLSX);
			$writer->openToFile($filePath);
			$writer->addRow(['url1','status_code1','url2','status_code2','url3','status_code3','title','h1','keywords','description','robots','canonical','next','prev']);
			$writer->addRows($logs);
			$writer->close();
		}

		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
		exit;
	}
}