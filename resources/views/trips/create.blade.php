@extends('layouts.app')

@section('page-title', 'Nova Viagem')

@section('content')
@include('trips._form', [
    'trip'        => new \App\Models\Trip(),
    'action'      => route('trips.store'),
    'method'      => 'POST',
    'submitLabel' => 'Salvar viagem',
])
@endsection
