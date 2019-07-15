<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\ReceptionStatus;
use App\Models\RadioType;
use App\Models\ReceptionComment;
use App\Http\Resources\ReceptionCommentResource;
use App\Http\Resources\ReceptionCollection;
use App\Http\Requests\UpdateReceptionCommentRequest;
use App\Http\Requests\RejectReceptionCommentRequest;
use App\Events\ReceptionStatusEvent;
use App\Events\ReceptionSetVotesEvent;

class ReceptionCommentController extends APIController
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
        'patient', 'radioType' , 'status', 'results' , 'comments',
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = ReceptionCommentResource::class;

    /**
     * Api resource collection class name
     * 
     * @var Illuminate\Http\Resources\Json\ResourceCollection
     */
    protected $resourceCollection = ReceptionCollection::class;

    protected $filterable = [
        'national_id', 'status',
    ];    
     
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceptionCommentRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->whereStatus(ReceptionStatus::CAPTURED)->findOrfail($id);

        // Set result for reception
        $this->doReceptionResult($request,$reception,ReceptionStatus::COMPLETED);

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
    public function destroyComment(RejectReceptionResultRequest $request, $id)
    {
        // Find resource or throw exception
        $reception = $this->getModel()->whereStatus(ReceptionStatus::CAPTURED)->findOrfail($id);

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
        return [
            'national_id' => 'digits:10',
            'status' => 'nullable|in:recepted,captured,visited,completed,rejected',
        ];       
    }

    /**
     * Set query filter
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function filter($query)
    {        
        foreach($this->getFilter() as $key => $filter)
        {
            switch ($key) {
                case 'national_id':                     
                    $query = $query->where('national_id',$this->getFilter('national_id'));                    
                    break;
                case 'status':                    
                    $query = $query->whereStatus($this->getFilter('status'));
                    break;
            }            
        }

        return $query;
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
            return $query->where('doctor_id',$this->user->id);
        }
    }
}
