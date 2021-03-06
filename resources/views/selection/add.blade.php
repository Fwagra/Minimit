@extends('layouts.app')
@section('title', trans('selection.add_title'))
@section('backlink', 'selection.my')

@section('content')
    <div class="poster-count">{{ count($posters) }}</div>
    {!! Form::open(['route' => 'selection.store', 'method' => 'POST']) !!}
        {!! Form::hidden('cookie-name', 'new_selection', ['class' => 'cookie-name']) !!}
        @include('selection.form')
    {!! Form::close() !!}
    <div class="add-posters">{{ trans('selection.add_posters') }}</div>
    @include('selection.poster-selector')
@endsection