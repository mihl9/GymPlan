<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:07
 */

abstract class AbsModel {
    protected $database;

    public function __construct() {
        $this->database = new DatabaseHandler();
    }
} 