<div>
  @if(!empty($data['items']))
    @foreach($data['items'] as $post)
      @php(dump($post))
    @endforeach
  @endif

  <x-horizon.pagination :data="$data" handle="setPage" :has-buttons="true"/>
</div>
