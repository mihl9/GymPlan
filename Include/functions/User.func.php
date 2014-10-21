<?php
	include_once 'DataReader.func.php';
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
	//check if the user is correctly loggedin
	function _checkSession(){
		if(isset($_SESSION['ist_eingeloggt'])){
			if($_SESSION['ist_eingeloggt']){
				return TRUE;
			}else{
				return FALSE;
			}   
		}else{
			return FALSE;
		}
	}
	
	//Loads the Specific data of the user and saves them into the session
	//This function is called when the user first logs in
	function _LoadUserInformation(){
		if(_checkSession()){
			//Load the last Login Date and sets the new Date
			_LoadFile('../Daten/Users.csv');
			_Find($_SESSION['username'],0);
			//writes the last login into the Session
			$_SESSION['Last_Login']=_read(2);
			//and write the new Date into the File
			_write(date("d.m.Y") . " " . date("H:i"),2);
			//saves the File
			_UnloadFile(TRUE);
			
			_LoadFile('../Daten/' . $_SESSION['username'] . '/Plaene.csv');
			_moveLast();
			//saves the last entry of the plan into the session for standard selection
			$_SESSION['SelectedPlan']=_read(0);
			_moveFirst();
			
			_UnloadFile(FALSE);
		}
	}
	
	function _updateGeraet($_ID, $_Name, $_bezeichnung){
		$_Result=FALSE;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			if(_Find($_ID,0)){
				$_Result=TRUE;
				_write($_Name,0);
				_write($_bezeichnung,1);
			}else{
				$_Result=FALSE;
			}
			_UnloadFile(TRUE);
		}
		return $_Result;
	}
	
	//adds a device into the list
	function _addGeraet($_Name, $_Bezeichnung){
		$_Result=FALSE;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			_Add();
			_write($_Name,0);
			_write($_Bezeichnung,1);
			$_Result=TRUE;
			_UnloadFile(TRUE);
		}
		return $_Result;
	}
	
	//delets the Device
	function _delGeraet($_ID){
		$_Result=FALSE;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			if(_Find($_ID,0)){
				$_Result=TRUE;
				_Del();
			}else{
				$_Result=FALSE;
			}
			_UnloadFile(TRUE);
		}
		return $_Result;
	}
	
	//returns a combobox witch inherits all of the Devices
	function _getGeraetCombobox($_ObjID,$_Selection){
		$_result="";
		if($_ObjID==""){
			$_ObjID="selectionGeraet";
		}
		if(_checkSession()){
			$_result='<select name="' . $_ObjID . '" class="form-control">';
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			_moveFirst();
			while(!_isEOF()){
				if(_read(0)==$_Selection){
					$_result= $_result . '<option selected value="' . _read(0) . '"  >' . _read(0) . '</option>';
				}else{
					$_result= $_result . '<option value="' . _read(0) . '"  >' . _read(0) . '</option>';
				}
				_moveNext();
			}
			_UnloadFile(FALSE);
			$_result =$_result . '</select>';
		}
		return $_result;
	}

	//returns an Array with the Inofs of the device
	function _getGeraeteInfo($_DeviceID){
		$_Result=array();
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			if(_Find($_DeviceID,0)){
				$_Result=_readArray();
			}else{
				$_Result=FALSE;
			}
			_UnloadFile(FALSE);
		}
		return $_Result;
	}
	
	//return a string with a formated Table inherits the needed data
	function _getGeraeteTab(){
		$_Result="";
		if(_checkSession()){
			$_Result='<table class="table table-bordered">
			<thead>
				<tr>
					<td>Gerät</td>
					<td>Beschreibung</td>
					<td>Edit</td>
				</tr>
			</thead>
			<tbody>';
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/geraete.csv');
			_moveFirst();
			while(!_isEOF()){
				$_Result=$_Result . '<tr>';
				$_Result=$_Result . '<td>' . _read(0) . '</td>';
				$_Result=$_Result . '<td>' . _read(1) . '</td>';
				$_Result=$_Result . '<td>
					<form name="FrmEditTab" method="post">
						<input type="hidden" name="src" value="' . $_SERVER['REQUEST_URI'] . '" />
						<input type="hidden" name="DataID" value="' . _read(0) . '" />
						<button type="submit" class="btn btn-default" name="btnEdit" value="edit">Bearbeiten</button>
						<button type="submit" class="btn btn-default" name="btnDel" value="delete">X</button>
					</form>
				 </td>
				 </tr>';
				_moveNext();
			}
			_UnloadFile(FALSE);
			if(_getCursorPos()==0){
				
			}
			$_Result = $_Result . '</tbody></table>';
		}
		
		return $_Result;
	}
	
	//return a Table with the data of the Selected Plan
	function _getPlanInformationTab($_canEdit){
		$_Result="";
		$_Count=1;
		if(_checkSession()){
			$_Result='<table class="table table-bordered">
			<thead>
				<tr>
					<td>NR</td>
					<td>Gerät</td>
					<td>Gewicht</td>
					<td>Wiederholung</td>
					<td>Sätze</td>';
			if($_canEdit){
				$_Result = $_Result . '<td>Edit</td>';
			}
			$_Result = $_Result . '
				</tr>
			</thead>
			<tbody>';
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.csv');
			_moveFirst();
			while(!_isEOF()){
				$_Result=$_Result . '<tr>';
				$_Result=$_Result . '<td>' . $_Count . '</td>';
				$_Result=$_Result . '<td>' . _read(0) . '</td>';
				$_Result=$_Result . '<td>' . _read(1) . ' KG</td>';
				$_Result=$_Result . '<td>' . _read(2) . ' mal</td>';
				$_Result=$_Result . '<td>' . _read(3) . ' Sätze</td>';
				if($_canEdit){
					$_Result=$_Result . '<td>
						<form name="FrmEdit" method="post">
							<input type="hidden" name="src" value="' . $_SERVER['REQUEST_URI'] . '" />
							<input type="hidden" name="DataID" value="' . _read(0) . '" />
							<button type="submit" class="btn btn-default" name="btnEdit" value="edit">Bearbeiten</button>
							<button type="submit" class="btn btn-default" name="btnDel" value="delete">X</button>
						</form>
					 </td>
					 </tr>';
				}
				 $_Count++;
				_moveNext();
			}
			_UnloadFile(FALSE);
			if(_getCursorPos()==0){
				
			}
			$_Result = $_Result . '</tbody></table>';
		}
		
		return $_Result;
	}
	
	//return a table withe the data of the last Training entry
	function _getLastTrainSession($_canEdit){
		$_Result="";
		$_LastTrainArr=array();
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
			_moveLast();
			$_LastTrainArr=_readArray();
			_UnloadFile(FALSE);
			$_ID=0;
			$_DateCreated="Kein Eintrag gefunden";
			if(!empty($_LastTrainArr)){
				//gets the ID of the Plan
				$_ID=$_LastTrainArr[0];
				//gets the date of creation
				$_DateCreated=$_LastTrainArr[1];
				//Delete this two
				unset($_LastTrainArr[0]);
				unset($_LastTrainArr[1]);
			}
			$_LastTrainArr=array_values($_LastTrainArr);
			$_Result='<p>Letzter Trainingseintrag vom: ' . $_DateCreated . '</p>';
			$_Result=$_Result . '<table class="table table-bordered">
			<thead>
				<tr>
					<td>Gerät</td>
					<td>Gewicht (KG)</td>
					<td>Wiederholung</td>
					<td>Sätze</td>';
			/*if($_canEdit){
				$_Result = $_Result . '<td>Edit</td>';
			}*/
			$_Result = $_Result . '
				</tr>
			</thead>
			<tbody>';
			
			//check if the array is empty
			if(!empty($_LastTrainArr)){
				$_TempString;
				$_TempString=implode(";",$_LastTrainArr);
				$_LastTrainArr=explode(";next;",$_TempString);
				//go throug each line and split the string
				for($x=0; $x<count($_LastTrainArr);$x++){
					$_LastTrainArr[$x] = explode(";",$_LastTrainArr[$x]);
				}
				
				foreach($_LastTrainArr as $_Arr){
					$_Result=$_Result . '<tr>';
					foreach($_Arr as $_Value){
						$_Result=$_Result . '<td>' . $_Value . '</td>';
					}
					$_Result=$_Result . "</tr>";
				}
			}
			$_Result = $_Result . '</tbody></table>';
		}
		//check if the Edit button should be integrated
		if($_canEdit){
			$_btnDisabled="";
			if($_ID==0){
				//when ID is 0 then disable the Edit and delete button
				$_btnDisabled='disabled="disabled"';
			}
			$_Result = $_Result . '
			<form name="FrmEdit" method="post">
				<input type="hidden" name="src" value="'.$_SERVER['REQUEST_URI'] .'" />
				<input type="hidden" name="EinheitID" value="' . $_ID . '" />
				<div class="row">
					<div class="col-md-1 ">
						<button type="submit" class="btn btn-default" name="btnDel"' . $_btnDisabled . 'value="del">Löschen</button>
					</div>
					<div class="col-md-1" style="margin-left: 3.5%;">
						<button type="submit" class="btn btn-default" name="btnEdit"' . $_btnDisabled . 'value="edit">Bearbeiten</button>
					</div>
					<div class="col-md-1" style="margin-left: 5%;">
						<button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
					</div>
				</div>
			</form>';	
		}
		
		return $_Result;
	}
	
	//return the Train History of the current user
	function _getHistoryTrainSession($_canEdit){
		$_Result="";
		$_LastTrainArr=array();
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
			_moveFirst();
			if(_isEOF() && _isBOF()){
				$_Result='<div class="alert alert-danger alert-dismissible" role="alert">
			  			<!--<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
			  			<strong>Achtung!</strong> Es sind keine Daten vorhanden.
						</div>';
			}
			while(!_isEOF()){
				$_LastTrainArr=_readArray();
				$_ID=0;
				$_DateCreated="Kein Eintrag gefunden";
				if(!empty($_LastTrainArr)){
					//gets the ID of the Plan
					$_ID=$_LastTrainArr[0];
					//gets the date of creation
					$_DateCreated=$_LastTrainArr[1];
					//Delete this two
					unset($_LastTrainArr[0]);
					unset($_LastTrainArr[1]);
				}
				$_LastTrainArr=array_values($_LastTrainArr);
				$_Result= $_Result . '<p>Trainingseintrag vom: ' . $_DateCreated . '</p>';
				$_Result=$_Result . '<table class="table table-bordered">
				<thead>
					<tr>
						<td>Gerät</td>
						<td>Gewicht (KG)</td>
						<td>Wiederholung</td>
						<td>Sätze</td>';
				/*if($_canEdit){
					$_Result = $_Result . '<td>Edit</td>';
				}*/
				$_Result = $_Result . '
					</tr>
				</thead>
				<tbody>';
				
				//check if the array is empty
				if(!empty($_LastTrainArr)){
					$_TempString;
					$_TempString=implode(";",$_LastTrainArr);
					$_LastTrainArr=explode(";next;",$_TempString);
					//go throug each line and split the string
					for($x=0; $x<count($_LastTrainArr);$x++){
						$_LastTrainArr[$x] = explode(";",$_LastTrainArr[$x]);
					}
					
					foreach($_LastTrainArr as $_Arr){
						$_Result=$_Result . '<tr>';
						foreach($_Arr as $_Value){
							$_Result=$_Result . '<td>' . $_Value . '</td>';
						}
						$_Result=$_Result . "</tr>";
					}
				}
				
				$_Result = $_Result . '</tbody></table>';
			
			//check if the Edit button should be integrated
			if($_canEdit){
				$_btnDisabled="";
				if($_ID==0){
					//when ID is 0 then disable the Edit and delete button
					$_btnDisabled='disabled="disabled"';
				}
				$_Result = $_Result . '
				<form name="FrmEdit" method="post">
					<input type="hidden" name="src" value="'.$_SERVER['REQUEST_URI'] .'" />
					<input type="hidden" name="EinheitID" value="' . $_ID . '" />
					<div class="row">
						<div class="col-md-1 ">
							<button type="submit" class="btn btn-default" name="btnDel"' . $_btnDisabled . 'value="del">Löschen</button>
						</div>
						<div class="col-md-1" style="margin-left: 3.5%;">
							<button type="submit" class="btn btn-default" name="btnEdit"' . $_btnDisabled . 'value="edit">Bearbeiten</button>
						</div>
					</div>
				</form><br/>';	
			}
			_moveNext();
			}
			_UnloadFile(FALSE);
		}
		return $_Result;
	}
	
	//returns a table with edit fields and buttons for editting
	function _getEditTrainSession($_ID){
		$_Result="";
		$_LastTrainArr=array();
		if(_checkSession()){
			if($_ID!=0){
				_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
				if(_Find($_ID,0)){
					$_LastTrainArr=_readArray();
					_UnloadFile(FALSE);
					$_ID=0;
					$_DateCreated="Kein Eintrag gefunden";
					if(!empty($_LastTrainArr)){
						//gets the ID of the Plan
						$_ID=$_LastTrainArr[0];
						//gets the date of creation
						$_DateCreated=$_LastTrainArr[1];
						//Delete this two
						unset($_LastTrainArr[0]);
						unset($_LastTrainArr[1]);
					}
					$_LastTrainArr=array_values($_LastTrainArr);
					$_Result='<form role="form" name="FrmEditEinheit" id="FrmEditEinheit" method="post">';
					$_Result=$_Result . '<div class="form-group">
								<label for="datetimepicker">Datum</label>';
					$_Result=$_Result . '<input id="datetimepicker" class="form-control" name="EinheitDate" type="text" value="' . $_DateCreated . '">';
					$_Result=$_Result . '</div>';
					$_Result=$_Result . '<script type="text/javascript">';
					$_Result=$_Result . "jQuery('#datetimepicker').datetimepicker({
							 lang:'de',
							 i18n:{
							  de:{
							   months:[
							    'Januar','Februar','März','April',
							    'Mai','Juni','Juli','August',
							    'September','Oktober','November','Dezember',
							   ],
							   dayOfWeek:[
							    'So.', 'Mo', 'Di', 'Mi', 
							    'Do', 'Fr', 'Sa.',
							   ]
							  }
							 },
							 timepicker:false,
							 format:'d.m.Y'
							});
							</script>";
					$_Result=$_Result . '<td><input type="hidden" class="form-control" name="EinheitID" value="' . $_ID . '"></td>';
					$_Result=$_Result . '<table class="table table-bordered">
					<thead>
						<tr>
							<td>Gerät</td>
							<td>Gewicht (KG)</td>
							<td>Wiederholung</td>
							<td>Sätze</td>';
					
					$_Result = $_Result . '
						</tr>
					</thead>
					<tbody>';
					
					//check if the array is empty
					if(!empty($_LastTrainArr)){
						$_count=1;
						$_TempString;
						$_TempString=implode(";",$_LastTrainArr);
						$_LastTrainArr=explode(";next;",$_TempString);
						//go throug each line and split the string
						for($x=0; $x<count($_LastTrainArr);$x++){
							$_LastTrainArr[$x] = explode(";",$_LastTrainArr[$x]);
						}
						
						foreach($_LastTrainArr as $_Arr){
							$_Result=$_Result . '<tr>';
							$_Result=$_Result . '<td>' . $_Arr[0] . '<input type="hidden" name="' . $_count . '" value="' . $_Arr[0] . '" /></td>';
							$_count++;
							$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . $_Arr[1] . '"></td>';
							$_count++;
							$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . $_Arr[2] . '"></td>';
							$_count++;
							$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . $_Arr[3] . '"></td>';
							$_count++;
							$_Result=$_Result . "</tr>";
						}
					}
					$_Result = $_Result . '</tbody></table></form>';
				}
			}else{
			$_ID=0;
			$_count=1;
			$_DateCreated=date("d.m.Y");
			$_Result='<form role="form" name="FrmEditEinheit" id="FrmEditEinheit" method="post">';
			$_Result=$_Result . '<div class="form-group">
								<label for="datetimepicker">Datum</label>';
			$_Result=$_Result . '<input id="datetimepicker" class="form-control" name="EinheitDate" type="text" value="' . $_DateCreated . '">';
			$_Result=$_Result . '</div>';
			$_Result=$_Result . '<script type="text/javascript">';
			$_Result=$_Result . "jQuery('#datetimepicker').datetimepicker({
					 lang:'de',
					 i18n:{
					  de:{
					   months:[
					    'Januar','Februar','März','April',
					    'Mai','Juni','Juli','August',
					    'September','Oktober','November','Dezember',
					   ],
					   dayOfWeek:[
					    'So.', 'Mo', 'Di', 'Mi', 
					    'Do', 'Fr', 'Sa.',
					   ]
					  }
					 },
					 timepicker:false,
					 format:'d.m.Y'
					});
					</script>";
			$_Result=$_Result . '<td><input type="hidden" class="form-control" name="EinheitID" value="' . $_ID . '"></td>';
			$_Result=$_Result . '<table class="table table-bordered">
			<thead>
				<tr>
					<td>Gerät</td>
					<td>Gewicht (KG)</td>
					<td>Wiederholung</td>
					<td>Sätze</td>';
			
			$_Result = $_Result . '
				</tr>
			</thead>
			<tbody>';
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.csv');
			_moveFirst();
			while(!_isEOF()){
				$_Result=$_Result . '<tr>';
				$_Result=$_Result . '<td>' ._read(0) . '<input type="hidden" name="' . $_count . '" value="' ._read(0) . '" /></td>';
				$_count++;
				$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . _read(1) . '"></td>';
				$_count++;
				$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . _read(2) . '"></td>';
				$_count++;
				$_Result=$_Result . '<td><input type="text" class="form-control" name="' . $_count . '" value="' . _read(3) . '"></td>';
				$_count++;
				$_Result=$_Result . "</tr>";
				_moveNext();
			}
			_UnloadFile(FALSE);
			$_Result = $_Result . '</tbody></table></form>';
		}
		return $_Result;
	}
	}

	//Updates the Train session with the given values
	function _UpdateTrainSession($_ID,$_Array){
		$_Result=FALSE;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
			if(_Find($_ID,0)){
				_writeArray($_Array);
			}
			_UnloadFile(TRUE);
			$_Result=TRUE;
		}
		return $_Result;
	}
	
	//Adds the new Session
	function _AddTrainSession($_Array){
		$_Result=FALSE;
		$_NewID=0;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
			if(_moveLast()){
				$_NewID=_read(0)+1;	
			}else{
				$_NewID=1;
			}
			_Add();
			$_Array[0]=$_NewID;
			_writeArray($_Array);
			_UnloadFile(TRUE);
			$_Result=TRUE;
		}
		return $_Result;
	}
	
	//removes the entry of the Session
	function _DelTrainSession($_ID){
		$_Result=FALSE;
		if(_checkSession()){
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_SESSION['SelectedPlan'] . '/'. $_SESSION['SelectedPlan'] . '.Einheiten.csv');
			if(_Find($_ID,0)){
				_Del();
			}
			_UnloadFile(TRUE);
			$_Result=TRUE;
		}
		return $_Result;
	}
	
	//return a checkbox with the data of every plan
	function _getPlanCombobox(){
		$_result="";
		if(_checkSession()){
			$_result='<select name="SelectedPlan" class="form-control">';
			_LoadFile('Include/Daten/' . $_SESSION['username'] . '/Plaene.csv');
			_moveFirst();
			while(!_isEOF()){
				$_result= $_result . '<option name="selectionPlan" value="' . _read(0) . '" ';
				if($_SESSION['SelectedPlan']==_read(0)){
					$_result = $_result . "selected";
				}
				$_result = $_result . ' >' . _read(1) . '</option>';
				_moveNext();
			}
			_UnloadFile(FALSE);
			$_result =$_result . '</select>';
		}
		return $_result;
	}
	
	//returns a table for editing a Plan
	function _getEditPlanTab($_ID,$_AddRows){
		$_Result="";
		$_createDate="";
		$_PlanName="";
		//$_AddRows=0;
		$_Count=1;
		global $_fp;
		global $_ArrTable;
		global $_CursorPos;
		//the end of the file
		global $_MaxPos;
		//Defines the END and the Beginning of a File
		global $_EOF;
		global $_BOF;
		
		if(_checkSession()){
			//Defines the header
			$_Result='<form role="form" name="FrmEditPlan" id="FrmEditPlan" method="post">';
			$_Result=$_Result . '<table class="table table-bordered">
			<thead>
				<tr>
					<td style="width:20%;">Gerät</td>
					<td>Gewicht (KG)</td>
					<td>Wiederholung</td>
					<td>Sätze</td>';
			/*if($_canEdit){
				$_Result = $_Result . '<td>Edit</td>';
			}*/
			$_Result = $_Result . '
				</tr>
			</thead>
			<tbody>';
			//Sets the Body content
			if($_ID!=0){
				_LoadFile('Include/Daten/' . $_SESSION['username'] . '/Plaene.csv');
				_Find($_ID,0);
				$_PlanName=_read(1);
				$_createDate=_read(2);
				_UnloadFile(FALSE);
				_LoadFile('Include/Daten/' . $_SESSION['username'] . '/' . $_ID . '/'. $_ID . '.csv');
				_moveFirst();
				while(!_isEOF()){
					$_tempfp = $_fp;
					$_tempArrTable=$_ArrTable;
					$_tempCursorPos=$_CursorPos;
					//the end of the file
					$_tempMaxPos=$_MaxPos;
					//Defines the END and the Beginning of a File
					$_tempEOF=$_EOF;
					$_tempBOF=$_BOF;
					
					$_Result = $_Result . '<tr>';
					$_Result = $_Result . '<td>' ._getGeraetCombobox($_Count,_read(0)) . '</td>';
					$_Count++;
					
					$_fp = $_tempfp;
					$_ArrTable=$_tempArrTable;
					$_CursorPos=$_tempCursorPos;
					//the end of the file
					$_MaxPos=$_tempMaxPos;
					//Defines the END and the Beginning of a File
					$_EOF=$_tempEOF;
					$_BOF=$_tempBOF;
					
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . _read(1) . '"></td>';
					$_Count++;
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . _read(2) . '"></td>';
					$_Count++;
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . _read(3) . '"></td>';
					$_Count++;
					$_Result = $_Result . '</tr>';
					_moveNext();
				}
				_UnloadFile(FALSE);
			}else{
				
			}
			
			if($_AddRows>0){
				$_x=0;
				while($_AddRows>$_x){
					$_Result = $_Result . '<tr>';
					$_Result = $_Result . '<td>' ._getGeraetCombobox($_Count,"") . '</td>';
					$_Count++;
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . '' . '"></td>';
					$_Count++;
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . '' . '"></td>';
					$_Count++;
					$_Result = $_Result . '<td><input type="text" class="form-control" name="' . $_Count . '" value="' . '' . '"></td>';
					$_Count++;
					$_Result = $_Result . '</tr>';
					$_x++;
				}
			}
			
			$_Result = $_Result . '</tbody></table></form>';
		}
		return $_Result;
	}
	
	//Adds a new training plan withe the needed files and options
	function _AddTrainingPlan($_Name){
			
	}
	
	// Adds the User to the Database and creates the needed folders and files
	function _AddUser($_Username, $_Password){
		
	}
?>