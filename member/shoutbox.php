<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Shoutbox.php';

class Controller extends MemberController {
    private $ShoutboxModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->ShoutboxModel = new ShoutboxModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {        
        return $this->_404($this->getCommand());
    }            
    
    public function indexAsync() {
        $values = array(
            'date' => date('Y-m-d H:i:s'),
            'user' => Filter::getStrval($_REQUEST, 'user'),
            'message' => FIlter::getStrval($_REQUEST, 'message') 
        );
        die($this->ShoutboxModel->saveMessage($values));
    }
    
    public function setSmilesInMessage($message) {
    	$message = str_replace(":-)", "<img src='/resources/images/smiles/ab.gif'>", $message);
    	$message = str_replace(":)", "<img src='/resources/images/smiles/ab.gif'>", $message);
    	$message = str_replace(":-(", "<img src='/resources/images/smiles/ac.gif'>", $message);
    	$message = str_replace(":-D", "<img src='/resources/images/smiles/ag.gif'>", $message);
    	$message = str_replace(";-)", "<img src='/resources/images/smiles/ad.gif'>", $message);
    	$message = str_replace("*ROFL*", "<img src='/resources/images/smiles/bj.gif'>", $message);
    	$message = str_replace(">:o", "<img src='/resources/images/smiles/am.gif'>", $message);
    	$message = str_replace("*BRAVO*", "<img src='/resources/images/smiles/bi.gif'>", $message);
    	$message = str_replace("*OK*", "<img src='/resources/images/smiles/bf.gif'>", $message);
    	$message = str_replace("=-O", "<img src='/resources/images/smiles/ai.gif'>", $message);
    	//$message = str_replace("]->", "<img src='/resources/images/smiles/aq.gif'>", $message);
    	return $message;
    }
    
    public function updateAsync() {
    	header('Content-Type: utf-8');
        $messages = $this->ShoutboxModel->getMessages(0, 20, null, '`date` DESC');
        foreach ($messages as $key=> $value) {
        	$messages[$key]['message'] = $this->setSmilesInMessage($value['message']);
        }
        
        $this->getTemplateAdapter()->put('items', array_reverse($messages));
        die($this->getTemplateAdapter()->render('shoutbox/messages.tpl.php'));
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>