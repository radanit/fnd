<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\Patient;
use App\Models\ReceptionStatus;
use App\Resources\ReceptionResource;
use App\Requests\StoreReceptionRequest;
use App\Requests\UpdateReceptionRequest;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceptionRequest $request)
    {        
        $patient = Patient::firstOrCreate($request->all());
                
        $reception = Reception::create($request->all());

        $status = ReceptionStatus::create([
            'reception_id' => $reception->id,
            'status' => ReceptionStatus::FIRST,
        ]);        
        
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
        if ($reception->lastStatus()->status == ReceptionStatus::FIRST) {
            // update patinet
            $reception->patient()->update($request);

            // update reception
            $reception->update($request);

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
}
