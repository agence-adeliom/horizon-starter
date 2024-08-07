<x-block :fields="$fields" :anchor="$block['anchor']" class="caca boudin">
    <x-slot:outContainer>
        <div class="bg-blue">
            Je suis un petit élément en dehors du container hihi
            <p>Bonjour</p>
        </div>

    </x-slot>

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="lg:col-span-5">
            //heading
        </div>

        <div class="lg:col-span-7">
            //wysiwyg
        </div>
    </div>
</x-block>