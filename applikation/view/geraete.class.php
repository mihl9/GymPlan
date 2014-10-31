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

    public function displayGeraeteList($data){
        $_Result='<table class="table table-bordered">
			<thead>
				<tr>
					<td>Gerät</td>
					<td>Beschreibung</td>
					<td>Edit</td>
				</tr>
			</thead>
			<tbody>';
        foreach($data as $row){
            $_Result=$_Result . '<tr>';
            $_Result=$_Result . '<td>' . $row['GeraeteName'] . '</td>';
            $_Result=$_Result . '<td>' . $row['GeraeteBez'] . '</td>';
            $_Result=$_Result . '<td>
					<form name="FrmEditTab" method="post">
						<input type="hidden" name="DataID" value="' . $row['GeraeteID'] . '" />
						<button type="submit" class="btn btn-default" name="btnEdit" value="edit">Bearbeiten</button>
						<button type="submit" class="btn btn-default" name="btnDel" value="delete">X</button>
					</form>
				 </td>
				 </tr>';
        }
        $_Result = $_Result . '</tbody></table>';
        $_Result .= '<form name="FrmEdit" method="post">
		            <button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
	                </form>';
        $this->setContent("Content",$_Result);
    }
    public function setTemplate($template){
        $templatePath=$this->path . '/' . $template . '.php';
        if(file_exists($templatePath)){
            $this->Template = $templatePath;
        }
    }

}
?>
