<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Radan\Http\Controllers\APIController;
use App\Models\Reception;
use App\Models\ReceptionStatus;
use App\Models\Doctor;


class ReceptionStatisticsController extends APIController
{

    protected $filterable = [
    ];

    protected $data;

    public function index()
    {
        $this->collectData();
        return response()->json($this->data,$this->httpOk);
    }
    
    protected function collectData()
    {
        // Number of all receptions
        $this->data['reception_counts'] = Reception::count();

        // Number of all doctors
        $this->data['doctor_counts'] = Doctor::active()->count();

        // Today receptions
        $this->data['today_receptions'] = Reception::whereDate('reception_date',Carbon::today())->count();

        // Compeleted receptions
        $this->data['complete_receptions'] = Reception::whereStatus(ReceptionStatus::COMPLETED)->count();
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
