@extends('layouts.app')
@section('title', 'Finanzen bearbeiten')

@section('header')
<h5 class="text-center">Erstellen/Bearbeiten</h5>
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
        <form method="POST" action="{{route('edit', ['id' => $finance->id], false)}}">
            @csrf
            <div class="mb-3">
                <label for="inputTitle" class="form-label w-25 mt-5">Titel</label>
                <input type="text" value="{{ old('title', $finance->title) }}" class="w-50 @error('title') is-invalid @enderror" name="title" id="inputTitle">
            </div>
            <div class="mb-3">
                <label for="inputAmount" class="form-label w-25">Betrag</label>
                <input type="number" value="{{ old('amount', $finance->amount) }}" class="@error('amount') is-invalid @enderror" name="amount" id="inputAmount">
            </div>
            <div class="mb-3">
                <label for="inputMonthly" class="form-label w-25">Monatlich</label>
                <input type="checkbox" @checked(old('monthly', $finance->monthly)) value="1" class="@error('monthly') is-invalid @enderror" name="monthly" id="inputMonthly">
            </div>
            <div class="mb-3">
                <label for="inputDate" class="form-label w-25">Fälligkeitsdatum</label>
                <input type="date" value="{{ old('date', $finance->date->toDateString()) }}" class=" @error('date') is-invalid @enderror" name="date" id="inputDate">
            </div>
            <div class="mb-3">
                <label for="inputFinanceType" class="form-label w-25">Finanztyp</label>
                <select class=" @error('type') is-invalid @enderror" name="type" id="inputFinanceType">
                @foreach($financeTypes as $type)
                    <option value="{{$type}}" @if(old('type', $finance->type) == $type) selected="selected" @endif>
                        {{$type == 'income' ? 'Einkommen' : 'Ausgaben'}}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary">Speichern</button>
            </div>
        </form>
@endsection