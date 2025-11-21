<article class="portfolio active">
    <header>
        <h2 class="h2 article-title">All Projects</h2>
    </header>

    <section class="projects">
        <ul class="project-list">
            @foreach($projects as $project)
            <li class="project-item">
                <div class="content-card">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}" width="100%">
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