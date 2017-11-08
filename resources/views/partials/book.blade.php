<div class="book"
  data-date-published="{{ str_replace('-', '', @$book['metadata']['datePublished']) }}"
  data-license="{{ (new \Pressbooks\Licensing())->getLicenseFromUrl($book['metadata']['license']['url']) }}"
  data-subject="{{ substr(@$book['subject'], 0, 2) }}"
>
  @if(isset($book['metadata']['keywords']))
  <p class="book__subject">
    <a href="{{ network_home_url('/catalog/#') . substr($book['subject'], 0, 2) }}">{{ \Pressbooks\Metadata\get_subject_from_thema($book['subject']) }}</a>
  </p>
  @endif
  <p class="book__title">
    <a href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
  </p>
  <p class="book__read-more">
    <a href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
  </p>
</div>
