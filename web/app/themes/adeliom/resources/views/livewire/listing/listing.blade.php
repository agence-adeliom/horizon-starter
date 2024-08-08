<div>
  <form wire:change="handleFilters">
  @if($filters)
      <div>
        @foreach($filters as $type=>$filter)
          <x-horizon.filter :value="$filter" :model="'filterFields.'.$filter['name']"/>
        @endforeach
      </div>
    @endif

    <div class="flex justify-between">
      <x-horizon.results-counter :value="$data" singular="élément" plural="éléments"/>
      <x-horizon.sort model="order" :options="$sortOptions"/>
    </div>
  </form>

  <div class="loading hidden">
    Loading
  </div>

  @if(!empty($data['items']))
    <div class="results">
      @foreach($data['items'] as $post)
        @php(dump($post))
      @endforeach
    </div>
  @else
    <div>
      Aucun élément
    </div>
  @endif

  <x-horizon.pagination :data="$data" handle="setPage" :has-buttons="true"/>
</div>
