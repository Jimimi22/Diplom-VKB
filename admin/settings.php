<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Config/Database.php';
require_once '../lib/Config.php';
//---------------------- models ---------------

class Controller extends AdminController {    
    public function __construct(Config $config) {
        parent::__construct($config);
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'settings');
        return $this->getTemplateAdapter()->render('admin/settings.tpl.php');
    }
    
    public function indexCmd() {
        $config = ConfigDatabase::load($this->getDatabaseAdapter());
        $this->getTemplateAdapter()->pass($config);        
        return $this->IndexTheme('Custom settings');
    } 

    public function doSaveCmd() {
        $values = array(
            'ftp_domain' => Filter::getStrval($_REQUEST, 'ftp_domain'),
            'ftp_port' => Filter::getStrval($_REQUEST, 'ftp_port'),            
            'ftp_user' => Filter::getStrval($_REQUEST, 'ftp_user'),
            'ftp_password' => Filter::getStrval($_REQUEST, 'ftp_password'),            
            'ftp_directory' => Filter::getStrval($_REQUEST, 'ftp_directory'),
            'revshare_clicks' => Filter::getFloatval($_REQUEST, 'revshare_clicks'),
            'revshare_money' => Filter::getFloatval($_REQUEST, 'revshare_money'),
            'referal_commission' => Filter::getFloatval($_REQUEST, 'referal_commission'),            
            'min_payment' => Filter::getFloatval($_REQUEST, 'min_payment'),
            'renew_url' => Filter::getStrval($_REQUEST, 'renew_url'),
            'autorenew' => Filter::getStrval($_REQUEST, 'autorenew')
        );
        if ($this->ValidateEditForm($values)) {
            $config = new Config($values);
            ConfigDatabase::save($config, $this->getDatabaseAdapter());
            
            $this->addMessage('Changes saved');
            $this->redirect('?cmd=index');
        }        
        $this->getTemplateAdapter()->pass($values);        
        return $this->IndexTheme('Custom settings');
    }
    
    private function ValidateEditForm(array $values) {
        $valid = true;
        if (empty($values['ftp_domain'])) {
 
            $this->getTemplateAdapter()->put('ftp_domain-failed', 'required field');
            $valid = false;
        }
        if (empty($values['ftp_user'])) {
            $this->getTemplateAdapter()->put('ftp_user-failed', 'required field');
            $valid = false;            
        }        
        if (empty($values['ftp_password'])) {
            $this->getTemplateAdapter()->put('ftp_password-failed', 'required field');
            $valid = false;            
        }        
        if (empty($values['revshare_clicks'])) {
            $this->getTemplateAdapter()->put('revshare_clicks-failed', 'required field');
            $valid = false;            
        }
        if (empty($values['referal_commission'])) {
            $this->getTemplateAdapter()->put('referal_commission-failed', 'required field');
            $valid = false;            
        }        
        if (empty($values['revshare_money'])) {
            $this->getTemplateAdapter()->put('revshare_money-failed', 'required field');
            $valid = false;            
        } 
        if (empty($values['min_payment'])) {
            $this->getTemplateAdapter()->put('min_payment-failed', 'required field');
            $valid = false;            
        }                        
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>