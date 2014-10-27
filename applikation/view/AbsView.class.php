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
    private $Template;

    /**
     * the Content array which inherits the html code
     */
    private $content = array();

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
     */
    public function DisplayLoginBoxLoggedIn($UserID, $Username, $LastLogin){

    }

    public function DisplayLoginBox($RegisterEnabled){
        $this->content['RightBoxes']= "";
    }

    /**
     * Insert the Code for a Modal Window into the Content Array
     */
    abstract public function DisplayModalWindow();

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