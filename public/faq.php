<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Public.php';

//---------------------- libs -----------------
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/News.php';

class Controller extends PublicController {
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'faq');
        return $this->getTemplateAdapter()->render('public/faq.tpl.php');
    }
    
    public function indexCmd() {
    	$where = '';
    	$count = $this->NewsModel->getNewsCnt($where);
    	$items = $this->NewsModel->getNews(0, $count, $where);
    	$this->getTemplateAdapter()->put('news', $items);
        return $this->IndexTheme('FAQ');
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>