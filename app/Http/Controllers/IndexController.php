<?php

namespace App\Http\Controllers;

use App\FinanceType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;	
use Illuminate\Support\Carbon;

class IndexController extends Controller {
    public function indexAction():View{

        Auth::user()->with('finances')->get()->toArray();
        $finances = User::find(1)->finances;
        $totalIncome = [];
        $totalExpenses = [];
        $total = [];
        $date = Carbon::today()->startOfMonth();

        for($i = 0; $i < 12; $i++){
            $totalIncome[$date->format('M Y')] = $this->getTotalIncomeForMonth($date, $finances);
            $totalExpenses[$date->format('M Y')] = $this->getTotalExpensesForMonth($date, $finances);
            $total[$date->format('M Y')] = $this->getTotalIncomeForMonth($date, $finances) - $this->getTotalExpensesForMonth($date, $finances);
            $date->addMonth();
        }
        return view('index', [
            'totalIncome'=> $totalIncome,
            'totalExpenses'=> $totalExpenses,
            'total'=> $total,
        ]);
    }

    /**
     * gets total Income or Expenses by FinanceType
     */
    private function getTotalByType(FinanceType $type, Carbon $date, $finances):float{
        $totalIncome = 0;
        $firstDayOfMonth = $date->copy();
        $lastDayOfMonth = $date->copy()->lastOfMonth();
        foreach($finances as $finance){
            if($finance["type"] === $type){
                if($finance->monthly){
                    if($finance['date'] <= $lastDayOfMonth){
                        $totalIncome += $finance['amount'];
                    }
                } else {
                    if($finance['date'] >= $firstDayOfMonth && $finance['date'] <= $lastDayOfMonth){
                        $totalIncome += $finance['amount'];
                    }
                }
            }
        }
        return $totalIncome;
    }

    public function getTotalIncomeForMonth($date, $finance):float{
        return $this->getTotalByType(FinanceType::Income, $date, $finance);
    }

    public function getTotalExpensesForMonth($date, $finance): float{

        return $this->getTotalByType(FinanceType::Expenses, $date, $finance);
    }

}