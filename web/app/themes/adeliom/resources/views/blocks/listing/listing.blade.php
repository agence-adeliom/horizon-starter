@php
  $postType = null;

  if(isset($fields['postType'])){
      $postType = $fields['postType'];
  }
@endphp

<x-block :fields="$fields">
  @isset($fields['uptitle'])
    <x-uptitle :content="$fields['uptitle']"/>
  @endisset

  @isset($fields['title'])
    <x-heading :fields="$fields['title']"/>
  @endisset

  <livewire:listing.listing :post-type="$postType"/>
</x-block>
