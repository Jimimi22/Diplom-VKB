<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Scheduler.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Payments.php';

class Controller extends SchedulerController {
    private $PaymentsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->PaymentsModel = new PaymentsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {
        $this->PaymentsModel->calculate();
        return date('Y-m-d').': done';
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>