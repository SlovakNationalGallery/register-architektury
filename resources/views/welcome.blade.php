@extends('layouts.app')
@section('title', __('app.title'))

@section('content')
<div class="container-fluid p-0">
  <div class="row no-gutters align-items-stretch">
    <div class="col-md-4 py-3 border border-dark text-center align-items-center">
      <h1 class="ls-1 my-auto">Register modernej architektury oA HÚ SAV</h1>
    </div>
    <div class="col-md-4 border border-dark text-center d-flex">
      <form class="px-3 my-auto w-100">
        <input type="text" name="search" class="form-control form-control-sm">
      </form>
    </div>
    <div class="col-md-4 py-3 border border-dark text-center">
      <a href="#" class="mx-1 text-dark ls-2">SK</a>
      /
      <a href="#" class="mx-1 text-dark ls-2">EN</a>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-md-12">
      <nav class="nav nav-justified main-nav">
        <a class="nav-item py-3 ls-1 border border-dark nav-link" href="#">oA</a>
        <a class="nav-item py-3 ls-1 border border-dark text-uppercase nav-link" href="#">architekti</a>
        <a class="nav-item py-3 ls-1 border border-dark text-uppercase nav-link" href="#">objekty</a>
        <a class="nav-item py-3 ls-1 border border-dark text-uppercase nav-link" href="#">kolekcie</a>
      </nav>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-md-12">
      <nav class="nav nav-justified sub-nav">
        <a class="nav-item py-3 ls-2 border border-dark nav-link" href="#">MoMoWo</a>
        <a class="nav-item py-3 ls-2 border border-dark text-uppercase nav-link" href="#">ATRIUM</a>
        <a class="nav-item py-3 ls-2 border border-dark nav-link" href="#">ŠUR</a>
        <a class="nav-item py-3 ls-2 border border-dark nav-link" href="#">Do.co,mo.mo</a>
      </nav>
    </div>
  </div>
  <div class="row no-gutters">
  @foreach (range(1, 8) as $n)
    <div class="col-md-3 border border-dark text-center">
      <img src="http://placekitten.com/300/350?image={{ $n }}" class="img-fluid">
      <div class="small p-3">
        <h6>{{ Str::ucfirst($faker->words(3, true)) }}</h6>
        {{ implode(" ", array_map(function($w) { return "#$w"; }, $faker->words(4))) }}
      </div>
    </div>
  @endforeach
  </div>
  <div class="my-5">&nbsp;</div>
</div>
@endsection
