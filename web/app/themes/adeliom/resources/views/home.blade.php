@extends('layouts.app')

@section('content')
  @php
    $postsPageId = get_option('page_for_posts');

    if ($postsPageId) {
      global $post;
      $post = get_post($postsPageId);
      setup_postdata($post);
    }
  @endphp

  @php(the_content())

  @php(wp_reset_postdata())
@endsection
