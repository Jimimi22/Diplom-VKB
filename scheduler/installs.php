<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Scheduler.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Installs.php';

class Controller extends SchedulerController {
    private $InstallsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->InstallsModel = new InstallsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {
        $this->InstallsModel->track();
        return date('Y-m-d').': done';
    }    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>