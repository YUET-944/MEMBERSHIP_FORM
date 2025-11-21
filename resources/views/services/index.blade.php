<article class="service active">
    <header>
        <h2 class="h2 article-title">Services</h2>
    </header>

    <section class="services">
        <ul class="service-list">
            @foreach($services as $service)
            <li class="service-item">
                <div class="service-icon-box">
                    @if($service->icon)
                        <img src="{{ asset('images/icon-' . strtolower($service->icon) . '.png') }}" alt="{{ $service->title }} icon" width="40">
                    @endif
                </div>
                <div class="service-content-box">
                    <h3 class="h3 service-item-title">{{ $service->title }}</h3>
                    <p class="service-item-text">{{ $service->description }}</p>
                </div>
            </li>
            @endforeach
        </ul>
    </section>
</article>