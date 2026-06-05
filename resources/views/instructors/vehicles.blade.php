@extends('layouts.app')

@section('title', 'Door Instructeur Gebruikte Voertuigen')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/instructors-vehicles.css') }}">
@endpush

@section('content')
    <section class="panel">
        <header class="panel-header">
            <h1>Door instructeur gebruikte voertuigen</h1>
            <p>
                Instructeur: <strong>{{ trim($instructor['Voornaam'] . ' ' . ($instructor['Tussenvoegsel'] ?? '') . ' ' . $instructor['Achternaam']) }}</strong>
                - Sortering op rijbewijscategorie (aflopend)
            </p>
        </header>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Type voertuig</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Rijbewijs categorie</th>
                        <th>Brandstof</th>
                        <th>Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicles['data'] as $vehicle)
                        <tr>
                            <td>{{ $vehicle['TypeVoertuig'] }}</td>
                            <td>{{ $vehicle['Kenteken'] }}</td>
                            <td>{{ $vehicle['Bouwjaar'] }}</td>
                            <td>{{ $vehicle['Rijbewijscategorie'] }}</td>
                            <td>{{ $vehicle['BrandstofType'] }}</td>
                            <td>
                                <form method="POST" action="{{ route('instructors.vehicles.remove', ['instructor' => $instructor['Id'], 'vehicle' => $vehicle['VoertuigId']]) }}" onsubmit="return confirm('Weet je zeker dat je dit voertuig wilt verwijderen voor deze instructeur?');">
                                    @csrf
                                    <button class="danger-btn" type="submit">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Er zijn geen voertuigen toegewezen aan deze instructeur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="actions-row">
            <a class="btn-back" href="{{ route('instructors.index') }}">Terug naar instructeurs</a>
        </div>

        <div class="pager">
            @for ($p = 1; $p <= $vehicles['last_page']; $p++)
                <a href="{{ route('instructors.vehicles', ['instructor' => $instructor['Id'], 'page' => $p]) }}" class="{{ $p === $vehicles['current_page'] ? 'active' : '' }}">{{ $p }}</a>
            @endfor
        </div>
    </section>
@endsection
