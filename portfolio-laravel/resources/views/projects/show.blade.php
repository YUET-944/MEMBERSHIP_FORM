<article class="portfolio active">
    <header>
        <h2 class="h2 article-title">{{ $project->name }}</h2>
    </header>

    <section class="projects">
        <div class="project-item">
            <div class="content-card">
                @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->name }}" width="100%">
                @endif
                <h3 class="h3 project-item-title">{{ $project->name }}</h3>
                <p class="project-item-text">{{ $project->description }}</p>
                
                <div style="margin: 15px 0;">
                    <h4 class="h4">Project Details</h4>
                    <p><strong>Status:</strong> {{ ucfirst($project->status) }}</p>
                </div>
                
                @if($project->project_url || $project->github_url)
                    <div style="margin: 15px 0;">
                        <h4 class="h4">Links</h4>
                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="btn" style="padding: 8px 16px; background: var(--bg-gradient-yellow-1); color: var(--smoky-black); border-radius: 8px; text-align: center;">View Project</a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="btn" style="padding: 8px 16px; background: var(--onyx); color: var(--white-2); border-radius: 8px; text-align: center;">GitHub</a>
                            @endif
                        </div>
                    </div>
                @endif
                
                <a href="{{ route('projects.index') }}" class="btn" style="margin-top: 20px; display: inline-block; padding: 8px 16px; background: var(--jet); color: var(--white-2); border-radius: 8px; text-align: center;">← Back to Projects</a>
            </div>
        </div>
    </section>
</article>