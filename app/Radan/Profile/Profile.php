<?php

namespace App\Radan\Profile;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use Validator;
use Auth;
use App\Radan\Profile\Models\Profile as ProfileModel;
use App\Radan\Profile\Models\ProfileUser as ProfileUserModel;

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
     * The Illuminate\Http\Request         
     *
     * @var Request
     */
    protected $request;

    /**
     * The storage define in service provider          
     *
     * @var ProfileModel
     */
    protected $profile;

    /**
     * For support profile data bag,
     * Name of profile data field          
     *
     * @var string
     */
    protected $isDataBag = false;
    protected $dataBagFieldName = 'profile_data';    

    /**
     * Class constructor
     *
     * @param  FileSystem  $disk Laravel FileSystem disk
     * @return Profile
     */
    public function __construct(FileSystem $disk,Request $request,$isDataBag = false)
    {
        if (is_null($disk)) {
            $disk = \Storage::disk('profile_disk');
        }
        $this->disk = $disk;
        $this->request = $request;
        $this->isDataBag = $isDataBag;
        return $this;
    }

    /**
     * Set profile disk for store file base profile data
     *
     * @param  FileSystem  $disk Laravel FileSystem disk
     * @return Profile
     */
    public function setDisk(FileSystem $disk) 
    {
        $this->disk=$disk;
        return $this;
    }

    /**
     * Get profile disk for store file base profile data
     *    
     * @return FileSystem Laravel FileSystem disk
     */
    public function getDisk()
    {        
        return $this->disk;
    }
    /**
     * Make Profile instance by id or name
     *
     * @param  mixed  $key  profile id or name
     * @return Profile
     */
    public function make($key,$isDataBag = false)
    {
        $this->profile = ProfileModel::find($key);     
        if (is_null($this->profile)) {
            $this->profile = ProfileModel::where('name',$key)->first();        
        }
        $this->isDataBag = $isDataBag;
        return $this;
    }
    
    /**
     * Cast profile structure to laravel collection
     *    
     * @return Collection 
     */
    protected function toCollect()
    {        
        $collection = null;
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
     * @param string $value profile structure field attribute name
     * @return Array
     */
    protected function getFields($key='name',$value=null)
    {        
        // Define variables
        $fields = [];
        $structure = $this->toCollect();
        
        // Check profile structure items
        foreach($structure as $item) {            
            $fields[$item->get($key)] = $item->get($value);            
        }

        if (is_null($value)) return array_keys($fields);
            else return $fields;
    }
    
    /**
     * Retrive profile data from http request
     *    
     * @param Illuminate\Http\Request $request http request bag     
     * @return array return array of profile data
     */
    protected function getProfileUserData($data) 
    {        
        $requestData = 
            ($this->isDataBag) ? 
            json_decode($this->request->input($this->dataBagFieldName),true):
            $this->request->only($this->getFields());

        $data = is_null($data) ? $requestData : $data;        
        if (is_null($data)) $data = [];
                
        return $data;
    }
    
    /**
     * Validate profile data by rule field in profile structure
     *    
     * @param Illuminate\Http\Request $request http request bag     
     * @return mixed return true on validate or raise exception on fail
     */
    public function validate($data=null)
    {
        // Define validation eules Array
        $rules = $this->getFields('name','rules');
        $requestData = $this->getProfileUserData($data);

        // run validation
        Validator::make($requestData ,$rules)->validate();
        return $this;
    }
    
    /**
     * Save user profile data send in Illuminate\Http\Request
     *    
     * @param Illuminate\Http\Request $request http request bag
     * @return ProfileUser return ProfileUser model instance saved or failed
     */
    public function save($user,$data=null)
    {
        // Get profile fields and filed types
        $fields = $this->getFields();
        $fieldTypes = $this->getFields('name','type');
        $profileData = $this->getProfileUserData($data);
       
        foreach ($profileData as $key => $value)
        {
            if ($fieldTypes[$key] == 'file') {
                if ($this->request->file($key)->isValid()) {
                    // Upload file
                    $filePath = $this->disk->putFile('',$this->request->file($key));                                    
                    
                    // Delete old user avatar
                    $oldFilePath = key_exists($key,$profileData) ? $profileData[$key]:'';        
                    $this->disk->delete(basename($oldFilePath));
                    
                    // Save changes                   
                    $profileData[$key] = $this->disk->url($filePath);
                }               
            }        
        }
        $profileUser = $user->profile()->first();               
        $profileUser->data = $profileData;
        $profileUser->profile_id = $this->profile->id;
        $user->profile()->save($profileUser);       
    }
}
