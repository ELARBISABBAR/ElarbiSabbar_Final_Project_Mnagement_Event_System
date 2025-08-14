@extends('layouts.index')

@section('content')
    <div>
        @include('layouts.components.sidebare')
        @yield('content2')
    </div>
@endsection
