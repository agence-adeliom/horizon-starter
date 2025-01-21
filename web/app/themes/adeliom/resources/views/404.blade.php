@extends('layouts.app')

@section('content')
    <x-block class="pb-40 lg:pb-60">
        @if ($upTitle)
            <x-typography.uptitle :content="$upTitle" />
        @endif
        @if ($title)
            <x-typography.heading :content="$title" size="3" />
        @endif

        <div class="grid gap-6 mt-6 lg:grid-cols-2 lg:mt-10">
            @if ($firstCol)
                <div class="flex flex-col gap-4">
                    @isset($firstCol['title'])
                        @if ($firstCol['title'])
                            <x-typography.heading :content="$firstCol['title']" size="4" />
                        @endif
                    @endisset
                    @isset($firstCol['wysiwyg'])
                        @if ($firstCol['wysiwyg'])
                            <x-typography.text :content="$firstCol" />
                        @endif
                    @endisset
                </div>
            @endif

            @if ($secondCol)
                <div class="flex flex-col gap-4">
                    @isset($secondCol['title'])
                        @if ($secondCol['title'])
                            <x-typography.heading :content="$secondCol['title']" size="4" />
                        @endif
                    @endisset
                    @isset($secondCol['wysiwyg'])
                        @if ($secondCol['wysiwyg'])
                            <x-typography.text :content="$secondCol" />
                        @endif
                    @endisset
                </div>
            @endif
        </div>
    </x-block>
@endsection
