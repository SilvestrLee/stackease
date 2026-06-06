<x-layouts.public title="Resource | StackEase">
    <section class="mx-auto max-w-4xl px-6 py-20 lg:px-8">
        <a href="{{ route('resources.index') }}" class="text-sm font-bold" style="color: var(--accent);">
            ← Back to Resources
        </a>

        <p class="mt-10 text-sm font-bold uppercase tracking-[0.25em]" style="color: var(--accent);">
            StackEase Guide
        </p>

        <h1 class="mt-5 text-4xl font-black tracking-tight se-text-main sm:text-5xl">
            {{ ucwords(str_replace('-', ' ', $slug)) }}
        </h1>

        <div class="mt-8 rounded-3xl border se-border se-surface-strong p-8">
            <p class="text-lg leading-8 se-text-muted">
                This is a placeholder resource page. Later, this page will load the full article from the blog database using the post slug.
            </p>

            <p class="mt-5 leading-8 se-text-soft">
                For now, we are creating the public website structure first. The full blog database, post editor, categories, SEO fields, and Filament blog management will come after the core Phase 5 pages are stable.
            </p>
        </div>
    </section>
</x-layouts.public>