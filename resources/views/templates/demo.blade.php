{{-- Public demo of one template using sample data. Expects $portfolio (unsaved) and $template --}}
<x-site-layout :title="ucfirst($template) . ' template demo'">
    <div class="border-b border-[var(--line)] bg-[var(--surface)]">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p class="flex flex-wrap items-center gap-2 text-sm text-[var(--ink)]">
                <span class="rounded-md bg-[var(--mark)] px-2 py-0.5 text-xs font-bold text-[var(--deep)]">Demo</span>
                The <x-template-badge :template="$template" /> template with sample data.
            </p>
            <div class="flex gap-2">
                <a href="{{ route('templates.index') }}" class="rounded-[0.6rem] border border-[var(--ink)] px-4 py-2 text-sm font-semibold text-[var(--ink)] transition hover:bg-[var(--chalk)]">All templates</a>
                <a href="{{ route('portfolios.create') }}" class="rounded-[0.6rem] bg-[var(--ink)] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[var(--ink-soft)]">Create my portfolio</a>
            </div>
        </div>
    </div>

    @include('templates.' . $template, ['portfolio' => $portfolio])
</x-site-layout>