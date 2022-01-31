<?php
require_once '../lib/Controller/Interface.php';
require_once '../lib/Filter.php';

$controller = new Controller(new Config($config));
if ($controller instanceof ControllerInterface) {
    $command  = Filter::getStrval($_REQUEST, 'cmd', true, 'index');    
    $controller->process($command, array());
}
else
    die(__FILE__.' undispatchable ');
?>