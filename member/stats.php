<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Payments.php';

class Controller extends MemberController {    
    private $PaymentsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->PaymentsModel = new PaymentsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'stats');
        
        return $this->getTemplateAdapter()->render('member/stats/'.$template);
    }
    
    public function indexCmd() {
        $from = Filter::getDate($_REQUEST, 'from', date('Y-m-d', strtotime('-7 day')));
        $to   = Filter::getDate($_REQUEST, 'to', date('Y-m-d'));
        
        $user = $this->getUser();
        
        $items = $this->PaymentsModel->getMemberStat($from, $to, $user['id']);
        $this->getTemplateAdapter()->put('items', $items);
        
        $this->getTemplateAdapter()->put('from', $from);
        $this->getTemplateAdapter()->put('to', $to);  
        return $this->IndexTheme('Stats', 'manage.tpl.php');
    }            
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>