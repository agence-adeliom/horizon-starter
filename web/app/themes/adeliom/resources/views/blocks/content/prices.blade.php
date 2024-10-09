<x-block :fields="$fields">
  <div class="flex flex-col items-center">
    <div class="text-center">
      @isset($fields['uptitle'])
        <x-typography.uptitle :content="$fields['uptitle']"/>
      @endisset

      @isset($fields['title'])
        <x-typography.heading :fields="$fields['title']" size="3"/>
      @endisset
    </div>

    <div>
      @isset($fields['wysiwyg'])
        <x-typography.text :content="$fields['wysiwyg']" class="text-center"/>
      @endisset
    </div>

    @isset($fields['prices'])
      <div class="grid grid-cols-3">
        @foreach($fields['prices'] as $price)
          <x-cards.card-price :fields="$price"/>
        @endforeach
      </div>
    @endisset
  </div>
</x-block>
