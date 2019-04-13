<?php

namespace App\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Radan\Http\Controllers\APIController;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Models\Patient;
use App\Resources\PatientResource;

class PatientController extends APIController
{
    /**
     * Bind Model to Controller
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = Patient::class;

    /**
     * Relations for eger loading
     * 
     * @var array
     */
    protected $relations = [
        'profile', 'receptions'
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = PatientResource::class;
}
