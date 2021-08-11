@extends('layout')

@section('content')
@livewire('customer.address',  ['customer' => $customer])
@endsection