<section class="contact flex flex-column justify-center items-center w-100" id="contact">
  <h3 class="tc ttu">{{ $contact_form_title }}</h3>
  <form action="<?php the_permalink(); ?>" method="post">
    <input type="hidden" name="submitted" value="1">
    <p class="flex flex-row items-center"><label class="clip" for="name">{{ __('Your name*', 'aldine' ) }}</label><input class="input-reset" type="text" placeholder="{{ __('Your name*', 'aldine' ) }}" name="name" value="{{ @esc_attr($_POST['name']) }}"></p>
    <p class="flex flex-row items-center"><label class="clip" for="email">{{ __('Your email*', 'aldine' ) }}</label><input class="input-reset" type="email" placeholder="{{ __('Your email*', 'aldine' ) }}" name="email" value="{{ @esc_attr($_POST['email']) }}"></p>
    <p class="flex flex-row items-center"><label class="clip" for="institution">{{ __('Your institution*', 'aldine' ) }}</label><input class="input-reset" type="text" placeholder="{{ __('Your institution*', 'aldine' ) }}" name="institution" value="{{ @esc_attr($_POST['institution']) }}"></p>
    <p class="flex flex-row items-center"><label class="clip" for="content">{{ __('Your message here', 'aldine' ) }}</label><textarea class="input-reset" type="text" placeholder="{{ __('Your message here', 'aldine' ) }}"  name="content">{{ @esc_textarea($_POST['content']) }}</textarea></p>
    <p class="tc"><input class="button-reset button button-small button-secondary button-outline input-reset pointer" type="submit" value="{{ __('Send', 'aldine' ) }}" /></p>
  </form>
</section>
