<x-site-layout title="Templates">
    @php $firstKey = collect($templates)->keys()->first(); @endphp

    <section class="mx-auto max-w-6xl px-4 pb-6 pt-14 sm:px-6 lg:px-8">
        <h1 class="font-display text-4xl font-extrabold text-[var(--ink)] sm:text-5xl">Choose your style</h1>
        <p class="mt-4 max-w-xl text-lg leading-relaxed text-[var(--muted)]">Switch between the three templates, preview one with sample data, then use your own details.</p>
    </section>

    {{-- Showcase: pick a template on the left, see it large on the right --}}
    <section class="mx-auto max-w-6xl px-4 pb-20 sm:px-6 lg:px-8" x-data="{ active: '{{ $firstKey }}' }">
        <div class="overflow-hidden rounded-2xl bg-[var(--deep)] text-white">
            <div class="grid md:grid-cols-[17rem_1fr]">

                {{-- Template switcher --}}
                <div class="flex gap-2 overflow-x-auto border-b border-[#2f5a4f] p-4 md:flex-col md:border-b-0 md:border-r md:p-6" role="tablist" aria-label="Templates">
                    @foreach ($templates as $key => $template)
                        <button type="button" role="tab" @click="active = '{{ $key }}'" :aria-selected="active === '{{ $key }}'"
                                :class="active === '{{ $key }}' ? 'bg-[var(--mark)] text-[var(--deep)]' : 'text-[#c3d0cb] hover:bg-[var(--ink-soft)]'"
                                class="font-display shrink-0 rounded-lg px-4 py-3 text-left text-lg font-bold transition">
                            {{ $template['name'] }}
                        </button>
                    @endforeach
                </div>

                {{-- Large preview with details --}}
                <div class="p-5 sm:p-8">
                    <div class="overflow-hidden rounded-xl border border-[#2f5a4f] bg-[#0b231e]">
                        <div class="flex gap-1.5 border-b border-[#2f5a4f] px-4 py-3" aria-hidden="true">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#2f5a4f]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#2f5a4f]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[var(--mark)]"></span>
                        </div>
                        <div class="p-4 sm:p-6">
                            @foreach ($templates as $key => $template)
                                <div x-show="active === '{{ $key }}'" x-cloak x-transition.opacity.duration.200ms role="tabpanel">
                                    <x-template-thumb :template="$key" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @foreach ($templates as $key => $template)
                        <div x-show="active === '{{ $key }}'" x-cloak class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h2 class="font-display text-2xl font-bold">{{ $template['name'] }}</h2>
                                <p class="mt-2 max-w-md leading-relaxed text-[#c3d0cb]">{{ $template['description'] }}</p>
                            </div>
                            <div class="flex shrink-0 gap-3">
                                <a href="{{ route('templates.demo', $key) }}" class="inline-flex items-center justify-center gap-2 rounded-[0.6rem] border border-[#4a7a6d] px-5 py-2.5 text-sm font-semibold text-white transition hover:border-white">
                                    <x-icon name="eye" class="h-4 w-4" /> Preview
                                </a>
                                <a href="{{ route('portfolios.create') }}" class="inline-flex items-center justify-center rounded-[0.6rem] bg-[var(--mark)] px-5 py-2.5 text-sm font-semibold text-[var(--deep)] transition hover:brightness-95">Select</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <p class="mt-6 text-sm text-[var(--muted)]">You pick the final template after entering your information.</p>
    </section>
</x-site-layout>