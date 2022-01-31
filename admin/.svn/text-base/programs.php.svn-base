<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
require_once '../lib/Geoip/geoip.inc';
require_once '../lib/Config/Database.php';
require_once '../lib/Config.php';
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Programs.php';
require_once '../model/Users.php';

class Controller extends AdminController {    
    private $ProgramsModel;
    private $UsersModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->ProgramsModel = new ProgramsModel($this->getDatabaseAdapter());
        $this->UsersModel    = new UsersModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $menu, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', $menu);
        return $this->getTemplateAdapter()->render('admin/programs/'.$template);
    }
    
    public function indexCmd() {
        $where = null;    
        
        $count = $this->ProgramsModel->getProgramsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->ProgramsModel->getPrograms($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	            
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());	    
        
        return $this->IndexTheme('Programs', 'programs', 'manage.tpl.php');
    } 
    
    public function statCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->ProgramsModel->getProgramById($id))) {
            $this->addMessage('Program not found', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        
        $from = Filter::getDate($_REQUEST, 'from', date('Y-m-d', strtotime('-7 day')));
        $to   = Filter::getDate($_REQUEST, 'to', date('Y-m-d'));
        
        $dates = array();
        $date  = $from;
        while ($date <= $to) {
            $dates[] = $date;
            $date = date('Y-m-d', strtotime($date.' +1 day'));
        }      
        $this->getTemplateAdapter()->put('dates', $dates);                
                                
        $stat = $this->ProgramsModel->getProgramStatByDate($from, $to, $id);
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->put('from', $from);
        $this->getTemplateAdapter()->put('to', $to);        
        $this->getTemplateAdapter()->put('stat', $stat);
        return $this->IndexTheme('Programs', 'programs', 'stat.tpl.php');
    }
    
    public function editCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->ProgramsModel->getProgramById($id))) {
            $this->addMessage('Program not found', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        
        $rows = $this->ProgramsModel->getGroups(0, $this->ProgramsModel->getGroupsCnt());
        $groups = array();
        for ($i = 0, $count = count($rows); $i < $count; $i++) {
            $groups[$rows[$i]['id']] = $rows[$i]['name'];
        }
        
        $this->getTemplateAdapter()->put('groups', $groups);
        $this->getTemplateAdapter()->pass($item);
        
        return $this->IndexTheme('Edit program', 'programs', 'edit.tpl.php');
    }
    
    public function addCmd() {
        $rows = $this->ProgramsModel->getGroups(0, $this->ProgramsModel->getGroupsCnt());
        $groups = array();
        for ($i = 0, $count = count($rows); $i < $count; $i++) {
            $groups[$rows[$i]['id']] = $rows[$i]['name'];
        }
        
        $this->getTemplateAdapter()->put('groups', $groups);
        return $this->IndexTheme('Add program', 'programs', 'edit.tpl.php');        
    }
        
    public function doEditCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if ($id && !($item = $this->ProgramsModel->getProgramById($id))) {
            $this->addMessage('Program not found', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        
        $values = array(
            'program' => Filter::getArrval($_FILES, 'program'),
            'group' => Filter::getIntval($_REQUEST, 'group'),
            'total_uploads' => Filter::getIntval($_REQUEST, 'total_uploads'),
            'day_uploads' => Filter::getIntval($_REQUEST, 'day_uploads'),
            'position' => Filter::getIntval($_REQUEST, 'position'),
            'download_link' => Filter::getStrval($_REQUEST, 'download_link'),
            'status' => Filter::getStrval($_REQUEST, 'status'));
            
        if ($this->ValidateEditProgramForm($values)) {
            unset($values['download_link']);
            if($this->ProgramsModel->saveProgram($values, $id)) {
                $this->addMessage('Changes saved', self::$NOTIF);
                $this->redirect($id?'?cmd=edit&id='.$id:'?cmd=add');                
            }
            $this->addMessage('Can\t upload file to FTP server.', self::$ERROR);
        }
        
        $rows = $this->ProgramsModel->getGroups(0, $this->ProgramsModel->getGroupsCnt());
        $groups = array();
        for ($i = 0, $count = count($rows); $i < $count; $i++) {
            $groups[$rows[$i]['id']] = $rows[$i]['name'];
        }
        
        $this->getTemplateAdapter()->pass($values);
        $this->getTemplateAdapter()->put('id', $id);        
        $this->getTemplateAdapter()->put('groups', $groups);
        return $this->IndexTheme($id?'Edit program':'Add pogram', 'programs', 'edit.tpl.php');  
    }
    
    public function doRemoveCmd() {
        if ($this->ProgramsModel->rmProgram(Filter::getIntval($_REQUEST, 'id'))) {
            $this->addMessage('Changes saved', self::$NOTIF);
        } else 
            $this->addMessage('Cant\' remove program from FTP', self::$ERROR);
        $this->redirect('?cmd=index');                    
    }
    
    public function cgroupsCmd() {                
        $items = $this->ProgramsModel->getGroups(0, $this->ProgramsModel->getGroupsCnt());
        $this->getTemplateAdapter()->put('items', $items);
        return $this->IndexTheme('Countries groups for programs', 'settings', 'groups/manage.tpl.php');
    }
    
    public function addCgroupCmd() {        
        $gi = new GeoIP();
        
        $countries = array();
        for ($i = 0, $count = count($gi->GEOIP_COUNTRY_NAMES); $i < $count; $i++ ) {
            if ($gi->GEOIP_COUNTRY_CODES[$i] != '' )
                $countries[$gi->GEOIP_COUNTRY_CODES[$i]] = $gi->GEOIP_COUNTRY_NAMES[$i];
        }
        $this->getTemplateAdapter()->put('items', $countries);        
        return $this->IndexTheme('Add countries group for programs', 'settings', 'groups/edit.tpl.php');
    }
    
    public function editCgroupCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->ProgramsModel->getGroupById($id))) {
            $this->addMessage('Group not found', self::$ERROR);
            $this->redirect('?cmd=cgroups');
        } 
        
        $gi = new GeoIP();
        
        $countries = array();
        for ($i = 0, $count = count($gi->GEOIP_COUNTRY_NAMES); $i < $count; $i++ ) {
            if ($gi->GEOIP_COUNTRY_CODES[$i] != '' )
                $countries[$gi->GEOIP_COUNTRY_CODES[$i]] = $gi->GEOIP_COUNTRY_NAMES[$i];
        }
        
        $item['countries'] = explode(' ', $item['countries']);        
        
        $this->getTemplateAdapter()->pass($item);        
        $this->getTemplateAdapter()->put('items', $countries);                 
        return $this->IndexTheme('Edit countries group for programs', 'settings', 'groups/edit.tpl.php');        
    }
    
    public function doSaveCgroupCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        if ($id && !($item = $this->ProgramsModel->getGroupById($id))) {
            $this->addMessage('Group not found', self::$ERROR);
            $this->redirect('?cmd=cgroups');
        } 
                
        $values = array(
            'name' => Filter::getStrval($_REQUEST, 'name'),
            'countries' => Filter::getArrval($_REQUEST, 'countries')
        );
        if ($this->ValidateEditCgroupForm($values)) {
            $values['countries'] = implode(' ', $values['countries']);
            $this->ProgramsModel->saveGroup($values, $id);
            $this->addMessage('Changes saved', self::$NOTIF);
            $this->redirect($id?'?cmd=editCgroup&id='.$id:'?cmd=addCgroup');
        }
        $gi = new GeoIP();
        
        $countries = array();
        for ($i = 0, $count = count($gi->GEOIP_COUNTRY_NAMES); $i < $count; $i++ ) {
            if ($gi->GEOIP_COUNTRY_CODES[$i] != '' )
                $countries[$gi->GEOIP_COUNTRY_CODES[$i]] = $gi->GEOIP_COUNTRY_NAMES[$i];
        }
        
        $this->getTemplateAdapter()->pass($values);
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->put('items', $countries);        
        return $this->IndexTheme($id?'Edit countries group for programs':'Add countries group for programs', 'settings', 'groups/edit.tpl.php');        
    }
    
    public function doRemoveCgroupCmd() {
        if ($this->ProgramsModel->rmGroup(Filter::getIntval($_REQUEST, 'id'))) {
            $this->addMessage('Changes saved', self::$NOTIF);                    
        } else 
            $this->addMessage('Can\'t remove related programs from FTP', self::$ERROR);
        $this->redirect('?cmd=cgroups');        
    }
    
    private function ValidateEditProgramForm(array $values) {
        $valid = true;
        if (!$values['download_link'] && $values['program']['error']) { // edit case
            $this->getTemplateAdapter()->put('program-failed', 'required field');
            $valid = false;
        }
        return $valid;
    }
    
    private function ValidateEditLoaderForm(array $values) {
        $valid = true;
        if ($values['file']['error']) {
            $this->getTemplateAdapter()->put('file-failed', 'required field');
            $valid = false;
        }
        if (empty($values['xor'])) {
            $this->getTemplateAdapter()->put('xor-failed', 'required field');
            $valid = false;
        }
        if (empty($values['offset'])) {
            $this->getTemplateAdapter()->put('offset-failed', 'required field');
            $valid = false;
        }        
        return $valid;
    }    
    
    private function ValidateEditCgroupForm(array $values) {
        $valid = true;
        if (empty($values['name'])) {
            $this->getTemplateAdapter()->put('name-failed', 'required field');
            $valid = false;
        }
        if (!count($values['countries'])) {            
            $this->getTemplateAdapter()->put('countries-failed', 'required field');
            $valid = false;            
        }        
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>