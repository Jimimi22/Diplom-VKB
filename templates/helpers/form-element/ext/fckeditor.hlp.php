<?php
//---------------------- required -------------
include_once '../lib/Template/Native/Helper/Abstract.php';

//---------------------- libs -----------------
require_once '../lib/ui/fckeditor.php';

//---------------------- models ---------------

class FckeditorHelper extends NativeHelperAbstract {	    
    private $_toolbars = array(
	    /** default */
		'default' => array(
		    array( 'Source', 'DocProps', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'),
		    array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteWord', '-', 'Print', 'SpellCheck'),
		    array( 'Undo', 'Redo','-','Find','Replace','-','SelectAll','RemoveFormat'),
		    array( 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'), '/', 
		   	    array( 'Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Subscript', 'Superscript' ),
		    array( 'OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', 'Blockquote' ),
		    array( 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull' ),
		    array( 'Link', 'Unlink', 'Anchor' ),
		    array( 'Image', 'Flash', 'Table', 'Rule', 'Smiley', 'SpecialChar', 'PageBreak' ), '/',
		   	    array( 'Style', 'FontFormat', 'FontName', 'FontSize' ),
		    array( 'TextColor', 'BGColor'),
		    array( 'FitWindow', 'ShowBlocks', '-', 'About' )),
		    
	    /** default */
		'basic' => array(
  			array('Bold', 'Italic', '-', 'OrderedList', 'UnorderedList', '-', 'Link', 'Unlink')),
  			
	    /** engine */		
		'engine' => array(
		    array( 'DocProps', '-', 'Preview', '-', 'Templates'),
		    array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteWord'),
		    array( 'Undo', 'Redo','-','Find','Replace','-','SelectAll','RemoveFormat'),
		    '/', 
		   	array( 'Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Subscript', 'Superscript' ),
		    array( 'OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', 'Blockquote' ),
		    array( 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull' ),
		    array( 'Link', 'Unlink', 'Anchor' ),
		    array( 'Image', 'Table', 'Rule', 'SpecialChar', ), 
		    '/',
            array( 'Style', 'FontFormat', 'FontName', 'FontSize' ),
		    array( 'TextColor', 'BGColor' ),
		    array( 'FitWindow', 'Catalog' ))		
	);
	    
    private $_defaults = array(
        'with-failed' => true,
        'height' => '300');    
	
	public function __construct($template) {
        parent::__construct($template);
	}
		
	function run($name, $value, $toolbar, array $options = array()) {
		$toolbar = 'default';
		$options = array_merge($this->_defaults, $options);	 

        if (is_array($toolbar)) {
            $toolbar = Json::encode($toolbar);
        } else if (array_key_exists($toolbar, $this->_toolbars)) {
            $toolbar = Json::encode($this->_toolbars[$toolbar]);
        } else 
            $toolbar = null;
        
        if ($toolbar) {        
    	    $fck = new FCKEditor($name);
	        $fck->BasePath   = '../resources/scripts/fckeditor/';	    
	        $fck->ToolbarSet = 'engine-toolbar';	    
	    
    	    $fck->Height     = $options['height'];
	        $fck->Value      = $value;
	    	    	    
    	    $html =  "<script type=\"text/javascript\">
				if(window.FCK_Custom_Toolbar == null) {
					window.FCK_Custom_Toolbar = new Array();
				}
				window.FCK_Custom_Toolbar = ".$toolbar.";
			</script>".$fck->CreateHtml();
    	    /*
            if ($options['with-failed']) {
                $html .= $this->withFailedHTMLCode($name);
            }
			*/
        } else
            $html = 'undefined toolbar';
        echo $html;	    
	}
}
?>