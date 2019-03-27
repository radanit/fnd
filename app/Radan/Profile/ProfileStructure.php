<?php

/**
 * This file is part of Radan Profile, 
 *
 * This class provide common functionality to work with user profile radan package
 *
 * @package    radan/profile 
 * @license    MIT
 * 
 */

namespace App\Radan\Profile;

/**
 * Profile is a manager for user profile.
 *
 * @author Mehdi Riahimanesh <m.riahimanesh@radanit.ir>
 */

class ProfileStructure
{
    /**
     * Profile model instance          
     *
     * @var App/Radan/Profile/Models/Profile
     */
    protected $profile;

    /**
     * Profile structure collection          
     *
     * @var Collection
     */
    protected $structure;

    /**
     * Class constructor
     *
     * @param  ProfileModel $profile Profile model instance
     * @return ProfileStructure
     */
    public function __construct($profile = null)
    {
        $this->profile = $profile;
        $this->structure = $this->toCollect();
        return $this;
    }
    
    /**
     * Cast profile structure to laravel collection
     *    
     * @return Collection 
     */
    protected function toCollect()
    {
        $collection = collect([]);
        if (!is_null($this->profile)) {
            $structure = $this->profile->structure;
            $structure = (is_array($structure)) ? $structure : json_decode($structure,true);
            $collection =  collect($structure)->map(function($row) {
                return collect($row);
            });        
        }
        return $collection;
    }

    /**
     * Cast profile structure to laravel collection
     *    
     * @param string $key profile structure field name
     * @param string $attribute profile structure field attribute name
     * @return Array
     */
    public function getFields($key='name',$attribute=null,$fields=[])
    {
        // Cast to array
        $fields = (array) $fields;
        $fields = array_intersect($this->structure,$fields);
        
        // Define variables
        $arrResult = [];       
        
        // Check profile structure items
        foreach($fields as $field) 
        {            
            $arrResult[$field->get($key)] = $field->get($attribute);
        }       

        if (is_null($attribute)) return array_keys($arrResult);
            else return $arrResult;
    }   

    /**
     * Return profile structure fields name
     * 
     * @return array
     */
    public function keys($fields=[])
    {
        return $this->getFields('name',null,$fields);
    }

    /**
     * Return profile structure field and attributes
     * 
     * @return array
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        else {
            return $this->getFields('name',$property);
        }
    }
}
