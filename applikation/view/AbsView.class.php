<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:07
 */

abstract class AbsView {
    /**
     * Path to the root folder of the Templates
     */
    public $path = 'ViewFiles/templates';

    /**
     * Defines which Template should be used
     */
    protected $Template;

    /**
     * the Content array which inherits the html code
     */
    protected $content = array();

    /**
     * sets to content of the view as key
     * @param $key: the key which identifies the Value
     * @param $value: the value for the key
     */
    public function setContent($key, $value) {
        $this->content[$key] = $value;
    }
    /**
     * sets the template
     * @param string $template: the template name for the view
     */
    public abstract function setTemplate($template);

    /**
     * Inserts the Loginbox into the Content Array
     * @param $Userdata array
     */
    public function DisplayLoginBoxLoggedIn($Userdata){
        $box= '<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Eingeloggt</div></div>
                        <div class="box_content">
                            <form name="FrmLogin" action="?controller='. $_GET['controller'] .'&action=logout" method="post">
                                <fieldset>
                                    <div class="panel-body" style="text-align: left;">
                                        <strong>Willkommen, '. $Userdata[0]['UserNickname'] .'</strong>
                                        <br />
                                        <br />
                                        Letztes Login erfolgte am: '. date("d.m.Y h:i",strtotime(@$Userdata[0]['UserLastLogin'])) .'
                                    </div>
                                    <br />

                                    <button type="submit" class="btn btn-default" name="btnLogout" value="Login">Ausloggen</button>
                                </fieldset>
                            </form>
                        </div>
                    <div class="clear"></div>
                </div>';
        $this->content['RightBoxes']= $box;
    }

    public function DisplayLoginBox($RegisterEnabled){
        $this->content['RightBoxes']= "";
        if($RegisterEnabled){

        }
        $box = '<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Login</div></div>
                    <div class="box_content">
						<form name="FrmLogin" action="?controller='. $_GET['controller'] .'&action=login" method="post">
							'. @$this->content['LoginMessage'] .'
							<fieldset>
								<!--<span class="input-group-addon">@</span>-->
								<input type="text" name="name" class="form-control" placeholder="Benutzername" required="">
								<br />
								<!--<span class="input-group-addon">@</span>-->
								<input type="password" name="password" class="form-control" placeholder="Passwort" required="">
								<br />
                                <button type="submit" class="btn btn-default" name="btnLogin" value="Login">Login</button>
                            </fieldset>
                        </form>
                    </div>
                <div class="clear"></div>
                </div>';
        $this->content['RightBoxes']= $box;
    }

    /**
     * @param $message
     * @param $MessageTyp int declaration for the Message Level
     * 0 important message
     * 1 attention
     * 2 Warning
     * 3 Error
     * @param $isDismissible:boolean declare if the box should be dismissible or not
     * @param $key string which should be used in the content array
     */
    public function DisplayMessageLabel($message, $MessageTyp, $isDismissible, $key){
        switch($MessageTyp){
            case 0:
                $class = "alert alert-success";
                $Titel = "Erfolgreich!";
                break;
            case 1;
                $class = "alert alert-info";
                $Titel = "Information!";
                break;
            case 2:
                $class = "alert alert-warning";
                $Titel = "Warnung!";
                break;
            case 3:
                $class = "alert alert-danger";
                $Titel = "Achtung!";
                break;
            default:
                $class = "alert alert-success";
                $Titel = "Erfolgreich!";
                break;
        }
        if($isDismissible){
            $class = $class . " alert-dismissible";
            $html = '<div class="'. $class .'" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Schliessen</span></button>
                    <strong>'. $Titel .'</strong> ' . $message .'
                </div>';
        }else{
            $html = '<div class="'. $class .'" role="alert">
                    <strong>'. $Titel .'</strong> ' . $message .'
                </div>';
        }
        if($key=""){
            return $html;
        }else {
            $this->content[$key] = $html;
        }
    }

    /**
     * Insert the Code for a Modal Window into the Content Array
     * @param string $content the inner html of the modal window
     */
    public function DisplayModalWindow($content){

    }

    /**
     * get template content
     * @return string: output of template
     */
    public function getTemplateContent() {
        if (file_exists($this->Template)) {
            ob_start(); // load content from file in a buffer, without run scripts
            include $this->Template;
            $output = ob_get_contents(); // save buffer
            ob_end_clean(); // clear buffer without running
            return $output;
        }
        return "Template cannot open.";
    }


} 