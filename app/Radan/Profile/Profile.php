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
    public function __construct(FileSystem $disk,$isDataBag = false)
    {
        if (is_null($disk)) {
            $disk = \Storage::disk('profile_disk');
        }
        $this->disk = $disk;
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
     * Set profile disk for store file base profile data
     *
     * @param  FileSystem  $disk Laravel FileSystem disk
     * @return Profile
     */
    public function setDataBag($bagName)
    {
        if (!empty($bag)) {
            $this->isDataBag = true;
            $this->dataBagFieldName = $bag;
        }
        return $this;
    }

    /**
     * Get profile disk for store file base profile data
     *    
     * @return FileSystem Laravel FileSystem disk
     */
    public function getDataBag($data)
    {
        if (is_array($data) && key_exists($this->dataBagFieldName,$data)) {
            $dataBag = $data[$this->dataBagFieldName];
            unset($data[$this->dataBagFieldName]);
            $dataBag = (is_array($dataBag)) ? $dataBag : json_decode($dataBag,true);
            $data = array_merge($dataBag,$data);
        }
        return $data;
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
    public function getFields($key='name',$value=null)
    {        
        // Define variables
        $fields = [];
        $structure = $this->toCollect();
        
        // Check profile structure items
        foreach($structure as $item) {            
            $fields[$item->get($key)] = $item->get($value);            
        }

        if ($this->isDataBag and !key_exists($this->dataBagFieldName,$fields)) {
            $fields[$this->dataBagFieldName] = '';
        }

        if (is_null($value)) return array_keys($fields);
            else return $fields;
    }   
    
    /**
     * Validate profile data by rule field in profile structure
     *    
     * @param Illuminate\Http\Request $request http request bag     
     * @return mixed return true on validate or raise exception on fail
     */
    public function validate($data)
    {
        // Define validation eules Array
        $rules = $this->getFields('name','rules');
        
        // run validation
        Validator::make($data ,$rules)->validate();        
    }
    
    /**
     * Save user profile data send in Illuminate\Http\Request
     *    
     * @param Illuminate\Http\Request $request http request bag
     * @return ProfileUser return ProfileUser model instance saved or failed
     */
    public function create($user,$data)
    {
        // Get profile fields and filed types
        $fields = $this->getFields();
        $fieldTypes = $this->getFields('name','type');        

        foreach ($data as $key => $value)
        {        
            if ($fieldTypes[$key] == 'file' and $data[$key]) {
                // Upload file
                $filePath = $this->disk->putFile('',$data[$key]);                
                
                // Save changes                                   
                $data[$key] = $this->disk->url($filePath);                
            }
        }
         
        // Create new profile
        $user->profile()->crete([
                'data' => $data,
                'profile_id' => $this->profile->id
        ]);                

        return $data;
    }

    /**
     * Save user profile data send in Illuminate\Http\Request
     *    
     * @param Illuminate\Http\Request $request http request bag
     * @return ProfileUser return ProfileUser model instance saved or failed
     */
    public function update($user,$data)
    {
        // Get profile fields and filed types
        $fields = $this->getFields();
        $fieldTypes = $this->getFields('name','type');                
        $oldProfileData = is_null($user->profile) ? []:$user->profile->data;
        $oldFilePath = [];

        foreach ($data as $key => $value)
        {        
            if ($fieldTypes[$key] == 'file') {
                if ($data[$key]) {
                    // Upload file
                    $filePath = $this->disk->putFile('',$data[$key]);
                    
                    // save for Delete old user files
                    $oldFilePath[] = key_exists($key,$oldProfileData) ? $oldProfileData[$key]:'';
                    
                    // Save changes                                   
                    $oldProfileData[$key] = $this->disk->url($filePath);
                }
            }
            else {
                $oldProfileData[$key] = $value;
            }
        }
        
        // Update user profile data        
        $profileUser = $user->profile()->first();
        $profileUser->profile_id = $this->profile->id;
        $profileUser->data = $oldProfileData;
        $user->profile()->save($profileUser);
                
        // Delete old files
        foreach($oldFilePath as $file) {            
            $this->disk->delete(basename($file));
        }

        return $oldProfileData;
    }
}
