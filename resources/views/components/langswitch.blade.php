<ul class="list-inline lang-switch m-0">
    @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
    <li class="list-inline-item m-0">
        <a rel="alternate" hreflang="{{ $localeCode }}" title="{{ $properties['native'] }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="mx-1 text-uppercase ls-3 {{ ($localeCode == LaravelLocalization::getCurrentLocale()) ? 'active' : '' }}" >{{ $localeCode }}</a>
    </li>
    @endforeach
</ul>