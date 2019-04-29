<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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
        'national_id'
    ];

    protected function upload($file)
    {
        try {

            $media = MediaUploader::fromSource($file)
            
            // specify a disk to use instead of the default
            ->toDisk('reception_disk')

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

        // Read all Radiography jpg type
        $graphyJpg = $request->file('graphy_jpg');    
        $graphyJpgMedia = [];
        foreach ($graphyJpg as $file) {
            $graphyJpgMedia[] = $this->upload($file);            
        }

        // Read all Radiography jpg type
        $graphyDicom = $request->file('graphy_dicom');    
        $graphyDicomMedia = $this->upload($graphyDicom);

        $reception->syncMedia($graphyJpgMedia,'graphy_jpg');
        $reception->syncMedia($graphyDicomMedia,'graphy_dicom');

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
        $query = $query->whereHas('status', function ($query) {
            $query->where('status',ReceptionStatus::FIRST);
        });

        if ($this->user->hasRole('admin')) {
            return $query;
        }
        else {
            $radioType = RadioType::whereIn('role_id',$this->user->roles)->get()->toArray();
            return $query->whereIn('radio_type_id',$radioType);
        }
    }
}
