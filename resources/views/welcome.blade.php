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
    <div class="col-md-3 py-3 border border-dark text-center">
      oA
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      kolekcie
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      mapy
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      Register
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      DOCOMO
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      ŠUR
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      ATRIUM
    </div>
    <div class="col-md-3 py-3 border border-dark text-center">
      MOMOVO
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
