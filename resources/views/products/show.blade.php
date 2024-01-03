@extends('layouts.app')

@section('content')
    @include('components.product-card')
    
    {!!$html!!}
    {{-- Esto es un comentario --}}
    @{{ $var o var dependiendo el framework con el que se este integrando Laravel}}
@endsection