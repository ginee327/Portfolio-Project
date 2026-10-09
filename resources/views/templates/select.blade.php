{{-- Template selection for a saved portfolio. Expects $portfolio and $templates --}}
<x-site-layout title="Choose a template">
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">

        {{-- Progress: a real sequence, drawn as three segments --}}
        <ol class="grid grid-cols-3 gap-3 text-sm" aria-label="Progress">
            <li class="border-t-4 border-[var(--ink)] pt-3">
                <span class="font-semibold text-[var(--ink)]">1. Information</span>
                <span class="block text-[var(--muted)]">Done</span>
            </li>
            <li class="border-t-4 border-[var(--mark)] pt-3" aria-current="step">
                <span class="font-semibold text-[var(--ink)]">2. Template</span>
                <span class="block text-[var(--muted)]">You are here</span>
            </li>
            <li class="border-t-4 border-[var(--line)] pt-3">
                <span class="font-semibold text-[var(--muted)]">3. Preview</span>
            </li>
        </ol>

        <div class="mt-12 max-w-2xl">
            <h1 class="font-display text-3xl font-extrabold text-[var(--ink)] sm:text-4xl">Choose a template for {{ $portfolio->full_name }}</h1>
            <p class="mt-3 text-lg leading-relaxed text-[var(--muted)]">Preview any template with your own data, then select the one you like. You can change it later.</p>
        </div>

        @error('selected_template')
            <div class="mt-6 max-w-xl rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">{{ $message }}</div>
        @enderror

        {{-- One template per row; the selected one is filled in deep green --}}
        <div class="mt-10 space-y-4">
            @foreach ($templates as $key => $template)
                @php $isCurrent = $portfolio->selected_template === $key; @endphp
                <article class="flex flex-col gap-5 rounded-xl border p-4 sm:flex-row sm:items-center sm:gap-6 {{ $isCurrent ? 'border-[var(--deep)] bg-[var(--deep)] text-white' : 'border-[var(--line)] bg-[var(--surface)]' }}">
                    <div class="w-full shrink-0 sm:w-56">
                        <x-template-thumb :template="$key" />
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h2 class="font-display text-xl font-bold {{ $isCurrent ? 'text-white' : 'text-[var(--ink)]' }}">{{ $template['name'] }}</h2>
                            @if ($isCurrent)<span class="rounded-md bg-[var(--mark)] px-2 py-0.5 text-xs font-bold text-[var(--deep)]">Selected</span>@endif
                        </div>
                        <p class="mt-1 text-sm leading-relaxed {{ $isCurrent ? 'text-[#c3d0cb]' : 'text-[var(--muted)]' }}">{{ $template['description'] }}</p>
                    </div>

                    <div class="flex shrink-0 gap-2">
                        <a href="{{ route('portfolios.preview', [$portfolio, $key]) }}"
                           class="inline-flex items-center justify-center gap-1.5 rounded-[0.6rem] border px-4 py-2.5 text-sm font-semibold transition {{ $isCurrent ? 'border-[#4a7a6d] text-white hover:border-white' : 'border-[var(--ink)] text-[var(--ink)] hover:bg-white' }}">
                            <x-icon name="eye" class="h-4 w-4" /> Preview
                        </a>
                        <form method="POST" action="{{ route('portfolios.template.update', $portfolio) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="selected_template" value="{{ $key }}">
                            <button type="submit" class="rounded-[0.6rem] px-4 py-2.5 text-sm font-semibold transition {{ $isCurrent ? 'bg-[var(--mark)] text-[var(--deep)] hover:brightness-95' : 'bg-[var(--ink)] text-white hover:bg-[var(--ink-soft)]' }}">{{ $isCurrent ? 'Continue' : 'Select' }}</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8 flex gap-6 text-sm">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="font-medium text-[var(--ink)] underline decoration-[var(--mark)] decoration-2 underline-offset-4">&larr; Edit information</a>
            <a href="{{ route('portfolios.index') }}" class="font-medium text-[var(--muted)] hover:text-[var(--ink)]">My portfolios</a>
        </div>
    </section>
</x-site-layout>