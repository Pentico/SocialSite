<?php

/**
 * Created by PhpStorm.
 * User: Tuane
 * Date: 2016/09/12
 * Time: 1:44 AM
 * Database management / access class : basic abstraction
 */
class Mysqldb
{
    /**
     * Allows multiple database connections each connection
     * is stored as an element in the array, and the active
     * connection is maintained in a variable
     * @var array
     */
    private $connections = array();

    /**
     * Tells the DB object which connection to use
     * setActiveConnection($id) allows us to change this
     * @var int
     */
    private $activeConnection = 0;

    /**
     * Queries which have been executed and the results cached for later,
     * primarily within the template engine
     * @var array
     */
    private $queryCache =array();

    /**
     * Data which has been prepared and then cached for later usage,
     * primarily within the template engine
     * @var array
     */
    private $dataCache = array();

    /**
     * Number of queries made during execution process
     * @var int
     */
    private $queryCounter = 0;

    /**
     * Record of the last query
     * @var
     */
    private $last;

    /**
     * Reference to the registry object
     * @var Registry
     */
    private $registry;

    /**
     * Mysqldb constructor.
     * @param Registry $registry
     */
    public function __construct( Registry $registry){
        $this->registry = $registry;
    }


}