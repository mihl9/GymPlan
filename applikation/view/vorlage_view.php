<?php
class view extends AbsView{
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

    public function setTemplate($template){
        $templatePath=$this->path . '/' . $template . '.php';
        if(file_exists($templatePath)){
            $this->Template = $templatePath;
        }
    }

}
?>
