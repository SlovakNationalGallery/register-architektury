<ul class="nav nav-justified lang-switch m-0">
    @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
    <li class="nav-item border-bl border-left">
        <a rel="alternate" hreflang="{{ $localeCode }}" title="{{ $properties['native'] }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="nav-link text-uppercase py-3 ls-3 {{ ($localeCode == LaravelLocalization::getCurrentLocale()) ? 'active' : '' }}" >{{ $localeCode }}</a>
    </li>
    @endforeach
</ul>