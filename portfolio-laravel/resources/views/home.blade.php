<x-app-layout>
    <!--
      - #SIDEBAR
    -->
    <aside class="sidebar" data-sidebar>
        <div class="sidebar-info">
            <figure class="avatar-box">
                @if($profile && $profile->profile_avatar)
                    <img src="{{ asset('avatars/' . $profile->profile_avatar) }}" alt="{{ $profile->name ?? 'John Doe' }}" width="80" height="80">
                @else
                    <div style="width: 80px; height: 80px; background: var(--bg-gradient-onyx); border-radius: 20px;"></div>
                @endif
            </figure>

            <div class="info-content">
                <h1 class="name" title="{{ $profile->name ?? 'John Doe' }}">{{ $profile->name ?? 'John Doe' }}</h1>
                <p class="title">{{ $profile->title ?? 'Web Developer' }}</p>
            </div>

            <button class="info_more-btn" data-sidebar-btn>
                <span>Show Contacts</span>
                <ion-icon name="chevron-down"></ion-icon>
            </button>
        </div>

        <div class="sidebar-info_more">
            <div class="separator"></div>

            <ul class="contacts-list">
                <li class="contact-item">
                    <div class="icon-box">
                        <ion-icon name="mail-outline"></ion-icon>
                    </div>
                    <div class="contact-info">
                        <p class="contact-title">Email</p>
                        <a href="mailto:{{ $profile->email ?? 'john.doe@example.com' }}" class="contact-link">{{ $profile->email ?? 'john.doe@example.com' }}</a>
                    </div>
                </li>

                <li class="contact-item">
                    <div class="icon-box">
                        <ion-icon name="phone-portrait-outline"></ion-icon>
                    </div>
                    <div class="contact-info">
                        <p class="contact-title">Phone</p>
                        <a href="tel:{{ $profile->phone ?? '+1234567890' }}" class="contact-link">{{ $profile->phone ?? '+1234567890' }}</a>
                    </div>
                </li>

                <li class="contact-item">
                    <div class="icon-box">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </div>
                    <div class="contact-info">
                        <p class="contact-title">Birthday</p>
                        <time datetime="{{ $profile->birthday ?? '1990-01-01' }}">{{ $profile->birthday ?? 'January 1, 1990' }}</time>
                    </div>
                </li>

                <li class="contact-item">
                    <div class="icon-box">
                        <ion-icon name="location-outline"></ion-icon>
                    </div>
                    <div class="contact-info">
                        <p class="contact-title">Location</p>
                        <address>{{ $profile->location ?? 'New York, USA' }}</address>
                    </div>
                </li>
            </ul>

            <div class="separator"></div>

            <ul class="social-list">
                <li class="social-item">
                    <a href="{{ $profile->social_links['facebook'] ?? '#' }}" class="social-link" target="_blank">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                </li>
                <li class="social-item">
                    <a href="{{ $profile->social_links['twitter'] ?? '#' }}" class="social-link" target="_blank">
                        <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                </li>
                <li class="social-item">
                    <a href="{{ $profile->social_links['instagram'] ?? '#' }}" class="social-link" target="_blank">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!--
      - #main-content
    -->
    <div class="main-content">
        <!--
          - #NAVBAR
        -->
        <nav class="navbar">
            <ul class="navbar-list">
                <li class="navbar-item">
                    <button class="navbar-link active" data-nav-link="about">About</button>
                </li>
                <li class="navbar-item">
                    <button class="navbar-link" data-nav-link="resume">Resume</button>
                </li>
                <li class="navbar-item">
                    <button class="navbar-link" data-nav-link="portfolio">Portfolio</button>
                </li>
                <li class="navbar-item">
                    <button class="navbar-link" data-nav-link="blog">Blog</button>
                </li>
                <li class="navbar-item">
                    <button class="navbar-link" data-nav-link="contact">Contact</button>
                </li>
            </ul>
        </nav>

        <!--
          - #ABOUT
        -->
        <article class="about active" data-page="about">
            <header>
                <h2 class="h2 article-title">About me</h2>
            </header>

            <section class="about-text">
                <p>
                    {{ $profile->bio ?? 'I am a passionate web developer with over 5 years of experience building web applications using modern technologies like Laravel, Vue.js, and React. I enjoy turning complex problems into simple, beautiful and intuitive designs.' }}
                </p>
                <p>
                    My job is to build your website so that it is functional and user-friendly but at the same time attractive.
                    Moreover, I add personal touch to your product and make sure that is eye-catching and easy to use. My aim is to bring
                    across your message and identity in the most creative way. I created web design for many famous brand companies.
                </p>
            </section>

            <!--
              - service
            -->
            <section class="service">
                <h3 class="h3 service-title">What i'm doing</h3>
                <ul class="service-list">
                    @foreach($skills->take(4) as $skill)
                    <li class="service-item">
                        <div class="service-icon-box">
                            @if($skill->icon)
                                <img src="{{ asset('images/icon-' . strtolower($skill->icon) . '.png') }}" alt="{{ $skill->name }} icon" width="40" height="40">
                            @else
                                <div style="width: 40px; height: 40px; background: var(--bg-gradient-onyx); border-radius: 8px;"></div>
                            @endif
                        </div>
                        <div class="service-content-box">
                            <h4 class="h4 service-item-title">{{ $skill->name }}</h4>
                            <p class="service-item-text">{{ $skill->category }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>

            <!--
              - testimonials
            -->
            <section class="testimonials">
                <h3 class="h3 testimonials-title">Testimonials</h3>
                <ul class="testimonials-list has-scrollbar">
                    @foreach($testimonials as $testimonial)
                    <li class="testimonials-item">
                        <div class="content-card" data-testimonials-item>
                            <figure class="testimonials-avatar-box">
                                @if($testimonial->photo)
                                    <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->client_name }}" width="60" height="60" data-testimonials-avatar>
                                @else
                                    <div style="width: 60px; height: 60px; background: var(--bg-gradient-onyx); border-radius: 14px;"></div>
                                @endif
                            </figure>
                            <h4 class="h4 testimonials-item-title" data-testimonials-title>{{ $testimonial->client_name }}</h4>
                            <div class="testimonials-text" data-testimonials-text>
                                <p>{{ $testimonial->review }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>
        </article>

        <!--
          - #RESUME
        -->
        <article class="resume" data-page="resume">
            <header>
                <h2 class="h2 article-title">Resume</h2>
            </header>
            <section class="timeline">
                <div class="title-wrapper">
                    <div class="icon-box">
                        <ion-icon name="book-outline"></ion-icon>
                    </div>
                    <h3 class="h3">Education</h3>
                </div>
                <ol class="timeline-list">
                    <li class="timeline-item">
                        <h4 class="h4 timeline-item-title">University of Studies</h4>
                        <span>2010 — 2012</span>
                        <p class="timeline-text">
                            Nemo enims ipsam voluptatem, blanditiis praesentium voluptum delenit atque corrupti, quos
                            dolores et quas molestias exceptur.
                        </p>
                    </li>
                    <li class="timeline-item">
                        <h4 class="h4 timeline-item-title">College of Studies</h4>
                        <span>2008 — 2010</span>
                        <p class="timeline-text">
                            Ratione voluptatem sequi nesciunt, facere quisquams facere menda ossimus, omnis voluptas
                            assumenda est omnis..
                        </p>
                    </li>
                </ol>
            </section>

            <section class="timeline">
                <div class="title-wrapper">
                    <div class="icon-box">
                        <ion-icon name="book-outline"></ion-icon>
                    </div>
                    <h3 class="h3">Experience</h3>
                </div>
                <ol class="timeline-list">
                    <li class="timeline-item">
                        <h4 class="h4 timeline-item-title">Creative Director</h4>
                        <span>2015 — Present</span>
                        <p class="timeline-text">
                            Nemo enim ipsam voluptatem blanditiis praesentium voluptum delenit atque corrupti, quos
                            dolores et qvuas molestias exceptur.
                        </p>
                    </li>
                    <li class="timeline-item">
                        <h4 class="h4 timeline-item-title">Art Director</h4>
                        <span>2013 — 2015</span>
                        <p class="timeline-text">
                            Nemo enims ipsam voluptatem, blanditiis praesentium voluptum delenit atque corrupti, quos
                            dolores et quas molestias exceptur.
                        </p>
                    </li>
                </ol>
            </section>

            <section class="skill">
                <h3 class="h3 skills-title">My skills</h3>
                <ul class="skills-list content-card">
                    @foreach($skills as $skill)
                    <li class="skills-item">
                        <div class="title-wrapper">
                            <h5 class="h5">{{ $skill->name }}</h5>
                            <data value="{{ $skill->level }}">{{ $skill->level }}%</data>
                        </div>
                        <div class="skill-progress-bg">
                            <div class="skill-progress-fill" style="width: {{ $skill->level }}%; background: var(--text-gradient-yellow);"></div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>
        </article>

        <!--
          - #PORTFOLIO
        -->
        <article class="portfolio" data-page="portfolio">
            <header>
                <h2 class="h2 article-title">Portfolio</h2>
            </header>
            <section class="projects">
                <ul class="project-list">
                    @foreach($projects as $project)
                    <li class="project-item">
                        <div class="content-card">
                            @if($project->thumbnail)
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}" width="100%" height="200">
                            @endif
                            <h3 class="h3 project-item-title">{{ $project->name }}</h3>
                            <p class="project-item-text">{{ Str::limit($project->description, 100) }}</p>
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn" style="margin-top: 10px; display: inline-block; padding: 8px 16px; background: var(--bg-gradient-yellow-1); color: var(--smoky-black); border-radius: 8px; text-align: center;">View Details</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>
        </article>

        <!--
          - #BLOG
        -->
        <article class="blog" data-page="blog">
            <header>
                <h2 class="h2 article-title">Blog</h2>
            </header>
            <section class="blog-posts">
                <ul class="blog-list">
                    <li class="blog-item">
                        <div class="content-card">
                            <h3 class="h3 blog-item-title">Design Conferences in 2022</h3>
                            <p class="blog-text">
                                Veritatis et quasi architecto beatae vitae dicta sunt, explicabo.
                            </p>
                        </div>
                    </li>
                    <li class="blog-item">
                        <div class="content-card">
                            <h3 class="h3 blog-item-title">Best fonts every designer</h3>
                            <p class="blog-text">
                                Sed ut perspiciatis, nam libero tempore, cum soluta nobis est eligendi.
                            </p>
                        </div>
                    </li>
                </ul>
            </section>
        </article>

        <!--
          - #CONTACT
        -->
        <article class="contact" data-page="contact">
            <header>
                <h2 class="h2 article-title">Contact</h2>
            </header>
            <section class="contact-text">
                <p class="contact-content">Feel free to reach out to me for any inquiries or collaboration opportunities.</p>
            </section>
            <section class="contact-form">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-input" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="form-btn">Send Message</button>
                </form>
            </section>
        </article>
    </div>
</x-app-layout>