@extends('layouts.base')

@section('title', 'Details')

@section('header')
<h5 class="text-center">Details</h5>
@endsection

@section('content')
<div class="card">
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
                        <a href="" class="btn btn-danger">Löschen</a>
                    </div>
                </div>
            @endforeach
            <hr>
        @endforeach
    </div>
</div>
@endsection