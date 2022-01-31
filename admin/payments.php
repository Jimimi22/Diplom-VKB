<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Payments.php';

class Controller extends AdminController {
    private $PaymentsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->PaymentsModel = new PaymentsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'payments');
        return $this->getTemplateAdapter()->render('admin/payments/'.$template);
    }
    
    public function indexCmd() {
        $this->redirect('?cmd=notpaid');
    }
    
    public function paidCmd() {
		$count = $this->PaymentsModel->getPaymentsCnt($where);
		$where = '`payments`.`is_payed` = 1 AND `payments`.`uid` = `users`.`uid`';
        $values = array(
            'date_from' => Filter::getDate($_REQUEST, 'date_from', date('Y-m-d', strtotime('-7 day'))),
            'date_to' => Filter::getDate($_REQUEST, 'date_to', date('Y-m-d')),
        );
		
        if(empty($values['date_from']) && !empty($values['date_to']))
        	$where .= ' AND `payments`.`pay_period` <= "'.$values['date_to'].'"';
        elseif(!empty($values['date_from']) && empty($values['date_to']))        	
			$where .= ' AND `payments`.`pay_period` >= "'.$values['date_from'].'"';
        else	
        	$where .= '';
        
        $count = $this->PaymentsModel->getUsersPaymentsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      
            	
        $items = $this->PaymentsModel->getUsersPayments($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);	
		
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
	    $this->getTemplateAdapter()->put('page', $page);
        $this->getTemplateAdapter()->pass($values);	    
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());
        return $this->IndexTheme('Payments', 'paid.tpl.php');        
    }    
    
    public function notpaidCmd() {
        $count = $this->PaymentsModel->getPaymentsCnt($where);
		$where = '`payments`.`is_payed` = 0 AND `payments`.`uid` = `users`.`uid`';
        $values = array(
            'date_from' => Filter::getDate($_REQUEST, 'date_from', date('Y-m-d', strtotime('-7 day'))),
            'date_to' => Filter::getDate($_REQUEST, 'date_to', date('Y-m-d')),
        );
		
        if(empty($values['date_from']) && !empty($values['date_to']))
        	$where .= ' AND `payments`.`pay_period` <= "'.$values['date_to'].'"';
        elseif(!empty($values['date_from']) && empty($values['date_to']))        	
			$where .= ' AND `payments`.`pay_period` >= "'.$values['date_from'].'"';
        else	
        	$where .= '';
        
        $count = $this->PaymentsModel->getUsersPaymentsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      
            	
        $items = $this->PaymentsModel->getUsersPayments($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);	
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
	    $this->getTemplateAdapter()->put('page', $page);
        $this->getTemplateAdapter()->pass($values);	    
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());
        return $this->IndexTheme('Payments', 'notpaid.tpl.php');        
    }

    public function doPayCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->PaymentsModel->getPaymentById($id))) {
            $this->addMessage('Payment not found', self::$ERROR);
            $this->redirect('?cmd=notpaid');
        }
        $this->PaymentsModel->savePayment(array('is_payed' => 1), $id);   
        $user = $this->getUser();
        
        $PHPMailer = new PHPMailer();
        $PHPMailer->ContentType = 'text/html';
        $PHPMailer->CharSet = 'utf-8';           
        $PHPMailer->From    = 'no-reply@yabucks.com';      
        $PHPMailer->FromName = 'YA!BUCKS';
            
        $PHPMailer->Subject = 'Payment from YA!BUCKS';            
        
        $this->getTemplateAdapter()->pass($item);        
        $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/payment.tpl.php'); 

        $PHPMailer->AddAddress($item['email']);                
        $PHPMailer->Send();
   		
    	$this->addMessage('Changes saved', self::$NOTIF);
    	$this->redirect('?cmd=notpaid');   		
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>