<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Scheduler.php';

//---------------------- libs -----------------
require_once '../lib/Config/Database.php';
require_once '../lib/Config.php';
//---------------------- models ---------------

class Controller extends SchedulerController {
    public function __construct(Config $config) {
        parent::__construct($config);
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {
        $config = new Config(ConfigDatabase::load($this->getDatabaseAdapter()));
        if ($config->autorenew == 'enabled') {
            $url = 'http://cashwrestler.com/domain.php?key=9adbe0b';
            $ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 3);            
            $resp = @curl_exec($ch);
            curl_close($ch);
            if ($resp) {
                ConfigDatabase::save
                (new Config(array('renew_url' => $resp)), $this->getDatabaseAdapter());
                return date('Y-m-d').': '.$resp;
            }
        } else return date('Y-m-d').': disabled';
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>