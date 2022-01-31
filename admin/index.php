<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
//---------------------- models ---------------

class Controller extends AdminController {    
    public function __construct(Config $config) {
        parent::__construct($config);
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'home');
        return $this->getTemplateAdapter()->render('admin/'.$template);
    }
    
    public function indexCmd() {
        return $this->IndexTheme('Home', 'index.tpl.php');
    }            
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>