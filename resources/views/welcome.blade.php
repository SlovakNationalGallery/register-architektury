@extends('layouts.app')
@section('title', __('app.title'))

@section('content')
<div class="container-fluid p-0">
  <div class="row no-gutters align-items-stretch">
    <div class="col-md-4 py-3 border border-dark text-center align-items-center">
      <h1 class="ls-2 my-auto">Register modernej architektury oA HÚ SAV</h1>
    </div>
    <div class="col-md-4 border border-dark text-center d-flex">
      <form class="px-3 my-auto w-100">
        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
      </form>
    </div>
    <div class="col-md-4 py-3 border border-dark text-center">
      <a href="#" class="mx-1 text-dark ls-3">SK</a>
      /
      <a href="#" class="mx-1 text-dark ls-3">EN</a>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-md-12">
      <nav class="nav nav-justified main-nav">
        <a class="nav-item py-3 ls-2 border border-dark nav-link" href="#">oA</a>
        <a class="nav-item py-3 ls-2 border border-dark text-uppercase nav-link" href="#">architekti</a>
        <a class="nav-item py-3 ls-2 border border-dark text-uppercase nav-link" href="#">objekty</a>
        <a class="nav-item py-3 ls-2 border border-dark text-uppercase nav-link" href="#">kolekcie</a>
      </nav>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-md-12">
      <nav class="nav nav-justified sub-nav">
        <a class="nav-item py-3 ls-3 border border-dark nav-link" href="#">MoMoWo</a>
        <a class="nav-item py-3 ls-3 border border-dark text-uppercase nav-link" href="#">ATRIUM</a>
        <a class="nav-item py-3 ls-3 border border-dark nav-link" href="#">ŠUR</a>
        <a class="nav-item py-3 ls-3 border border-dark nav-link" href="#">Do.co,mo.mo</a>
      </nav>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-md-12 border border-dark p-3">
      <div class="row no-gutters">
        @foreach ($buildings as $i=>$building)
          <div class="col-md-4 d-flex align-items-stretch">
            <div class="card m-3 border-dark">
              {{-- <img src="https://placeimg.com/500/300/arch/grayscale/{{ $i }}" class="card-img-top" alt="..."> --}}
              <img src="https://picsum.photos/500/300?grayscale&random={{ $i }}" class="card-img-top" alt="...">
              <div class="card-body ls-1">
                <div class="mb-3 mt-2 tags">
                  @foreach ($building->tags as $tag)
                    <a class="btn btn-outline-dark btn-sm mb-2" href="./?search={{ $tag }}" role="button">{{ $tag }}</a>
                  @endforeach
                </div>
                <p class="card-text">
                  {{ $building->title }}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          {{ $buildings->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
