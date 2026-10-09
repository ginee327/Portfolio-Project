{{-- Template 1 - Simple: paper-white page, tinted profile panel, CV-style rows with titles in the left margin --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);
    $phoneHref = preg_replace('/[^0-9+]/', '', (string) $portfolio->contact_number);
@endphp
<div class="bg-white text-[#2f4a43]">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[320px_1fr] lg:gap-14 lg:px-8 lg:py-16">

        {{-- Profile panel: photo, name, contact, links, skills --}}
        <aside class="space-y-7 rounded-xl bg-[#e8ede6] p-7 lg:sticky lg:top-24 lg:self-start">
            <div>
                @if ($portfolio->profile_picture_url)
                    <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}" class="h-36 w-36 rounded-full object-cover ring-4 ring-white">
                @else
                    <span class="font-display flex h-36 w-36 items-center justify-center rounded-full bg-[#10312b] text-5xl font-bold text-white ring-4 ring-white">{{ $portfolio->initials }}</span>
                @endif
                <h1 class="font-display mt-6 text-3xl font-extrabold leading-tight text-[#10312b]">{{ $portfolio->full_name }}</h1>
                <p class="mt-1 text-[#4a6a60]">{{ $portfolio->professional_title }}</p>
            </div>

            <div>
                <h2 class="font-display text-sm font-bold text-[#10312b]">Contact</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div><dt class="sr-only">Email</dt><dd><a href="mailto:{{ $portfolio->email }}" class="break-all hover:text-[#10312b] hover:underline">{{ $portfolio->email }}</a></dd></div>
                    <div><dt class="sr-only">Phone</dt><dd><a href="tel:{{ $phoneHref }}" class="hover:text-[#10312b] hover:underline">{{ $portfolio->contact_number }}</a></dd></div>
                    @if ($portfolio->address)<div><dt class="sr-only">Address</dt><dd>{{ $portfolio->address }}</dd></div>@endif
                </dl>
            </div>

            @if ($socials)
                <div>
                    <h2 class="font-display text-sm font-bold text-[#10312b]">Elsewhere</h2>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        @foreach ($socials as $platform => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#10312b] hover:underline">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($portfolio->skills->count())
                <div>
                    <h2 class="font-display text-sm font-bold text-[#10312b]">Skills</h2>
                    <ul class="mt-3 flex flex-wrap gap-1.5 text-xs font-medium">
                        @foreach ($portfolio->skills as $skill)
                            <li class="rounded-md bg-white px-2.5 py-1 text-[#10312b]">{{ $skill->skill_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($languages)
                <div>
                    <h2 class="font-display text-sm font-bold text-[#10312b]">Languages</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $languages) }}</p>
                </div>
            @endif

            @if ($interests)
                <div>
                    <h2 class="font-display text-sm font-bold text-[#10312b]">Interests</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $interests) }}</p>
                </div>
            @endif

            @if ($portfolio->resume_url)
                <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-[0.6rem] bg-[#10312b] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1c4a40]">
                    <x-icon name="document" class="h-4 w-4" /> Download resume
                </a>
            @endif
        </aside>

        {{-- Main column: each section has its title in the left margin --}}
        <div class="space-y-10">
            <section class="grid gap-3 md:grid-cols-[8.5rem_1fr]">
                <h2 class="font-display text-xl font-bold text-[#10312b]">About</h2>
                <p class="whitespace-pre-line leading-relaxed">{{ $portfolio->about }}</p>
            </section>

            @if ($portfolio->experiences->count())
                <section class="grid gap-3 border-t border-[#dde1da] pt-10 md:grid-cols-[8.5rem_1fr]">
                    <h2 class="font-display text-xl font-bold text-[#10312b]">Experience</h2>
                    <div class="space-y-6">
                        @foreach ($portfolio->experiences as $job)
                            <article>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                                    <h3 class="font-semibold text-[#10312b]">{{ $job->position }} <span class="font-normal text-[#5a6b66]">at {{ $job->company }}</span></h3>
                                    <span class="text-sm text-[#5a6b66]">{{ $job->period() }}</span>
                                </div>
                                @if ($job->description)<p class="mt-1.5 whitespace-pre-line text-sm leading-relaxed">{{ $job->description }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->educations->count())
                <section class="grid gap-3 border-t border-[#dde1da] pt-10 md:grid-cols-[8.5rem_1fr]">
                    <h2 class="font-display text-xl font-bold text-[#10312b]">Education</h2>
                    <div class="space-y-5">
                        @foreach ($portfolio->educations as $edu)
                            <article class="flex flex-wrap items-baseline justify-between gap-x-4">
                                <div>
                                    <h3 class="font-semibold text-[#10312b]">{{ $edu->school }}</h3>
                                    <p class="text-sm">{{ $edu->degree }}</p>
                                </div>
                                <span class="text-sm text-[#5a6b66]">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</span>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->projects->count())
                <section class="grid gap-3 border-t border-[#dde1da] pt-10 md:grid-cols-[8.5rem_1fr]">
                    <h2 class="font-display text-xl font-bold text-[#10312b]">Projects</h2>
                    <div class="space-y-7">
                        @foreach ($portfolio->projects as $project)
                            <article>
                                <h3 class="font-semibold text-[#10312b]">{{ $project->project_name }}</h3>
                                @if ($project->description)<p class="mt-1 text-sm leading-relaxed">{{ $project->description }}</p>@endif
                                @if ($project->technologyList())
                                    <p class="mt-2 text-xs font-medium text-[#5a6b66]">{{ implode(' / ', $project->technologyList()) }}</p>
                                @endif
                                <p class="mt-2 flex gap-4 text-sm">
                                    @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-[#10312b] underline decoration-[#f2b632] decoration-2 underline-offset-4">Source code</a>@endif
                                    @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-[#10312b] underline decoration-[#f2b632] decoration-2 underline-offset-4">Live demo</a>@endif
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($certs)
                <section class="grid gap-3 border-t border-[#dde1da] pt-10 md:grid-cols-[8.5rem_1fr]">
                    <h2 class="font-display text-xl font-bold text-[#10312b]">Certificates</h2>
                    <ul class="list-disc space-y-1 pl-5 text-sm marker:text-[#f2b632]">
                        @foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach
                    </ul>
                </section>
            @endif
        </div>
    </div>
</div>