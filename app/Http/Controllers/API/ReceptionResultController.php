<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\ReceptionStatus;
use App\Models\RadioType;
use App\Models\ReceptionResult;
use App\Http\Resources\ReceptionResultResource;
use App\Http\Resources\ReceptionCollection;
use App\Http\Requests\UpdateReceptionResultRequest;
use App\Http\Requests\RejectReceptionResultRequest;
use App\Events\ReceptionStatusEvent;
use App\Events\ReceptionSetVotesEvent;

class ReceptionResultController extends APIController
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
        'patient', 'radioType' , 'status', 'results'
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = ReceptionResultResource::class;

    /**
     * Api resource collection class name
     * 
     * @var Illuminate\Http\Resources\Json\ResourceCollection
     */
    protected $resourceCollection = ReceptionCollection::class;

    /**
     * Allow query string parameters for filter
     * 
     * @var array
     */
    protected $filterable = [
        'national_id'
    ];   
    
    private function doReceptionResult($request,$reception,$status)    
    {
        // Add doctor recepton result
        $reception->results()->create(
            $request->only('result')    
        );

        if ($request->filled('votes')) {
            $reception->update(
                $request->only('votes')    
            );
            event(new ReceptionSetVotesEvent($reception));            
        }
        
        // Raise Reception Recepted event
        $status = $reception->status()->create([
            'status' => $status
        ]);
        
        event(new ReceptionStatusEvent($reception, $status));        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceptionResultRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->findOrfail($id);

        // Set result for reception
        $this->doReceptionResult($request,$reception,ReceptionStatus::VISITED);

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
        $reception = $this->getModel()->findOrFail($id);

        $resecption->results()->delete();
        
        // Return JSON response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }

    /**
     * Reject the specified reception.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(RejectReceptionResultRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->findOrfail($id);

        // Set result for reception
        $this->doReceptionResult($request,$reception,ReceptionStatus::REJECTED);

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
    public function setVotes(Request $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->findOrfail($id);

        // Add doctor recepton result
        $reception->update([
         'votes' => $request->get('votes')      
        ]);
        
        // Raise Reception Recepted event        
        event(new ReceptionSetVotesEvent($reception));

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
    public function getVotes(Request $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->findOrfail($id);        

        // Return JSON response
        return response()->json([
            'data' => $reception->votes],
            $this->httpOk
        );
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
        $query = $query->whereStatus(ReceptionStatus::CAPTURED);

        if ($this->user->hasRole('admin')) {
            return $query;
        }
        else {        
            return $query->where('doctor_id',$this->user->id);
        }
    }
}
