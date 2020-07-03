@extends('layouts.app')

@section('title')
    Style Guide
@parent
@stop

@section('content')

<main>
<h1>Style Guide</h1>

<section id="branding" class="cd-branding">
    <h2>Branding</h2>

    <ul>
        <li class="cd-box">
            <h1 class="ls-2 my-auto">Register modernej architektúry oA HÚ SAV</h1>
        </li>
    </ul>

    <ul>
        <li><img src="/apple-touch-icon.png" alt="Touch Icon 1"></li>
        <li><img src="/favicon-32x32.png" alt="Favicon 1"></li>
        <li><img src="/favicon-16x16.png" alt="Favicon 2"></li>
        <li><img src="/favicon.ico" alt="Current favicon"></li>
    </ul>
</section>

<section id="colors" class="cd-colors">
    <h2>Colors</h2>

    <ul>
        <li class="cd-box">
            <div class="cd-color-swatch"></div>
        </li>

        <li class="cd-box">
            <div class="cd-color-swatch"></div>
        </li>

        <li class="cd-box">
            <div class="cd-color-swatch"></div>
        </li>

        <li class="cd-box">
            <div class="cd-color-swatch"></div>
        </li>

        <li class="cd-box">
            <div class="cd-color-swatch"></div>
        </li>
    </ul>
</section>

<section id="typography" class="cd-typography">
    <h2>Typography</h2>

    <div class="cd-box">
        <h1>Heading, <span></span></h1>
        <p>Aa - <span></span>. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis voluptate distinctio reprehenderit, autem deleniti ad <a href="#0">voluptatum eaque</a>. Optio ea aperiam nisi distinctio nemo repellat, voluptate fugiat. Quidem neque illum, blanditiis!</p>
    </div>
</section>

<section id="buttons" class="cd-buttons">
    <h2>Buttons</h2>

    <div class="cd-box">
        <button class="btn btn-outline-dark">Outlined</button>
        <button class="btn btn-outline-dark btn-sm">Outlined sm</button>
        <button class="btn btn-outline-dark btn-sm btn-with-icon-right">Outlined sm with right icon<span>&times;</span></button>
    </div>
</section>

<section id="icons" class="cd-icons">
    <h2>Icons</h2>

    <ul class="cd-box icons">
        {{-- @TODO --}}
        <li class="icon-menu"></li>
        <li class="icon-chevron-left"></li>
        <li class="icon-chevron-right"></li>
        <li class="icon-map-pin"></li>
        <li class="icon-search"></li>
    </ul>
</section>

<section id="form" class="cd-form">
    <h2>Form</h2>

    <div class="cd-box">
        <form>
            <fieldset>
                <input class="form-control  w-50" type="text" >
                <input class="form-control  w-50 is-valid" type="text">
                <input class="form-control  w-50 is-invalid" type="text">
            </fieldset>

            <fieldset>
                <div class="cd-input-wrapper">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                      <label class="custom-control-label" for="customRadio1">Toggle 1</label>
                    </div>
                </div>

                <div class="cd-input-wrapper">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Check 1</label>
                    </div>
                </div>

                <div class="cd-input-wrapper cd-select">
                    <select name="select-this" id="select-this" class="custom-select input-sm form-control form-control-sm">
                      <option value="0">Select</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="2">Option 3</option>
                    </select>
                </div>
            </fieldset>
        </form>
    </div>

</section>

<section id="building-card" class="cd-building-card">
    <h2>Component: building-card</h2>

    <div class="cd-box">
        @php
            $building = App\Models\Building::inRandomOrder()->first();
            if (empty($building)) {
                $building = factory(App\Models\Building::class)->state('rich')->make();
            }

            $buildings = App\Models\Building::inRandomOrder()->take(10)->get();
            if (empty($building)) {
                $buildings = factory(App\Models\Building::class)->state('rich')->make(10);
            }
            $perPage = 3;
            $paginator = new Illuminate\Pagination\LengthAwarePaginator($buildings, count($buildings), $perPage, 1);
        @endphp

        @include('components.building-card', ['building' => $building ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.building-card', ['building' => $building ])
    </div>
</section>

<section id="header-card" class="cd-header-card">
    <h2>Component: header</h2>

    <div class="cd-box">
        @include('components.header')
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.header')
    </div>
</section>

<section id="tags-card" class="cd-tags-card">
    <h2>Component: tags</h2>

    <div class="cd-box">
        @include('components.tags', ['tags' => $building->tags ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.tags', ['tags' => $building->tags ])
    </div>
</section>

<section id="map-card" class="cd-map-card">
    <h2>Component: map</h2>

    <div class="cd-box">
        @include('components.map', [
            'location' => $building->lng_lat,
            'tags' => $building->tags,
            'show_map' => session('show_map', true),
        ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.map', [
            'location' => $building->lng_lat,
            'tags' => $building->tags,
            'show_map' => session('show_map', true),
        ])
    </div>
</section>

<section id="load-more-card" class="cd-load-more-card">
    <h2>Component: load-more</h2>

    <div class="cd-box">
        @include('components.load-more', [
            'paginator' => $paginator
        ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.load-more', [
            'paginator' => $paginator
        ])
        <br>
        // or simply
        <br>
        @{{ $buildings->links() }}
    </div>
</section>

<section id="active-filter-card" class="cd-active-filter-card">
    <h2>Component: active-filter</h2>

    <div class="cd-box">
        @include('components.active-filter', [
            'label' => 'Kultúra',
            'name' => 'filters[]',
            'value' => 'Kultúra',
        ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.active-filter', [
            'label' => 'Kultúra',
            'name' => 'filters[]',
            'value' => 'Kultúra',
        ])
    </div>
</section>


<section id="custom-select-card" class="cd-custom-select-card">
    <h2>Component: custom-select</h2>

    <div class="cd-box">
        @include('components.custom-select', ['data' => ['Kultúra' => 10, "Obchod a služby" => 8], 'label' => 'Funkcia' ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.custom-select', ['data' => ['Kultúra' => 10, "Obchod a služby" => 8], 'label' => 'Funkcia' ])
    </div>
</section>

<section id="timeline-card" class="cd-timeline-card">
    <h2>Component: timeline</h2>

    <div class="cd-box">
        @include('components.timeline', [
            'year_from' => 1950,
            'year_until' => 1980,
            'year_min' => 1920,
            'year_max' => 2010,
        ])
    </div>

    <div class="cd-box code lang-php hljs xml">
        @@include('components.timeline', [
            'year_from' => 1950,
            'year_until' => 1980,
            'year_min' => 1920,
            'year_max' => 2010,
        ])
    </div>
</section>


</main>
@stop


@push('styles')
    <link rel="stylesheet" href="{{ mix('/css/styleguide.css') }}">
    <link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/default.min.css">
@endpush

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js"></script>
    <script type="text/javascript" src="/js/styleguide.js"></script>
@endpush
