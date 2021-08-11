@extends('layout')

@section('content')
    @livewire('delivery.create', ['updateId' => $updateId]);
@endsection