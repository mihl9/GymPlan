<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 23.10.2014
 * Time: 14:08
 */

abstract class AbsModel {
    protected $database;

    public function __construct() {
        $this->database = new DatabaseHandler();
    }
} 