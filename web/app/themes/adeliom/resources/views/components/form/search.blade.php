<form action="" @class([
    'w-full flex flex-col sm:flex-row sm:justify-center gap-3',
    $attributes->get('class'),
])>

    <x-form.input :x-init="$isModal ? '$watch(\'open\', value => $focus.focus($el))' : ''" name="search" label="Recherche" hideLabel type="text" wrapper-class="flex-1"
        class="h-[42px]" placeholder="Tapez un mot clé..." required />
    <x-action.button icon="fas-search" type="primary" submit>Rechercher</x-action.button>
</form>
