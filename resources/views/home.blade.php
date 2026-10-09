<x-site-layout title="Build your portfolio">

    {{-- Hero: headline on the left, a form-to-portfolio mock on the right --}}
    <section class="mx-auto grid max-w-6xl items-center gap-14 px-4 pb-20 pt-14 sm:px-6 md:grid-cols-2 md:pt-24 lg:px-8">
        <div>
            <h1 class="font-display text-5xl font-extrabold leading-[1.02] text-[var(--ink)] sm:text-6xl">
                One form in.<br>One portfolio out.
            </h1>
            <p class="mt-6 max-w-md text-lg leading-relaxed text-[var(--muted)]">
                Enter your details once, choose Simple, Modern, or Creative, and preview the finished portfolio straight away.
            </p>
            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('portfolios.create') }}" class="inline-flex items-center justify-center gap-2 rounded-[0.6rem] bg-[var(--ink)] px-6 py-3 font-semibold text-white transition hover:bg-[var(--ink-soft)]">
                    Create Portfolio <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ route('templates.index') }}" class="inline-flex items-center justify-center gap-2 rounded-[0.6rem] border border-[var(--ink)] px-6 py-3 font-semibold text-[var(--ink)] transition hover:bg-white">
                    <x-icon name="eye" class="h-5 w-5" /> View Templates
                </a>
            </div>
        </div>

        {{-- Decorative mock: what you type, and what you get --}}
        <div class="relative mx-auto h-[26rem] w-full max-w-md" aria-hidden="true">
            <div class="absolute left-0 top-0 w-[80%] rounded-xl border border-[var(--line)] bg-[var(--surface)] p-5">
                <p class="text-xs text-[var(--muted)]">Your details</p>
                <div class="mt-3 space-y-2.5 text-sm">
                    <div class="flex justify-between border-b border-[var(--line)] pb-2"><span class="text-[var(--muted)]">Name</span><span class="font-semibold">Alex Rivera</span></div>
                    <div class="flex justify-between border-b border-[var(--line)] pb-2"><span class="text-[var(--muted)]">Title</span><span class="font-semibold">Full-Stack Developer</span></div>
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <span class="rounded-md bg-[var(--chalk)] px-2 py-1 text-xs font-medium">PHP</span>
                        <span class="rounded-md bg-[var(--chalk)] px-2 py-1 text-xs font-medium">Laravel</span>
                        <span class="rounded-md bg-[var(--chalk)] px-2 py-1 text-xs font-medium">React</span>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 right-0 w-[72%] rounded-xl bg-[var(--ink)] p-6 text-white shadow-2xl shadow-[#10312b]/30">
                <p class="text-xs text-[#9db0a9]">Your portfolio</p>
                <p class="font-display mt-3 text-2xl font-bold leading-tight">Alex Rivera</p>
                <p class="mt-1 text-sm text-[#c3d0cb]">Full-Stack Developer</p>
                <div class="mt-5 h-1 w-12 rounded bg-[var(--mark)]"></div>
                <div class="mt-5 grid grid-cols-2 gap-2">
                    <div class="h-12 rounded-md bg-[var(--ink-soft)]"></div>
                    <div class="h-12 rounded-md bg-[var(--ink-soft)]"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works: a real sequence, so the numbers mean something --}}
    <section class="border-y border-[var(--line)] bg-[var(--surface)]">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
            @foreach ([
                ['Enter your details', 'Education, skills, projects, experience, and links go into one guided form.'],
                ['Pick a template', 'Choose Simple, Modern, or Creative. You can switch whenever you like.'],
                ['Preview and edit', 'See the result right away, then update or delete it as your career changes.'],
            ] as $i => [$title, $text])
                <div>
                    <p class="font-display text-5xl font-extrabold text-[var(--mark)]">{{ $i + 1 }}</p>
                    <h3 class="font-display mt-3 text-xl font-bold text-[var(--ink)]">{{ $title }}</h3>
                    <p class="mt-2 max-w-xs text-[var(--muted)]">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Templates: shown open on the page, no card boxes --}}
    <section class="mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="max-w-xl">
            <h2 class="font-display text-3xl font-bold text-[var(--ink)] sm:text-4xl">Same information, three different looks</h2>
            <p class="mt-3 text-[var(--muted)]">Open a demo to see each template with sample content.</p>
        </div>
        <div class="mt-12 grid gap-10 md:grid-cols-3">
            @foreach ($templates as $key => $template)
                <a href="{{ route('templates.demo', $key) }}" class="group block">
                    <div class="overflow-hidden rounded-xl border border-[var(--line)] bg-[var(--surface)] p-3 transition group-hover:border-[var(--ink)]">
                        <x-template-thumb :template="$key" />
                    </div>
                    <h3 class="font-display mt-4 text-xl font-bold text-[var(--ink)] underline decoration-transparent decoration-2 underline-offset-4 transition group-hover:decoration-[var(--mark)]">{{ $template['name'] }}</h3>
                    <p class="mt-1 text-sm leading-relaxed text-[var(--muted)]">{{ $template['description'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Good to know: a plain ruled list instead of a card grid --}}
    <section class="border-t border-[var(--line)]">
        <div class="mx-auto grid max-w-6xl gap-x-16 px-4 py-16 sm:px-6 md:grid-cols-[1fr_2fr] lg:px-8">
            <h2 class="font-display text-3xl font-bold text-[var(--ink)]">Good to know</h2>
            <dl class="mt-8 divide-y divide-[var(--line)] border-y border-[var(--line)] md:mt-0">
                @foreach ([
                    ['cloud',  'Saved online',     'Your data lives in an online database, so it is still there after you refresh.'],
                    ['shield', 'Private accounts', 'Sign in to manage your work. Only you can edit or delete your portfolios.'],
                    ['eye',    'Instant preview',  'See your portfolio in any template before you decide.'],
                    ['pencil', 'Edit anytime',     'Update your details whenever something changes.'],
                ] as [$icon, $term, $text])
                    <div class="flex gap-4 py-5">
                        <x-icon :name="$icon" class="mt-0.5 h-6 w-6 shrink-0 text-[var(--ink)]" />
                        <div>
                            <dt class="font-semibold text-[var(--ink)]">{{ $term }}</dt>
                            <dd class="mt-1 text-sm text-[var(--muted)]">{{ $text }}</dd>
                        </div>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

</x-site-layout>