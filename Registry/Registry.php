<?php
/**
 * Created by PhpStorm.
 * User: Tuane
 * Date: 2016/09/12
 * Time: 1:18 AM
 * Registry class
 */

class Registry {

    /**
     * @var array of Objects
     */
    private $objects;

    /**
     * @var array of Settings
     */
    private $settings;

    public function  __construct(){

    }

    /**
     * @param $object string object file prefix
     * @param $key  string pair for the object
     */
    public function createAndStoreObject( $object, $key ){

        require_once ( $object . '.class.php');
        $this->objects[$key] = new $object( $this );
    }

    /**
     *  Store Setting
     * @param $settings
     * @param $key
     */
    public function storeSetting( $settings, $key) {
        $this->settings[$key] = $settings;
    }


    /**
     * Get an setting from the registries store
     * @param $key
     * @return mixed
     */
    public function getSetting( $key ) {
        return $this->settings[$key];
    }

    public function getObject( $key ) {
        return $this->objects[$key];
    }
}

?>