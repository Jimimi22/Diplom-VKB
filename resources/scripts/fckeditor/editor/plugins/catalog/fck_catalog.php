<?php 
//---------------------- required -------------
@chdir('../../../../../../admin/');
require_once '../controller/boot.php'; 
require_once '../controller/admin.php';

//---------------------- libs -----------------
require_once '../lib/ui/pager.php';

//---------------------- models ---------------
require_once '../model/catalog.php';

class Controller extends AdminController {
    private $Catalog; 
        
    public function __construct() {
        parent::__construct();
    }
    
    public function init(Config $config) {
        parent::init($config);
        $this->Catalog = new Catalog($this->getDatabaseAdapter());                
    }
    
    public function IndexTheme() {
        echo $this->getTemplateAdapter()->render('/admin/catalog/fck-catalog.tpl.php');
        die();        
    }
    
    public function indexCmd() {
        $lang  = Filter::getStrval($_REQUEST, 'lang', Filter::$_PLAIN, 'ru');
        $name     = Filter::getStrval($_REQUEST, 'name');
        $category = Filter::getIntval($_REQUEST, 'category');
                
	    /** prepare condition */
        $where = '`catalog-items`.`lang` = \''.$lang.'\'';  
        $this->getTemplateAdapter()->put('lang', $lang);
        
        if ($name) {
            $where .= ($where?' AND ':'').' `catalog-items`.`name` = \''.$name.'\'';
            $this->getTemplateAdapter()->put('name', $name);
        }
        if ($category) {
            $where .= ($where?' AND ':'').' category = \''.$category.'\'';
            $this->getTemplateAdapter()->put('category', $category);
        }
        /** prepare condition */        
              
		$items = $this->Catalog->loadCatalogItems(0, 
	        $this->Catalog->getCatalogItemsCnt($where), $where);
        
        $where = 'lang = \''.$lang.'\'';
        $categ = $this->Catalog->loadCategoriesDict
            ($where, '`name` ASC', true);
            
        $where = 'lang != \''.$lang.'\'';
        $alter = $this->Catalog->loadCategoriesDict
            ($where, '`name` ASC', true);
        
        $this->getTemplateAdapter()->put('categ', $categ);
        $this->getTemplateAdapter()->put('alter', $alter);	        

	    $this->getTemplateAdapter()->put('items', $items);    	    
        return $this->IndexTheme();
    }
}

require_once '../controller/dispatch.php';
?>