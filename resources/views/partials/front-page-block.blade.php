<div class="block block-{{ $index }} flex flex-column items-center justify-center p-0 w-100">
  <div class="inside tc">
    @if($title)
      <h3 class="tc ttu primary">{{ $title }}</h3>
    @endif
    {{ $slot }}
    @if($button_url && $button_title)
      <a class="button button-primary" href="{{ $button_url }}">{{ $button_title }}</a>
    @endif
  </div>
</div>
