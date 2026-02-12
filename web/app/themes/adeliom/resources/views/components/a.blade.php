<{{ $tag }}
    @if(!empty($id)) id="{{ $id }}" @endif
    @if(!empty($hrefAttribute)) {!! $hrefAttribute !!} @endif
    @if(!empty($class)) class="{{ $class }}" @endif
    @if(!empty($target)) target="{{ $target }}" @endif
    @if(!empty($rel)) rel="{{ $rel }}" @endif
    @if(!empty($title)) title="{{ $title }}" @endif
    @if(!empty($ariaLabel)) aria-label="{{ $ariaLabel }}" @endif
    @if(!empty($type)) type="{{ $type }}" @endif
    @if(!empty($wireClick)) wire:click.prevent="{{ $wireClick }}" @endif
    @if($handleLivewireLoading) wire:loading.class="lw-loading" @endif
    @if(!empty($wireTarget)) wire:target="{{ $wireTarget }}" @endif
    @if(!empty($role)) role="{{ $role }}" @endif
    @if(null !== $tabindex) tabindex="{{ $tabindex }}" @endif
    @if(!empty($openAuthForm)) open-auth-form @endif
    @if(!empty($openNewsletterForm)) open-newsletter-form @endif
    @if(!empty($atClick)) @click="{{ $atClick }}" @endif
    @if(!empty($xShow)) x-show="{{ $xShow }}" @endif
>
    {{ $slot }}
</{{ $tag }}>
