@extends('layouts.app')
@section('title', __('header.about.projects'))

@section('content')
@include('components.header')

<div class="container-fluid my-lg-7">
    @foreach($projects as $project)
    <div class="row border-bottom py-3">
        <div class="col-lg-6 order-2 order-lg-1">
            <h6 class="mb-4 font-weight-bold"><a href="{{ route('about.projects.show', $project) }}" class="link-no-underline">{{ $project->title }}</a></h6>
            {{ Str::words(strip_tags($project->content), 100) }}
        </div>
        <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0 ">
            @if($project->hasMedia())
                {{ $project->getFirstMedia()->img()->attributes(['class' => 'w-6rem w-sm-8rem ', 'width' => 'auto']) }}
            @endif
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col text-center">
            {{ $projects->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection
