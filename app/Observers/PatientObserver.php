<?php

namespace App\Observers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Role;
use Profile;

class PatientObserver
{    
    /**
     * The attributes for handling IOC
     * 
     */
    protected $request;
    
    /**
     * Class constructor
     * 
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return parent user instance of patient
     * 
     * @param Patient $patient
     */
    private function getParentInstance(Patient $patient)
    {
        return get_parent_class($patient)::find($patient->id);
    }

    /**
     * Return patient role instance
     * 
     */
    private function getRoleInstanceId()
    {
        return Role::where('name',Patient::ROLE_NAME)->first()->id;
    }
    
    /**
     * Update or create patient profile
     * 
     * @param array
     */
    private function syncProfile(Patient $patient,array $attributes = [])
    {        
        if (isset($attributes)) {
            
            // Validate profile data
            Profile::set(Patient::PROFILE_TYPE)->validate($attributes);
            
            // Update or create Profile data
            if (Profile::has($patient)) {
                Profile::update($patient,$attributes);
            }
            else {
                Profile::create($patient,$attributes);
            }
        }

        return $patient;
    }
    
    /**
     * Attache patient role to user 
     * 
     * @param void
     */
    private function syncRole(Patient $patient,array $role)
    {
        // Get parent instance of patient        
        $user = $this->getParentInstance($patient);

        // Sync user role
        $user->syncRoles($role);

        return $patient;
    }

    /**
     * Handle the patient "saved" event.
     *
     * @param  \App\Models\Patient  $patient
     * @return void
     */
    public function saved(Patient $patient)
    {        
        $this->syncProfile($patient, $this->request->all());
        $this->syncRole($patient, [$this->getRoleInstanceId()]);
        return true;
    }

    /**
     * Handle the patient "force deleted" event.
     *
     * @param  \App\Models\Patient  $patient
     * @return void
     */
    public function forceDeleted(Patient $patient)
    {
        Profile::destroy($patient);        
        $this->syncRole($patient, []);
        return true;
    }
}
