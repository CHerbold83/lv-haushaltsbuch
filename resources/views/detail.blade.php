@extends('layouts.app')

@section('title', 'Details')

@section('header')
<h5 class="text-center">Details</h5>
@endsection

@section('content')

        @if (session('error'))
        <div class="alert alert-danger">{{session()->get('error')}}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{session()->get('success')}}</div>
        @endif

<div class="card m-5">
    <div class="card-header">
        <h6 class="card-title text-center">{{$date}}</h6>
    </div>
    <div class="card-body">
        @foreach($month as $key => $finances)
            <p> {{$key}} </p>
            @foreach($month[$key] as $financesForKey)
                <div class="row">
                    <p class="w-50">{{$financesForKey['title']}}</p>
                    <p class="w-25">{{$financesForKey['amount']}}</p>
                    <div class="w-25">
                        <a href="{{URL::route('edit', ['id'=>$financesForKey['id']], false)}}" class="btn btn-secondary">Bearbeiten</a>
                        <a href="{{URL::route('delete_finance', ['id'=>$financesForKey['id'], 
                        'date' => $date], false)}}" class="btn btn-danger">Löschen</a>
                    </div>
                </div>
            @endforeach
            <hr>
        @endforeach
    </div>
    <div class="card-footer">
        <div class="row">
            <p class="w-50">Gesamt</p>
            <p class="w-50">{{$total}}</p>
        </div>
    </div>
</div>
@endsection