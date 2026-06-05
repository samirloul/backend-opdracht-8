@extends('layouts.app')

@section('title', 'Instructeurs in dienst')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/instructors-index.css') }}">
@endpush

@section('content')
    <section class="panel">
        <header class="panel-header">
            <h1>Instructeurs in dienst</h1>
            <p>Gesorteerd op aantal sterren aflopend.</p>
        </header>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Mobiel</th>
                        <th>Datum in dienst</th>
                        <th>Sterren</th>
                        <th>Voertuigen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($instructors['data'] as $instructor)
                        <tr>
                            <td>
                                {{ trim($instructor['Voornaam'] . ' ' . ($instructor['Tussenvoegsel'] ?? '') . ' ' . $instructor['Achternaam']) }}
                            </td>
                            <td>{{ $instructor['Mobiel'] }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($instructor['DatumInDienst'])->format('d-m-Y') }}</td>
                            <td>{{ $instructor['AantalSterren'] }}</td>
                            <td>
                                <a class="icon-link" href="{{ route('instructors.vehicles', ['instructor' => $instructor['Id']]) }}" aria-label="Bekijk voertuigen">
                                    🚗
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Er zijn geen actieve instructeurs gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pager">
            @for ($p = 1; $p <= $instructors['last_page']; $p++)
                <a href="{{ route('instructors.index', ['page' => $p]) }}" class="{{ $p === $instructors['current_page'] ? 'active' : '' }}">{{ $p }}</a>
            @endfor
        </div>
    </section>
@endsection
