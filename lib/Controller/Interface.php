<?php
interface ControllerInterface {
    public function process($command, array $args = array());
}
?>