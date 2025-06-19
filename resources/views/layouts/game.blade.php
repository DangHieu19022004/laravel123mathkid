@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4 z-10 min-h-screen">
        @yield('game_content')
    </div>
@endsection

@push('scripts')
    @include('layouts.require_js._game')
@endpush
