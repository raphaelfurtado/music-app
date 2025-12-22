@extends('layouts.master')
@section('content')
    @livewire('create-block', ['repertoire' => $repertoire])
@endsection