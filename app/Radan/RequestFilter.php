<?php

namespace App\Radan;

abstract class RequestFilter
{
    protected static $ruleDelimeter = ':';
    protected static $paramsDelimeter = ',';

    /**
     * Request cast filter rules
     * 
     * @var array
     */
    protected static $rules = [
        'array' => 'toArray',
        'json' => 'toJson',
        'boolean' => 'toBoolean',
        'set' => 'set',
        'remove' => 'remove',
        'unsetIfNull' => 'unsetIfNull',
    ];

    /**
     * Get rule names
     * 
     * @return array
     */
    public static function rules() 
    {
        return array_keys(self::$rules);
    }

    /**
     * Get rule name
     * 
     * @return string
     */
    public static function getRule($rule) 
    {
        $ruleName = false;
        if (isset($rule)) {
            $ruleBroken = explode(self::$ruleDelimeter,$rule)[0];
            $ruleName = in_array($ruleBroken,self::rules()) ? $ruleBroken:false;
        }
        return $ruleName;
    }

    /**
     * Get rule parameters
     * 
     * @return string
     */
    public static function getParams($rule) 
    {
        $params = [];
        if ($ruleName = self::getRule($rule)) {
            $ruleParams = str_replace($ruleName.self::$ruleDelimeter,'',$rule);
            $params = explode(self::$paramsDelimeter,$ruleParams);            
        }
        return $params;
    }

    /**
     * Get rule method name
     * 
     * @return mixed string if method exists, otherwise false
     */
    public static function getMethod($rule) 
    {        
        $method = false;
        if ($rule = self::getRule($rule)) {            
            $method = self::$rules[$rule];
            $method = method_exists(get_called_class(),$method) ? $method:false;            
        }
        return $method;
    }

    /**
     * Apply request filter
     * 
     * @param  parameterBag $request Http request parameter bag
     * @param  string  $key  request parameter bag key
     * @param  string  $rule filter rule
     * @return void
     */
    public static function apply(&$request,$key,$rule)
    {
        if (isset($request) && isset($key))
        {
            if ( $method = self::getMethod($rule))
            {
                $newValue = self::$method($request,$key);
                if (isset($newValue)) {
                    $request->replace(array_merge($request->all(), [$key => $newValue]));
                }
            }
        }
    }

    /**
     * 
     * Impliment filter rules
     * 
     */

    protected static function toArray($request,$key)
    {
        $value = $request->get($key);       
        if (!is_array($value)) {            
            $value = json_decode($value,true);
        }
        if (!is_array($value) and isset($delimeter)) {
            $value = explode($delimeter,$value);
        } else {
            $value = (array) $value;            
        }
        return $value;
    }

    protected static function toJson($request,$key)
    {
        $value = $request->get($key);
        if (is_array($value))
            $value = json_encode($value);
        return $value;
    }

    protected static function remove(&$request,$key)
    {
        if (isset($key)) {
            $request->remove($key); 
        }        
    }

    protected static function unsetIfNull(&$request,$key)
    {        
        if (empty($request->get($key))) {
            $request->remove($key); 
        }        
    }

    protected static function toBoolean($request,$key)
    {
        $value = $request->get($key);        
        if (is_string($value)) {             
            if (strtoupper($value) == 'TRUE') {                
                return 1;
            } 
            else {                
                return 0;
            }
        }
        else {            
            return (bool) $value;
        }
    }

    protected static function set($request,$key)
    {
        if (is_string($value)) {            
            if (ucwords($value) == ucwords('TRUE')) {
                return true;
            } 
            else {
                return false;
            }
        }
        else {
            return (bool) $value;
        }
    }
}

/*
const ToArrayRule='array';
    const ToJsonRule='json';
    const RemoveRule='remove';
    const UnsetIfNullRule='unsetIfNull';
    const ToBooleanRule='boolean';
    */