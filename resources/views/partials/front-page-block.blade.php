<div class="block flex flex-column items-center justify-center p-0 w-100">
  <div class="inside tc">
    <h3 class="tc ttu">{{ $title }}</h3>
    {{ $slot }}
    <a class="button" href="{{ $button_url }}">{{ $button_title }}</a>
  </div>
</div>
