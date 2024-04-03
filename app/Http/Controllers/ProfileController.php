<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    public function profileAction(Request $request, $edit = false) {

        $user = User::findOrFail(Auth::id());

        if($request->getMethod() == "POST"){
            $validated = $request->validate([
                'name' => 'required',
                'email'=> 'required|email',
            ]);
            $user->fill($validated)->save();
            return redirect()->route('profile')->with('success','Erfolgreich gespeichert');
        }
        return view('profile', compact('user', 'edit'));
    }

    public function deleteUser(Request $request){
        $user = User::findOrFail(Auth::id());
        $finances = Finance::where('user_id','=', $user->id)->get();
        foreach($finances as $finance){
            $finance->delete();
        }
        $user->delete();
        return redirect()->route('login');
    }
}
