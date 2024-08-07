<div>
  @if($filters)
    <form wire:change="handleFilters">
      @foreach($filters as $type=>$filter)
        <x-horizon.filter :value="$filter" :model="'filterFields.'.$filter['name']"/>
      @endforeach
    </form>
  @endif

  <x-horizon.results-counter :value="$data" singular="élément" plural="éléments"/>

  <div class="loading hidden">
    Loading
  </div>

  @if(!empty($data['items']))
    <div class="results">
      @foreach($data['items'] as $post)
        @php(dump($post))
      @endforeach
    </div>
  @endif

  <x-horizon.pagination :data="$data" handle="setPage" :has-buttons="true"/>
</div>
