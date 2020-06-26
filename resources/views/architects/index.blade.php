@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')

<div class="container-fluid py-5 px-3 items">
    <div class="row">
        <div class="col-md-10 offset-md-1 py-3">
            <nav>
                <ul class="list-group list-group-horizontal d-flex justify-content-center">
                    {{-- @foreach (range('A', 'Z') as $letter)
                    <a class="list-group-item border-0 mx-1{{ $first_letters->contains($letter) ? '' : ' disabled' }}" href="{{ route('architects.index', ['first_letter' => $letter]) }}">{{ $letter }}</a>
                    @endforeach --}}
                </ul>
            </nav>
        </div>
    </div>

    @foreach($architects as $architect)
    <div class="row border-top flex-nowrap py-2">
        <div class="px-4 d-flex align-items-end" style="height: 100px; width: 125px">
            @if($architect->has_image)
            {{ $architect->image_tag->attributes(['width' => 'auto', 'height' => '100%']) }}
            @else
            <div class="bg-secondary h-100 w-100"></div>
            @endif
        </div>
        <div class="d-inline-flex align-items-end pr-4">
            <h5 class="mb-0">{{ $architect->full_name }}</h5>
        </div>
        <div class="d-inline-flex align-items-center" style="height: 100px">
            @foreach($architect->buildings as $building)
                @if($building->processedImages->isNotEmpty())
                {{ $building->cover_image_tag->attributes(['width' => 'auto', 'height' => '100%', 'class' => 'mr-3']) }}
                @endif
            @endforeach
        </div>
    </div>
    @endforeach

</div>

<div class="col-md-12 p-3 text-center">
    {{ $architects->withQueryString()->links() }}
</div>
@endsection
