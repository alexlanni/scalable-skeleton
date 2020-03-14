<?php

/**
 * In questo file e' presenta la classe che estende PDO per la gestione delle connessioni
 *
 * @author Alessandro Lanni
 */

namespace Alanni\PDO;

/**
 * Class AdvancedPDO, extend della classe PDO con gestione della connessione RO o RW
 *
 * @package Alanni\PDO
 */
class AdvancedPDO extends \PDO
{

    const RW_CONNECTION = 'rw';
    const RO_CONNECTIONS = 'ro';

    private $connections = [];

    /**
     * AdvancedPDO constructor.
     *
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $rwConnectionConfig = $config['rw'];

        if(!is_array($rwConnectionConfig))
            throw new \Exception('No RW connection defined');

        // Setup RW Connection
        $dsnRW = sprintf('%s:dbname=%s;host=%s', $config['driver'] , $rwConnectionConfig['dbname'], $rwConnectionConfig['host']);
        $this->connections[self::RW_CONNECTION] = new \PDO($dsnRW,$rwConnectionConfig['user'],$rwConnectionConfig['password']);

        if( is_array($config['ro']) && count($config['ro']) > 0 )
        {
            $this->connections[self::RO_CONNECTIONS] = [];
            foreach ($config['ro'] as $roConfig)
            {
                $dsnRO = sprintf('%s:dbname=%s;host=%s', $config['driver'] , $roConfig['dbname'], $roConfig['host']);
                $this->connections[self::RO_CONNECTIONS][] = new \PDO($dsnRO,$roConfig['user'],$roConfig['password']);
            }
        }
    }

    /**
     * Override del metodo prepare()
     *
     * @param string $statement
     * @param array $driver_options
     * @return bool|\PDOStatement
     */
    public function prepare($statement, $driver_options = array())
    {
        $is_select = preg_match('/(.*)SELECT(.*)/',$statement);
        // Nel caso in cui nello statement fosse presente il costruttto SELECT, uso una delle connessioni RO ...
        if($is_select>0 && count($this->connections[self::RO_CONNECTIONS])>0)
        {
            $random = rand(0,count($this->connections[self::RO_CONNECTIONS])-1);
            $connection = $this->connections[self::RO_CONNECTIONS][$random];
        }else{ // ... altrimenti la connessione RW viene scelta
            $connection = $this->connections[self::RW_CONNECTION];
        }
        return $connection->prepare($statement, $driver_options);
    }
}