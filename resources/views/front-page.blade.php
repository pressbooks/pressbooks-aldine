@extends('layouts.app')

@section('content')
  @if($block_count === 0)
    <div class="block block-1">
      <div class="inside">
        <h3>{{ __('About Pressbooks', 'aldine') }}</h3>
        <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'aldine')}}</p>
      </div>
    </div>
  @elseif($block_count < 4)
    @for($i = 0; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @elseif($block_count === 4)
    <div class="one-two">
      @for($i = 0; $i < 2; $i++)
        <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
          <div class="inside">
            @php(dynamic_sidebar($home_blocks[$i]))
          </div>
        </div>
      @endfor
    </div>
    @for($i = 2; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @endif
  @if(get_theme_mod('pb_front_page_catalog'))
    <div class="block latest-books">
      <div class="inside">
        <h3>{{ get_theme_mod('pb_front_page_catalog_title') }}</h3>
        @php
        $books = wp_remote_get(home_url('/wp-json/pressbooks/v2/books'));
            $books = json_decode($books['body'], true);
            echo '<div class="books">';
            for ($i = 0; $i < 3; $i++) {
                printf(
                    '<div class="book">
                        <a class="subject" href="">TK</a>
                        <a class="title" href="%1$s">%2$s</a>
                        <a class="read-more" href="%1$s">%3$s</a>
                    </div>',
                    $books[$i]['link'],
                    $books[$i]['metadata']['name'],
                    __('About this book &rarr;', 'aldine')
                );
            }
            echo '</div>';
        @endphp
      </div>
    </div>
  @endif
@endsection
