<form action="{{ home_url('/') }}" @class([
    'w-full flex flex-col sm:flex-row sm:justify-center gap-3',
    $attributes->get('class'),
])>

    <x-form.input :x-init="$isModal ? '$watch(\'open\', value => $focus.focus($el))' : ''" name="s" :label="__('Recherche', 'sage')" hideLabel type="text" wrapper-class="flex-1"
        class="h-[42px]" :placeholder="__('Tapez un mot clé...', 'sage')" required />
    <x-action.button icon="fas-search" type="primary" tag="button" submit>{{ __('Rechercher', 'sage') }}</x-action.button>
</form>
