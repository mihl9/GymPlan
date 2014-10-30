<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 14:07
 */

final class FWSessionHandler {
    /**
     * @access private static
     * @var SessionHandler $instance
     *
     * Saces the only Instanz of this class (Singleton)
     */
    private static $instance;

    /**
     * @access private static
     * @var string
     *
     * The value declares under which Key the Session is saved
     */
    private static $sessionArrayKey = "__sessiondata";

    /**
     * @access public
     * @param string $key
     * @param mixed $value
     *
     * allows to save the Data into the Session
     */
    public function __set($key, $value)
    {
        $_SESSION[FWSessionHandler::$sessionArrayKey][$key] = $value;
    }

    /**
     * @access public
     * @param string $key
     * @return bool
     *
     * allows to delete the Data in the Session
     */
    public function __unset($key)
    {
        if($this->exists($key))
        {
            unset($_SESSION[FWSessionHandler::$sessionArrayKey][$key]);
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @access public
     * @param string $key
     * @return mixed|null
     *
     * allows the direct read access on the Session Variables
     */
    public function __get($key)
    {
        if($this->exists($key))
        {
            return $_SESSION[FWSessionHandler::$sessionArrayKey][$key];
        }
        else
        {
            return null;
        }
    }

    /**
     * @access public
     * @param string $key
     * @return bool
     *
     * returns true, if $key exist
     * else false
     */
    public function exists($key)
    {
        return (isset($_SESSION[FWSessionHandler::$sessionArrayKey][$key]) ? true : false);
    }

    /**
     * @access public
     * @param string $key
     * @return bool
     *
     * Check if the Session variable is set
     */
    public function __isset($key)
    {
        return $this->exists($key);
    }

    /**
     * @access public
     *
     * close the Session
     */
    public function close()
    {
        session_write_close();
    }

    /**
     * @access public
     * @param bool $del_old
     *
     * generates a new Session-ID
     */
    public function newID($del_old = false)
    {
        session_regenerate_id($del_old);
    }

    /**
     * @access public
     * @return string
     *
     * returns the current Session-ID
     */
    public function getID()
    {
        return session_id();
    }

    /**
     * @access public
     *
     * destroy the Session
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * @access public
     *
     * Destruktor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Implements the Singleton
     */

    /**
     * @access public static
     * @return SessionHandler
     *
     * check if already an instance is create and return it
     */
    public static function getInstance() {
        if(self::$instance === null)
        {
            self::$instance = new FWSessionHandler();
        }
        return self::$instance;
    }

    /**
     * @access private
     *
     * starts a new Session and saves the in the Array
     */
    private function __construct(){
        session_start();
        if(!isset($_SESSION[FWSessionHandler::$sessionArrayKey]))
        {
            $_SESSION[FWSessionHandler::$sessionArrayKey] = array();
        }
    }

    /**
     * @access private
     *
     * denied the copy function of this class
     */
    private function __clone(){}

} 