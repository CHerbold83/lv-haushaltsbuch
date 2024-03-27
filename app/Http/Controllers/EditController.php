<?php

namespace App\Http\Controllers;

use App\FinanceType;
use App\Models\Finance;	
use Illuminate\Http\Request;

class EditController extends Controller {
    public function indexAction(Request $request, $id = null) {

        $finance = new Finance();
        if( $id !== null ) {
            $finance = Finance::find($id);
        }

        if($request->getMethod() == "POST"){
            $validated = $request->validate([
                'title' => 'required',
                'amount'=> 'required',
                'type'=> 'required',
                'date'=> 'nullable|date',
                'monthly' => 'boolean',
            ]);
            $finance->fill($validated)->save();
            return redirect()->route('edit')->with('success','Erfolgreich gespeichert');
        }
        $financeTypes = FinanceType::values();
        return view('edit', compact('financeTypes','finance'));
    }
}