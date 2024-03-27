@extends('layouts.base')
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
        <form method="POST" action="{{route('edit', [], false)}}">
            @csrf
            <div class="mb-3">
                <label for="inputTitle" class="form-label w-25 mt-5">Titel</label>
                <input type="text" value="{{$finance->title}} {{ old('title') }}" class="w-50 @error('title') is-invalid @enderror" name="title" id="inputTitle">
            </div>
            <div class="mb-3">
                <label for="inputAmount" class="form-label w-25">Betrag</label>
                <input type="number" value="{{$finance->amount}} {{ old('amount') }}" class="@error('amount') is-invalid @enderror" name="amount" id="inputAmount">
            </div>
            <div class="mb-3">
                <label for="inputMonthly" class="form-label w-25">Monatlich</label>
                <input type="checkbox" value="{{$finance->monthly}} {{ old('monthly') == 1 ? 'checked' : '' }}" class="@error('monthly') is-invalid @enderror" name="monthly" id="inputMonthly">
            </div>
            <div class="mb-3">
                <label for="inputDate" class="form-label w-25">Fälligkeitsdatum</label>
                <input type="date" value="{{$finance->date}} {{ old('date') }}" class=" @error('date') is-invalid @enderror" name="date" id="inputDate">
            </div>
            <div class="mb-3">
                <label for="inputFinanceType" class="form-label w-25">Finanztyp</label>
                <select value="{{$finance->type}} {{ old('type') }}" class=" @error('type') is-invalid @enderror" name="type" id="inputFinanceType">
                @foreach($financeTypes as $type)
                    <option value="{{$type}}" select="">
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