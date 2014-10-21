<?php
	/*
		Autor: Michael Huber
		Last change: 10.09.2014
		purpose: represents the datahandler for saving and editing files
	*/
	//Global Variables
	$_fp="";
	$_ArrTable=array();
	$_CursorPos=0;
	//the end of the file
	$_MaxPos=0;
	//Defines the END and the Beginning of a File
	$_EOF=FALSE;
	$_BOF=TRUE;
	// Defines the Delimiter
	$_Delimiter=";";
	
	//Save the path of the File into the global var
	function _LoadFile($_Path){
		//Load the global var
		global $_fp;
		//Save the path
		$_fp=$_Path;
		//Load the datat into the Array
		_LoadData();
	}
	
	//Load the Data into the Array
	function _LoadData(){
		//Load the global var
		global $_fp;
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		global $_Delimiter;
		//check if the path is empty
		if(!(empty($_fp)) and !($_fp=="")){
			//load the data into the Array
			$_ArrTable=file($_fp);
			//Sets the max 
			$_MaxPos=count($_ArrTable)-1;
			$_EOF=FALSE;
			$_BOF=TRUE;
			$_CursorPos=0;
			//go throug each line and split the string
			for($x=0; $x<count($_ArrTable);$x++){
				$_ArrTable[$x] = explode($_Delimiter,$_ArrTable[$x]);
			}
			//Check if it has Data
			if(empty($_ArrTable)){
				$_EOF=TRUE;
				$_BOF=TRUE;
			}
		}else{
			$_MaxPos=0;
			$_EOF=TRUE;
			$_BOF=TRUE;
			$_CursorPos=0;
		}
	}
	
	//Returns the current Position of the Cursor
	function _getCursorPos(){
		global $_CursorPos;
		return $_CursorPos;
	}
	
	//Returns the value of the EOF var
	function _isEOF(){
		global $_EOF;
		return $_EOF;
	}
	
	//Returns the value of the BOF var
	function _isBOF(){
		global $_BOF;
		return $_BOF;
	}
	
	//move to the next Datarecord
	function _moveNext(){
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		//check if the Array is emtpy
		if(!empty($_ArrTable)){
			// check if the Reader is in the End of file
			if($_EOF){
				return false;
			}else{	
				//move the cursor one step higher	
				$_CursorPos++;
				//check if the end is reached
				if($_CursorPos>$_MaxPos){
					$_EOF=TRUE;
				}
				//check if he left the beginning
				if($_CursorPos>0){
					$_BOF=FALSE;
				}
				return true;
			}		
		}
	}
	
	//move to the previous Datarecord
	function _movePrevious(){
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		//check if the Array is emtpy
		if(!empty($_ArrTable)){
			// check if the Reader is in the Beginning of file
			if($_BOF){
				return false;
			}else{	
				//move the cursor one step lower	
				$_CursorPos--;
				//check if the end is left
				if($_CursorPos<$_MaxPos){
					$_EOF=FALSE;
				}
				//check if he reached the beginning
				if($_CursorPos<=0){
					$_BOF=true;
				}
			}		
		}
	}
	
	//moves to the first position
	function _moveFirst(){
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		
		//check if the Array is emtpy
		if(!empty($_ArrTable)){	
			//move the cursor to the First position	
			$_CursorPos=0;
			//check if the end is reached
			if($_CursorPos>$_MaxPos){
				$_EOF=TRUE;
			}
			//check if  the beginning is reached
			if($_CursorPos<=0){
				$_BOF=true;
			}
			return true;	
		}else{
			return false;
		}
	}
	
	//moves to the last position
	function _moveLast(){
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		
		//check if the Array is emtpy
		if(!empty($_ArrTable)){	
			//move the cursor to the last position	
			$_CursorPos=$_MaxPos;
			//check if the end is reached
			if($_CursorPos>$_MaxPos){
				$_EOF=TRUE;
			}
			//check if  the beginning is reached
			if($_CursorPos<=0){
				$_BOF=true;
			}
			return true;	
		}else{
			return false;
		}
	}
	
	//Start the search from the beginning
	function _Find($_SearchString,$_ColumnNumber){
		$_Result=FALSE;
		global $_EOF;
		global $_BOF;
		_moveFirst();
		//check if the file end is reached
		while(!$_EOF){
			if (_read($_ColumnNumber)==$_SearchString){
				$_Result=TRUE;
				break;
			}
			_moveNext();
		}
		return $_Result;
	}
	
	//Start the Search from teh Current Position
	function _FindNext($_SearchString,$_ColumnNumber){
		$_Result=FALSE;
		global $_EOF;
		global $_BOF;
		//check if the file end is reached
		while(!$_EOF){
			if (_read($_ColumnNumber)==$_SearchString){
				$_Result=TRUE;
				break;
			}
			_moveNext();
		}
		return $_Result;
	}	
	
	//read out the Value of the overgiven Column
	function _read($_Column){
		$_Result="";
		global $_ArrTable;
		global $_CursorPos;
		//check if the Array is emtpy
		if(!empty($_ArrTable)){	
			$_Result=htmlspecialchars($_ArrTable[$_CursorPos][$_Column]);
		}
		
		return $_Result;
	}
	
	//read the whole Record and return it in a array
	function _readArray(){
		$_Result=array();
		global $_ArrTable;
		global $_CursorPos;
		//check if the Array is emtpy
		if(!empty($_ArrTable)){	
			$_Result=$_ArrTable[$_CursorPos];
		}
		
		return $_Result;
	}
	
	//write the Value into the column
	function _write($_Value,$_Column){
		$_Result=FALSE;
		global $_ArrTable;
		global $_CursorPos;
		//check if the Array is emtpy
		if(!empty($_ArrTable) || !(_isBOF() && _isEOF())){	
			//write the value
			$_ArrTable[$_CursorPos][$_Column]=htmlspecialchars($_Value);
			$_Result=TRUE;
		}
		
		return $_Result;
	}
	
	//write an Array into the current datarow
	function _writeArray($_Array){
		$_Result=FALSE;
		global $_ArrTable;
		global $_CursorPos;
		//check if the Array is emtpy
		if(!empty($_ArrTable)){
			if(is_array($_Array)){
				for($x=0; $x<count($_Array);$x++){
				$_Array[$x] = htmlspecialchars($_Array[$x]);
				}
				//clear the current position
				$_ArrTable[$_CursorPos]=array();
				//write the value
				$_ArrTable[$_CursorPos]=$_Array;
				$_Result=TRUE;
			}else{
				$_Result=FALSE;
			}
		}
		
		return $_Result;
	}
	
	//Adds a new entry at the last position
	function _Add(){
		$_Result=FALSE;
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_BOF;
		//go to the last position and count one up
		$_MaxPos=$_MaxPos+1;
		$_CursorPos=$_MaxPos;
		$_BOF=FALSE;
		//write the data
		if(_write("",0)){
			$_Result=TRUE;
		}
		
		return $_Result;
	}
	
	//delete the current Record
	function _Del(){
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_BOF;
		global $_EOF;
		//check if the array is Empty
		if(!empty($_ArrTable)){
			unset($_ArrTable[$_CursorPos]);
			$_ArrTable=array_values($_ArrTable);
			$_MaxPos--;
			//check if the last index is deleted
			if($_CursorPos>$_MaxPos){
				$_CursorPos--;
			}
			//check if the end is reached
			if($_CursorPos>=$_MaxPos){
				$_EOF=TRUE;
			}
			//check if  the beginning is reached
			if($_CursorPos<=0){
				$_BOF=true;
				$_CursorPos=0;
			}
		}
	}
	
	//Save the whole Data into the file
	function _SaveFile(){
		//Load the global var
		global $_fp;
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		global $_Delimiter;
		$_FileWriter;
		$_tempstring;
		//check if the path is empty
		if(!(empty($_fp)) and !($_fp=="")){
			$_FileWriter = fopen($_fp,"w");
			if($_FileWriter!=FALSE){
				for($x=0; $x<count($_ArrTable);$x++){
					$_tempstring = str_replace(array("\r\n", "\r", "\n"), '', implode($_Delimiter,$_ArrTable[$x]) . "");
					fwrite($_FileWriter,$_tempstring . "\n");
				}
				fclose($_FileWriter);
				return TRUE;
			}
		}else{
			return FALSE;
		}
	}
	
	//closes the datareader and saves the data if it is needed
	function _UnloadFile($_DoSave){
		$_Result=True;
		global $_fp;
		global $_ArrTable;
		global $_CursorPos;
		global $_MaxPos;
		global $_EOF;
		global $_BOF;
		
		//check if the save paramewter is true
		if($_DoSave){
			$_Result = _SaveFile();	
		}
		//resets all of the Variables
		$_fp="";
		$_ArrTable=array();
		$_CursorPos=0;
		$_MaxPos=0;
		$_EOF=TRUE;
		$_BOF=TRUE;
		
		return $_Result;
	}
	
	function _MakeFile(){
		
	}
?>