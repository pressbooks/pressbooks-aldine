<div class="book"
  data-date-published="{{ str_replace('-', '', @$book['metadata']['datePublished']) }}"
  data-license="{{ (new \Pressbooks\Licensing())->getLicenseFromUrl($book['metadata']['license']['url']) }}"
  data-subject="{{ sanitize_title(@$book['metadata']['keywords']) }}"
>
  @if(isset($book['metadata']['keywords']))
  <p class="book__subject">
    <a href="{{ network_home_url('/catalog/#') . $book['metadata']['keywords'] }}">{{ $book['metadata']['keywords'] }}</a>
  </p>
  @endif
  <p class="book__title">
    <a href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
  </p>
  <p class="book__read-more">
    <a href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
  </p>
</div>
