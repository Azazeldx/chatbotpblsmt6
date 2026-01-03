@extends('layouts.landing-base')
@section('content')
    @foreach ($data['page']->sections as $section)
        @php
            $section = $section->section;
        @endphp
        @include('sections.'.$section->layout_path)
    @endforeach()
@endsection

