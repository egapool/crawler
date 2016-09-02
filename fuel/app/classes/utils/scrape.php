<?php

class Utils_Scrape
{
    private $xpath = null;

    public function __construct($httpBody,$encoding = "UTF-8")
    {
        $dom = new DOMDocument;
		@$dom->loadHTML(mb_convert_encoding($httpBody, 'HTML-ENTITIES', $encoding));
		$this->xpath = new DOMXPath($dom);
    }

    public function getTitle()
    {
        $query = "//title";
        $x = $this->xpath->query($query)->item(0);
        if ( is_null($x) ) return "";
        return $x->nodeValue;
    }

    public function getH1()
    {
        $query = "//h1";
        $x = $this->xpath->query($query)->item(0);
        if ( is_null($x) ) return "";
        return $x->nodeValue;
    }

    public function getMeta($name)
    {
        $query = '//meta[@name="'.$name.'"]';
        $x = $this->xpath->query($query)->item(0);
        if ( is_null($x) ) return "";
        return $x->getAttribute('content');
    }

    public function getLink($rel)
    {
        $query = '//link[@rel="'.$rel.'"]';
        $x = $this->xpath->query($query)->item(0);
        if ( is_null($x) ) return "";
        return $x->getAttribute('href');
    }
}
