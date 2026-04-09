@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h1>Admin login</h1>
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <div class="input__wrapper">
            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="input__wrapper">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="button__wrapper">
            <button type="submit" class="btn">Einloggen</button>
        </div>
    </form>
</div>


@endsection