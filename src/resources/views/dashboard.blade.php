@extends('layout.app')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @include('components.sections.book-card')

        @include('components.sections.client-card')
    </div>
@endsection
