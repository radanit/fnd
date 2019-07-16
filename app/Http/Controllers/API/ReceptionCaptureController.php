<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\ReceptionStatus;
use App\Models\RadioType;
use App\Http\Resources\ReceptionCaptureResource;
use App\Http\Resources\ReceptionCollection;
use App\Http\Requests\UpdateReceptionCaptureRequest;
use App\Events\ReceptionStatusEvent;
use MediaUploader;
use Plank\Mediable\MediaUploadException;
use Plank\Mediable\Media;

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
        'national_id', 'status',
    ];

    private $oldGraphyDelete = true;
    private $graphyJpgTag = 'graphy_jpg';
    private $graphyDicomTag = 'graphy_dicom';
    private $graphyDisk = 'reception_disk';

    /**
     * Upload file with Media Managment
     * 
     * @param $file Symfony\Component\HttpFoundation\UploadedFile
     * @return boolean
     */
    protected function upload($file)
    {
        try {

            $media = MediaUploader::fromSource($file)
            
            // specify a disk to use instead of the default
            ->toDisk($this->graphyDisk)

            // place the file in a directory relative to the disk root
            ->toDirectory('captures')

            //->useFilename('graphy')

            ->useHashForFilename()    

            // maximum filesize in bytes
            ->setMaximumSize(2*1024*1024) // 2 MB

            // whether the aggregate type must match both the MIME type and extension
            ->setStrictTypeChecking(true)

            // whether to allow the 'other' aggregate type
            ->setAllowUnrecognizedTypes(false)

            // only allow files of specific MIME types
            ->setAllowedMimeTypes(['image/jpeg'])

            // only allow files of specific extensions
            ->setAllowedExtensions(['jpg', 'jpeg'])

            // only allow files of specific aggregate types
            ->setAllowedAggregateTypes(['image'])

            ->upload();

        } catch(MediaUploadException $e) {
            return response()->json([
                'message' => __('app.failedAlert')],
                $this->httpNotAcceptable
            );
        }        
        return $media;
    }

    /**
     * Delete related uploaded filesize
     * 
     * @param $reception App\Models\Reception
     * @return boolean
     */
    protected function deleteMedia($reception)
    {
        $oldMedia = $reception->getAllMediaByTag(); 
        foreach($oldMedia as $media)        
        {           
            $media->first()->delete();
        }        
    }
    
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
        $reception = $this->getModel()->findOrfail($id);

        // Read all Radiography jpg type
        $graphyJpg = $request->file($this->graphyJpgTag);        
        $graphyJpgMedia = [];
        foreach ($graphyJpg as $file) {
            $graphyJpgMedia[] = $this->upload($file)->getKey();            
        }

        // Read all Radiography jpg type
        $graphyDicom = $request->file($this->graphyDicomTag);    
        $graphyDicomMedia = $this->upload($graphyDicom);
       
        // Delete old media
        if ($this->oldGraphyDelete) {
            $this->deleteMedia($reception);
        }

        // Attache graphy to reception        
        $reception->syncMedia($graphyJpgMedia,$this->graphyJpgTag);      
        $reception->syncMedia($graphyDicomMedia,$this->graphyDicomTag);

        // Graphy result        
        if ($request->filled('graphy_result')) {
            $reception->update($request->only('graphy_result'));
        }

        // Raise Reception Recepted event
        $status = $reception->status()->create(
            ['status' => ReceptionStatus::CAPTURED]
        );
        event(new ReceptionStatusEvent($reception, $status));

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

        // Delete old media
        if ($this->oldGraphyDelete) {
            $this->deleteMedia($reception);
        }

        // Deattache media
        $reception->syncMedia([]);   
        
        // Return JSON response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($reception,$capture)    
    {
        // Find reception
        $reception = $this->getModel(false)->findOrFail($reception);  
        foreach($reception->media as $media)
        {            
            if ($media->getKey() == $capture) {
                return \Storage::disk($this->graphyDisk)->download($media->getDiskPath());
            }
        }

        throw(new ModelNotFoundException());
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
            //'status' => 'nullable|in:recepted,captured,visited,completed,rejected',
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
                    $status = explode('|', $this->getFilter('status'));                    
                    $query = $query->whereStatus($status);
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
            // Get user roles id in array format
            $userRoles = $this->user->roles->pluck('id')->all();

            // Get RadioTypes id witch assigne to specific role
            $radioType = RadioType::whereIn('role_id',$userRoles)->pluck('id')->all();

            // Return receptions with specific type
            return $query->whereIn('radio_type_id',$radioType);
        }
    }
}
