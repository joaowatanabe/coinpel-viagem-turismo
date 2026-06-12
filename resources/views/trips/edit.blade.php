@extends('layouts.app')

@section('page-title', 'Editar Viagem')

@section('content')
@include('trips._form', [
    'action'      => route('trips.update', $trip),
    'method'      => 'PUT',
    'submitLabel' => 'Salvar alterações',
])
@endsection
