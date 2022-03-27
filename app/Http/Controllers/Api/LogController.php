<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends BaseController
{
    public function all()
    {
        return $this->sendResponse(Activity::all());
    }
}
