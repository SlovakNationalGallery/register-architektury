@extends('layouts.app')
@section('title', __('app.title'))

@section('content')
<div class="container">
  <div class="md-y-5">&nbsp;</div>
  <div class="row mt-5 no-gutters">
    <div class="col-md-4 py-3 border border-dark text-center">
      Register modernej architektury oA HÚ SAV
    </div>
    <div class="col-md-4 py-3 border border-dark text-center">
      lupa_______________________.
    </div>
    <div class="col-md-4 py-3 border border-dark text-center">
      <span class="pr-3"><u>SK</u></span>
      <span class="pr-3"><u>EN</u></span>
      <span class="pr-3">(+ menu? ≈)</span>
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
