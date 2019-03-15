<?php

namespace App\Radan\Profile;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use Validator;
use Auth;
use App\Radan\Profile\Models\Profile as ProfileModel;

/**
 * This file is part of Radan Profile, 
 *
 * This class provide common functionality to work with user profile radan package
 *
 * @package    radan/profile 
 * @license    MIT
 * 
 */
class Profile
{
    /**
     * The storage define in service provider          
     *
     * @var Storage
     */
    protected $disk;

    /**
     * The storage define in service provider          
     *
     * @var ProfileModel
     */
    protected $profile;

    public function __construct(FileSystem $disk)
    {
        $this->disk = $disk;
    }

    /**
     * Make Profile instance by id or name
     *
     * @param  mixed  $key  profile id or name
     * @return Profile
     */
    public function make($key)
    {
        if (is_string($key)) {
            $this->profile = ProfileModel::where('name',$key)->get();
            dd($this->profile->structure);
        } else if (is_int($key) and $key>0) {
            $this->profile = ProfileModel::find($key);
        }
        return $this;
    }
    
    /**
     * Cast profile structure to laravel collection
     *    
     * @return Collection 
     */
    public function toCollect()
    {        
        $collection = null;
        if (!is_null($this->profile)) {
            $structure = $this->profile->structure;
            $structure = (is_array($structure)) ? $structure : json_decode($structure);
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
     * @param string $value profile structure field attribute name
     * @return Array
     */
    public function getFields($key='',$value='')
    {        
        // Define variables
        $fields = [];
        $structure = $this->toCollect();
        
        // Check profile structure items
        foreach($structure as $item) {            
            $fields[$item->get($key)] = $item->get($value);            
        }
        return $fields;
    }
    
    protected function validate(Request $request)
    {
        // Define validation eules Array
        $rules = $this->getProfileFields($profile->structure,'name','rules');
        $fields = array_keys($rules);

        // run validation
        Validator::make($request->only($fields),$rules)->validate();
        return true;
    }

    protected function save(Request $request)
    {
        $fieldTypes = $this->getProfileFields($profile->structure,'name','type');
        $fields = array_keys($fieldTypes);        
        $profileData = $request->only($fields);
        dd($profileData);

        foreach ($request->only($fields) as $key => $value)
        {
            if ($fieldTypes[$key] == 'file') {

            }            
        }

       
    }
}
