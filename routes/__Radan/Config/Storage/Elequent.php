<?php

namespace App\Radan\Config\Storage;

use Illuminate\Database\Eloquent\Model;

class Elequent implements StorageInterface
{
    /**
     * @var Base Elequent Model connection
     */
    protected $connection = '';

    /**
     * @var Base Elequent Model connection
     */
    protected $model = '';
    /**
     * constructor
     *
     * @param BasePdo $pdo      instance of pdo to execute the queries against
     * @param string $tableName the table name to reference
     * @param array $sqlQueries custom queries
     */
    public function __construct(Model $model,$connection = null)
    {        
        $this->model = $model;
        $this->connection = $connection;
        if ($this->connection) {            
            $this->model->setConnection($this->connection);
        }        
    }

    /**
     * @inheritdoc
     */
    public function save($key, $value)
    {                           
        // Check value is array, save config such
        // key.0 => $value[0],key.1 => $value[1],..        
        if (is_array($value)) {
            foreach ($value as $i => $arrValue) {
                $this->model->updateOrCreate(['key' => $key.'.'.$i ],[ 'value' => $arrValue]);
            }
            return;
        }

        // Save config key => value        
        $str=$this->model->updateOrCreate(['key' => $key],['value' => $value]);
    }

    /**
     * @inheritdoc
     */
    public function load()
    {        
        $results = [];
        $configs = $this->model->all();
        foreach ($configs as $config)        
        {
            $results[$config->key] = $config->value;            
        };
        return $results;
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->model->truncate();
    }
}
