<?php

namespace App\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Radan\Http\Controllers\APIController;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Models\Reception;
use App\Models\Patient;
use App\Models\ReceptionStatus;
use App\Resources\ReceptionResource;
use App\Requests\StoreReceptionRequest;
use App\Requests\UpdateReceptionRequest;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceptionRequest $request)
    {
        $patient = Patient::create($request->all());

        $reception = Reception::create([
            'patient_id' => $patient->id,
            'radio_type_id' => $request->get('radio_type_id'),            
        ]);

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
        
            
        // Return JSON response            
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );        
    }
}
