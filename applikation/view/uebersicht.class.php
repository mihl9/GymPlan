<?php
class view{
	public function __construct() {
		
	}
	public function showtxt($data){
		//return '<font color="red">'. $data. '</font>';
		
		ob_start();
		include('./template/index.php');
		$output = ob_get_contents();  
		ob_end_clean();
		return $output;
	}	
}
?>
