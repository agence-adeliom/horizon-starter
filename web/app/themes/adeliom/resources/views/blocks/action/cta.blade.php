<x-block :fields="$fields">
  <x-action.button :object="$fields['button']"/>

  <x-action.buttons :buttons="[$fields['button'], $fields['button']]"/>
</x-block>
