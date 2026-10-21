@if ($url)
    <div class="{{ $containerClass }}"
        @if ($autoplay) x-data="{ playing: true }" x-init="if (matchMedia('(prefers-reduced-motion: reduce)').matches) { $refs.video.pause(); playing = false }" @endif>
        <video width="{{ $width }}" height="{{ $height }}" class="{{ trim('max-w-full h-auto ' . $class) }}"
            @if ($title) aria-label="{{ $title }}" @endif
            @if ($autoplay) x-ref="video" autoplay muted playsinline @endif
            @if ($loop) loop @endif @if ($controls) controls @endif>
            <source src="{{ $url }}" @if ($mimeType) type="{{ $mimeType }}" @endif>
            @if ($trackSrc)
                <track src="{{ $trackSrc }}" kind="{{ $trackKind }}"
                    @if ($trackLabel) label="{{ $trackLabel }}" @endif srclang="{{ $trackLang }}"
                    default>
            @endif
            @if ($unsupportedMessage)
                {{ $unsupportedMessage }}
            @endif
        </video>

        @if ($autoplay && !$controls)
            <button type="button"
                class="btn btn-tertiary btn-contained btn-md btn-icon-only rounded-full absolute bottom-4 right-4 z-10"
                @click="playing ? $refs.video.pause() : $refs.video.play(); playing = !playing"
                data-label-pause="{{ __('Mettre la vidéo en pause', 'sage') }}"
                data-label-play="{{ __('Lire la vidéo', 'sage') }}"
                :aria-label="playing ? $el.dataset.labelPause : $el.dataset.labelPlay">
                <template x-if="playing"><x-fas-pause class="icon-4" /></template>
                <template x-if="!playing"><x-fas-play class="icon-4" /></template>
            </button>
        @endif
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
