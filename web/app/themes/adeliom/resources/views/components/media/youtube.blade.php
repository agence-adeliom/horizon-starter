@if ($id)
    <div class="relative w-full aspect-video">
        <iframe width="{{ $width }}" height="{{ $height }}" class="absolute inset-0 w-full h-full"
            src="https://www.youtube.com/embed/{{ $id }}" title="{{ $title }}" frameborder="0"
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
