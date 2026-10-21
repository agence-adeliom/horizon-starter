@if ($id)
    <div class="relative w-full aspect-video">
        {{-- Pas de width / height / frameborder : attributs de présentation interdits sur une iframe (RGAA 10.1) --}}
        <iframe class="absolute inset-0 w-full h-full border-0"
            src="https://www.youtube.com/embed/{{ $id }}" title="{{ $title }}"
            @if ($allowAttribute) allow="{{ $allowAttribute }}" @endif
            @if ($referrerPolicy) referrerpolicy="{{ $referrerPolicy }}" @endif
            @if ($allowFullscreen) allowfullscreen @endif></iframe>
    </div>

    {{-- Transcription --}}
    @if ($transcript)
        <details class="mt-4">
            <summary class="cursor-pointer font-semibold text-primary">
                {{ __('Lire la transcription de la vidéo', 'sage') }}</summary>
            <x-typography.text :content="$transcript" class="mt-2" />
        </details>
    @endif
@endif
