@php
  $postType = null;

  if(isset($fields['postType'])){
      $postType = $fields['postType'];
  }
@endphp

<livewire:listing.listing :post-type="$postType"/>
