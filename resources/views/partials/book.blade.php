<div class="book"
  data-date-published="{{ @$book['metadata']['datePublished'] }}"
  data-license="{{ (new \Pressbooks\Licensing())->getLicenseFromUrl($book['metadata']['license']) }}"
  data-subject="{{ sanitize_title(@$book['metadata']['keywords']) }}"
>
  @if(isset($book['metadata']['keywords']))
  <p class="subject">
    <a href="{{ network_home_url('/catalog/keyword/') . $book['metadata']['keywords'] . '/' }}">{{ $book['metadata']['keywords'] }}</a>
  </p>
  @endif
  <p class="title">
    <a href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
  </p>
  <p class="read-more">
    <a href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
  </p>
</div>
