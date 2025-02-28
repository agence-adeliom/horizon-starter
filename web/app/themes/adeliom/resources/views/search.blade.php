@extends('layouts.app')

@section('content')
  @foreach(\Adeliom\HorizonTools\Services\ClassService::getAllSearchableCustomPostTypeClasses() as $class)
    <x-search.single-post-type-search :post-type-class="$class"/>
  @endforeach

  <x-search.global-post-type-search/>
@endsection
