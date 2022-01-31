<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
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
        $this->getTemplateAdapter()->put('_MENUITEM', 'stats');
        
        return $this->getTemplateAdapter()->render('admin/stats/'.$template);
    }
    
    public function indexCmd() {
        $from = Filter::getDate($_REQUEST, 'from', date('Y-m-d', strtotime('-7 day')));
        $to   = Filter::getDate($_REQUEST, 'to', date('Y-m-d'));
        
        $dates = array();
        $date  = $from;
        while ($date <= $to) {
            $dates[] = $date;
            $date = date('Y-m-d', strtotime($date.' +1 day'));
        }      
        $this->getTemplateAdapter()->put('dates', $dates);
        
        $items = $this->PaymentsModel->getStat($from, $to);
        $total = array();
        foreach($items as $key => $value ) {
            for ($i = 0, $count = count($dates); $i < $count; $i++) {
                if (array_key_exists($dates[$i], $value)) {
                    if (!array_key_exists($dates[$i], $total)) {
                        $total[$dates[$i]] = array(
                            'uid' => null,
                            'clicks_revshare' => 0,
                            'clicks_real' => 0,
                            'amount_revshare' => 0,
                            'amount_real' => 0);
                    }
                    $total[$dates[$i]]['clicks_real'] += $value[$dates[$i]]['clicks_real'];
                    $total[$dates[$i]]['clicks_revshare'] += $value[$dates[$i]]['clicks_revshare'];                    
                    $total[$dates[$i]]['amount_real'] += $value[$dates[$i]]['amount_real'];
                    $total[$dates[$i]]['amount_revshare'] += $value[$dates[$i]]['amount_revshare'];
                }                
            }
        }
        array_unshift($items, $total);
        $this->getTemplateAdapter()->put('items', $items);
        
        $this->getTemplateAdapter()->put('from', $from);
        $this->getTemplateAdapter()->put('to', $to);  
        return $this->IndexTheme('Stats', 'manage.tpl.php');
    }            
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>