<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
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
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'payments');
        return $this->getTemplateAdapter()->render('member/payments/manage.tpl.php');
    }
    	
    public function indexCmd() {
    	$this->getTemplateAdapter()->put('uid', $_SESSION['uid']);	
        /*
		$where = '';
        $values = array(
            'date_from' => Filter::getDate($_REQUEST, 'date_from', date('Y-m-d', strtotime('-7 day'))),
            'date_to' => Filter::getDate($_REQUEST, 'date_to', date('Y-m-d')));
		
        if ($_SESSION['uid'])
       		$where .= '`uid` = \''.$_SESSION['uid'].'\'';
        if(empty($values['date_from']) && !empty($values['date_to']))
        	$where .= ' AND `pay_period` <= "'.$values['date_to'].'"';
        elseif(!empty($values['date_from']) && empty($values['date_to']))        	
			$where .= ' AND `pay_period` >= "'.$values['date_from'].'"';
        else	
        	$where .= '';
        */
        $user  = $this->getUser();
        $where = '`uid` = \''.$user['uid'].'\'';
        $count = $this->PaymentsModel->getPaymentsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      
            	
        $items = $this->PaymentsModel->getPayments($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);	
        
	    //$this->getTemplateAdapter()->pass($values);
	    $payment_systems = $this->PaymentsModel->getPaymentSystems();
    	foreach ($items as $key => $value) {
           	if($payment_systems[$value['pay_method']]['percent']) {
        		$items[$key]['to_pay'] = $items[$key]['pay_sum'] - ($payment_systems[$value['pay_method']]['amount']*$items[$key]['pay_sum'])/100;
        	}
        	else {
        		$items[$key]['to_pay'] = $items[$key]['pay_sum'] - $payment_systems[$value['pay_method']]['amount'];
        	}	
        }
    	$this->getTemplateAdapter()->put('payment_systems', $payment_systems);	 	    
        $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());
        return $this->IndexTheme('Payments');
    	
    	return $this->IndexTheme('Payments');
    }   	    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>