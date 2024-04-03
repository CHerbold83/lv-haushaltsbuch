@extends('layouts.app')
@section('title', 'Home')

@section('header')
<h5 class="text-center">Profil</h5>
@endsection

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">Erfolgreich gespeichert</div>
    @endif
    <form method="POST" action="{{route('profile', ['id' => $user['id']], false)}}">
        @csrf
        <div class="mb-3">
            <label for="inputUsername" class="form-label w-25 mt-5">Username</label>
            <input type="text" value="{{old('name', $user['name']) }}" class="w-50 @error('name') 
            is-invalid @enderror" name="name" id="inputUsername" @if(!$edit) disabled @endif>
        </div>
        <div class="mb-3">
            <label for="inputEmail" class="form-label w-25 mt-5">Email</label>
            <input type="email" value="{{old('email', $user['email']) }}" class="w-50 @error('email') 
            is-invalid @enderror" name="email" id="inputEmail" @if(!$edit) disabled @endif>
        </div>
        <div class="text-center">
            <a class="btn btn-secondary" href="{{route('profile', ['edit'=>true], false)}}" @if($edit) hidden='hidden' @endif>Profil bearbeiten</a>
            <button class="btn btn-primary" @if(!$edit) hidden='hidden' @endif>Speichern</button>
            <a class="btn btn-danger m-5" href="{{route('delete_user')}}">Eigenen Account löschen</a>
        </div>
    </form>
</div>
@endsection