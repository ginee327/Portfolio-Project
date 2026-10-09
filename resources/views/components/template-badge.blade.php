{{-- Small pill showing which template a portfolio uses --}}
@props(['template'])
@php
    $styles = [
        'simple'   => 'bg-[#e1e7df] text-[#10312b] ring-[#c9d3c6]',
        'modern'   => 'bg-[#10312b] text-white ring-[#10312b]',
        'creative' => 'bg-[#f2b632] text-[#10312b] ring-[#e0a21f]',
    ];
@endphp
<span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $styles[$template] ?? $styles['simple'] }}">
    {{ config("portfolio.templates.{$template}.name", ucfirst($template)) }}
</span>