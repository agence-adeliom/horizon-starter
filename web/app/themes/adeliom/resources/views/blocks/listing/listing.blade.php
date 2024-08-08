@php
  $postType = null;
  $perPage = 12;

  if(isset($fields['postType'])){
      $postType = $fields['postType'];
  }

  if(isset($fields['perPage'])){
      $perPage = $fields['perPage'];
  }
@endphp

<x-block :fields="$fields">
  @isset($fields['uptitle'])
    <x-uptitle :content="$fields['uptitle']"/>
  @endisset

  @isset($fields['title'])
    <x-heading :fields="$fields['title']"/>
  @endisset

    <livewire:listing.listing :post-type="$postType" :per-page="$perPage"/>
</x-block>
