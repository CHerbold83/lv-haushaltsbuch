<?php

namespace App\Http\Controllers;

use App\FinanceType;
use App\Models\Finance;	
use Illuminate\Http\Request;

class EditController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    public function indexAction(Request $request, $id = null) {

        $finance = Finance::findOrNew($id);
        
        if( $finance->$id === null){
            $finance->date = date("Y-m-d");
        }
        if($request->getMethod() == "POST"){
            $validated = $request->validate([
                'title' => 'required',
                'amount'=> 'required',
                'type'=> 'required',
                'date'=> 'nullable|date',
                'monthly' => 'bool',
            ]);
            $finance->fill($validated)->save();
            return redirect()->route('edit')->with('success','Erfolgreich gespeichert');
        }
        $financeTypes = FinanceType::values();
        return view('edit', compact('financeTypes','finance'));
    }
}