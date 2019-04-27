<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\RadioType;
use App\Resources\ReceptionCaptureResource;
use App\Requests\UpdateReceptionCaptureRequest;
use App\Events\ReceptionStatusEvent;
use Profile;

class ReceptionCaptureController extends APIController
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
    protected $jsonResource = ReceptionCaptureResource::class;

    protected $filterable = [
        'national_id'
    ];

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceptionCaptureRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = Reception::findOrfail($id);

        $reception->attach($request);

        // Return JSON response
        return response()->json([
            'message' => __('app.updateAlert')],
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
    public function updateCapture(Request $request,$reception,$capture)
    {
        // Find resource or throw exception
        $reception = Reception::findOrfail($id);

        $reception->attach($request);

        // Return JSON response
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCapture($id,$reception,$capture)    
    {
        // destroy profile
        $reception = Reception::findOrFail($id);
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

    /**
     * Set data query
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function where($query)
    {        
        if ($this->user->hasRole('admin')) {
            return $query;
        }
        else {
            $radioType = RadioType::whereIn('role_id',$this->user->roles)->get()->toArray();
            return $query->whereIn('radio_type_id',$radioType);
        }
    }
}
