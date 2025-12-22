@extends('layouts.master')

@section('title', 'Editar Bloco')

@section('content')
    @livewire('edit-block', ['block' => $block])
@endsection