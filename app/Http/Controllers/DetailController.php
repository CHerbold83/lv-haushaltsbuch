<?php

namespace App\Http\Controllers;

use App\FinanceType;
use App\Models\Finance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DetailController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    public function detailAction($date){

        $monthlyIncome = $this->getFinance(true, FinanceType::Income, $date);
        $oneTimeIncome = $this->getFinance(false, FinanceType::Income, $date);
        $monthlyExpenses = $this->getFinance(true, FinanceType::Expenses, $date);
        $oneOffExpenses = $this->getFinance(false, FinanceType::Expenses, $date);
        $total = $this->getTotal($monthlyIncome, $oneTimeIncome, $monthlyExpenses, $oneOffExpenses);

        $month = [
            "Monatliches Einkommen"=>$monthlyIncome,
            "Einmaliges Einkommen"=>$oneTimeIncome,
            "Monatliche Ausgaben"=>$monthlyExpenses,
            "Einmalige Ausgaben"=>$oneOffExpenses,
        ];

        return view('detail', [
            'month'=> $month,
            'total'=> $total,
            'date'=> $date,
        ]);

    }

    public function deleteFinance($id, $date){
        
        $finance = Finance::find($id);
        if( $finance['id'] != null && $finance['user_id'] == Auth::user()->id){
            $finance->delete();
            return redirect()->route('detail', $date)->with('success','Erfolgreich gelöscht');
        } else {
            return redirect()->route('detail', $date)->with('error','Kann nicht gelöscht werden');
        }
    }

    /**
     * gets the finance by date, monthly and type
     */
    public function getFinance(bool $monthly, FinanceType $type, $date):array{

        Auth::user()->with('finances')->get()->toArray();
        $finances = User::find(Auth::user()->getAuthIdentifier())->finances;

        $fullDate = date('Y-m-d H:i:s', strtotime($date));
        $firstDayOfMonth = Carbon::createFromFormat('Y-m-d H:i:s', $fullDate);
        $lastDayOfMonth = $firstDayOfMonth->copy()->lastOfMonth();
        $financesOfMonth = [];
        $entries = [];
        
        //checks finances for monthly and type and returns matching entries
        foreach($finances as $finance){
            if($finance->type == $type && $finance->monthly == $monthly){
                $entries[] = $finance;
            }
        }

        //check if finance will be shown in selected month 
        foreach($entries as $entry){
            $modelDate = Carbon::createFromDate($entry->date);
            //if monthly: check if date is before or now
            if($entry->monthly){
                if($modelDate->getTimestamp() <= $lastDayOfMonth->getTimestamp()){
                    $financesOfMonth[] = $entry;
                }
            } else {
                //else: date must be between first day of selected month and last day
                if($modelDate->format('Y-m-d') >= $firstDayOfMonth->format('Y-m-d') &&
                    $modelDate <= $lastDayOfMonth){
                    $financesOfMonth[] = $entry;
                }
            }
        }
        return $financesOfMonth;
    }

    /**
     * gets total of all income and expenses
     */
    public function getTotal($mIncome, $oIncome, $mExpenses, $oExpenses):float{
        $total = 0.0;
        foreach($mIncome as $income){
            $total += (double)$income->amount;
        }
        foreach($oIncome as $income){
            $total += $income->amount;
        }
        foreach($mExpenses as $expense){
            $total -= $expense->amount;
        }
        foreach($oExpenses as $expense){
            $total -= $expense->amount;
        }
        return $total;
    }
}