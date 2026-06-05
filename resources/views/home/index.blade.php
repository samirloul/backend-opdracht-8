@extends('layouts.app')

@section('title', 'Home - Autorijschool De Komeet')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <section class="home-hero">
        <div class="hero-text">
            <p class="kicker">BE-opdracht 8 - Feature 2</p>
            <h1>Verwijderen voertuig</h1>
            <p class="subtitle">
                Beheer direct welke voertuigen gekoppeld zijn aan instructeurs. De overzichten volgen je scenario's,
                met veilige verwijderacties, validatie en nette terugkoppeling.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('instructors.index') }}">Instructeurs in dienst</a>
                <a class="btn btn-ghost" href="{{ route('vehicles.index') }}">Alle voertuigen</a>
            </div>
        </div>
        <div class="hero-card">
            <h2>Feature2 scenario's</h2>
            <ul>
                <li>Scenario 01: toegewezen voertuig bij instructeur verwijderen.</li>
                <li>Scenario 02: toegewezen voertuig verwijderen vanuit alle voertuigen.</li>
                <li>Scenario 03: niet-toegewezen voertuig op non-actief zetten.</li>
            </ul>
        </div>
    </section>
@endsection
