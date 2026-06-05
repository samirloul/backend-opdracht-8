@extends('layouts.app')

@section('title', 'Alle voertuigen')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vehicles-index.css') }}">
@endpush

@section('content')
    <section class="panel">
        <header class="panel-header">
            <h1>Alle voertuigen</h1>
            <p>Sortering op bouwjaar aflopend en daarna op achternaam aflopend.</p>
        </header>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Type voertuig</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Rijbewijs</th>
                        <th>Brandstof</th>
                        <th>Toegewezen aan</th>
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
                            <td>{{ $vehicle['InstructeurAchternaam'] ?: '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('vehicles.remove', ['vehicle' => $vehicle['VoertuigId']]) }}" onsubmit="return confirm('Weet je zeker dat je dit voertuig wilt verwerken?');">
                                    @csrf
                                    <button class="icon-delete" type="submit" aria-label="Verwijderen">✖</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Er zijn geen voertuigen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pager">
            @for ($p = 1; $p <= $vehicles['last_page']; $p++)
                <a href="{{ route('vehicles.index', ['page' => $p]) }}" class="{{ $p === $vehicles['current_page'] ? 'active' : '' }}">{{ $p }}</a>
            @endfor
        </div>
    </section>
@endsection
