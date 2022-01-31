<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/News.php';

class Controller extends AdminController {
    private $NewsModel;
       
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'news');
        return $this->getTemplateAdapter()->render('admin/news/'.$template);
    }
    
    public function indexCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		
        $where = null;        
        $count = $this->NewsModel->getNewsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->NewsModel->getNews($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	            
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('News', 'manage.tpl.php');
    }  

    public function addCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
        return $this->IndexTheme('Add news', 'edit.tpl.php');        
    }
    
    public function editCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->NewsModel->getNewsById($id))) {
            $this->addMessage('News not found', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        $this->getTemplateAdapter()->pass($item);
        return $this->IndexTheme('Edit news', 'edit.tpl.php'); 
    }
    
    public function doEditCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if ($id && !($item = $this->NewsModel->getNewsById($id))) {
            $this->addMessage('News not found', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        
        $values = array(
            'caption' => Filter::getStrval($_REQUEST, 'caption'),
            'body' => Filter::getStrval($_REQUEST, 'body', !Filter::$_PLAIN)
        );        
        if (!$id) {
            $values['posted'] = date('Y-m-d');
        }
        
        if ($this->ValidateEditForm($values)) {
            $this->NewsModel->saveNews($values, $id);
            $this->addMessage('Изменения сохранены', self::$NOTIF);
            $this->redirect($id?'?cmd=edit&id='.$id:'?cmd=add');
        }
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->pass($values);
        return $this->IndexTheme($id?'Edit news':'Add news', 'edit.tpl.php'); 
    }
    
    public function doRemoveCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $this->NewsModel->rmNews($id);
        $this->addMessage('Изменения сохранены', self::$NOTIF);
        $this->redirect('?cmd=index');        
    }
    
    private function ValidateEditForm(array $values) {
        $valid = true;
        if (empty($values['caption'])) {
            $this->getTemplateAdapter()->put('caption-failed', 'required field');
            $valid = false;
        }
        if (empty($values['body'])) {
            $this->getTemplateAdapter()->put('body-failed', 'required field');
            $valid = false;
        } 
        return $valid;
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>