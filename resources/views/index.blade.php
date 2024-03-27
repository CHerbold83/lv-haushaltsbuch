@extends('layouts.base')
@section('title', 'Home')

@section('header')
<h5 class="text-center">Übersicht</h5>
@endsection

@section('content')
<div class="container text-center">
    <a class="center btn btn-secondary" href="{{url('edit')}}">Hinzufügen</a>
    <div class="row">
        @foreach($totalIncome as $key => $income)
        <div class="w-25 m-3">
            <a href="{{URL::route('detail', ['date'=>$key], false)}}" style="text-decoration:none;">
                <div class="card" >
                    <div class="card-header">
                        <h6 class="card-title text-center">{{$key}}</h6>
                    </div>
                    <div class="card-body row">
                        <label class="w-50" for="income">Einkommen</label>
                        <p id="income" class="w-50">{{number_format($totalIncome[$key], 2, '.', ',')}} €</p>
                        <hr>
                        <label class="w-50" for="income">Ausgaben</label>
                        <p id="income" class="w-50">{{number_format($totalExpenses[$key], 2, '.', ',')}} €</p>
                        <hr>
                        <label class="w-50" for="income">Gesamt</label>
                        <p id="income" class="w-50">{{number_format($total[$key], 2, '.', ',')}} €</p>
                    </div>
                </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection