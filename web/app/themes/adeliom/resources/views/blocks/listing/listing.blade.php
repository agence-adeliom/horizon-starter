@php
  $postType = null;

  if(isset($fields['postType'])){
      $postType = $fields['postType'];
  }
@endphp

<div class="listing-block">
  <livewire:listing.listing :post-type="$postType"/>
</div>
