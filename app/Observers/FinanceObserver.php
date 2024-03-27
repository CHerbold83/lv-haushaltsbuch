<?php

namespace App\Observers;

use App\Models\Finance;
use Auth;

class FinanceObserver {

    public function creating(Finance $model) {
        $this->user_id = Auth::user()->id;
    }
}