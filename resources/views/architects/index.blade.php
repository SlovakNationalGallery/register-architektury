@extends('layouts.app')
@section('title', Str::upper(__('header.architects')))

@section('content')

@include('components.header')

<div class="container-fluid py-5 px-3 items">
    <div class="row">
        <div class="col-md-10 offset-md-1 py-3">
            <nav>
                <ul class="list-group list-group-horizontal d-flex justify-content-center">
                    @foreach (range('A', 'Z') as $letter)
                    <a class="list-group-item border-0 mx-1{{ $first_letters->contains($letter) ? '' : ' disabled' }}" href="{{ route('architects.index', ['first_letter' => $letter]) }}">{{ $letter }}</a>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    @foreach($architects as $architect)
    <div class="row architect-list border-top py-1 pl-3 d-flex item" style="height: 105px"> {{-- TODO remove style attr --}}
        <div class="py-1 mx-3 d-inline-flex align-items-end" style="height: 100px; width: 100px;"> {{-- TODO remove style attr --}}
            <img src="https://placekitten.com/{{ collect([101, 105, 92, 80, 200])->random() }}/139" class="mh-100 img-fluid">
        </div>
        <div class="d-inline-flex align-items-end mr-5">
            <h5 class="mb-0">{{ $architect->full_name }}</h5>
        </div>
        <div class="h-100 d-flex align-items-center">
            @foreach($architect->buildings as $building)
                @if($building->processedImages->isNotEmpty())
                    {{ $building->cover_image_tag->attributes(['width' => 'auto', 'class' => 'mh-100 mr-3', 'style' => 'max-width: 200px' ]) }} {{-- TODO remove style attr --}}
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
