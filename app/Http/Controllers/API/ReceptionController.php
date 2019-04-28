<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\Patient;
use App\Models\ReceptionStatus;
use App\Http\Resources\ReceptionResource;
use App\Http\Requests\StoreReceptionRequest;
use App\Http\Requests\UpdateReceptionRequest;
use App\Events\ReceptionStatusEvent;
use Profile;

class ReceptionController extends APIController
{
    /**
     * Bind Model to Controller
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = Reception::class;

    /**
     * Relations for eger loading
     * 
     * @var array
     */
    protected $relations = [
        'patient', 'radioType' , 'status'
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = ReceptionResource::class;

    protected $filterable = [
        'national_id'
    ];

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceptionRequest $request)
    {
        // Check patient exists or create new
        $patient = Patient::firstOrCreate([
            'username' => $request->get('national_id')
        ]);        

        if (isset($patient->wasRecentlyCreated) && !$patient->wasRecentlyCreated) {
            $patient = Patient::find($patient->id);
            $patient->update([
                'username' => $request->get('national_id'),                
            ]);
        }        
    
        // Create reception 
        $reception = Reception::create($request->all());
        $status = $reception->status()->create(
            ['status' => ReceptionStatus::FIRST]
        );
                
        // Raise Reception Recepted event
        event(new ReceptionStatusEvent($reception,$status));
        
        // Return JSON response            
        return response()->json([
            'message' => __('app.insertAlert')],
            $this->httpOk
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceptionRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = Reception::findOrfail($id);        

        // Check reception status, if in recepting
        if ($reception->lastStatus()->status !== ReceptionStatus::LAST) {
            
            // update patinet
            $reception->patient()->update([
                'username' => $request->get('national_id'),
            ]);

            // update reception
            $reception->update($request->only(
                'national_id',
                'first_name',
                'last_name',
                'mobile',
                'birth_year',
                'gender',
                'doctor_id',
                'radio_type_id',
                'reception_date'
            ));

            // Return JSON response
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );
        }
        else {
            // Return JSON response
            return response()->json([
                'message' => __('app.failedAlert')],
                $this->httpForbidden
            );
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    
    {
        // destroy profile
        $reception = Reception::findOrFail($id);        

        // Check reception status, if in recepting
        if ($reception->lastStatus()->status !== ReceptionStatus::LAST) {

            // Destory profile
            $reception->delete();
            
            // Return
            return response()->json([
                'message' => __('app.deleteAlert')],
                $this->httpOk
            );
        } else {
            // Return JSON response
            return response()->json([
                'message' => __(
                    'bahar.reception.protected',
                    $reception->lastStatus()->status
                )],
                $this->httpForbidden
            );
        }
    }

    /**
     * Apply query filters validation rules
     * 
     * 
     * @return array of laravel validation rules
     */
    protected function filterRules() 
    {
        return ['national_id' => 'digits:10'];
        //return [];
    }

    /**
     * Set query filter
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function filter($query)
    {
        return $query->where('national_id',$this->getFilter('national_id'));
    }
}
