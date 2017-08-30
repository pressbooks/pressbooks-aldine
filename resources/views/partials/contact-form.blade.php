<section class="contact flex flex-column justify-center items-center w-100" id="contact">
  <h3 class="tc ttu">{{ $contact_form_title }}</h3>
  <form action="{{ network_home_url('/#contact') }}" method="post">
    @if($contact_form_response)
      <p class="tl mb4 w-100 {{ $contact_form_response['status'] }}">{{ $contact_form_response['message'] }}</p>
    @endif
    <input type="hidden" name="submitted" value="1">
    <p class="flex flex-row items-center @if(@$contact_form_response['field'] === 'visitor_name'){{ 'error' }}@endif">
      <label class="clip" for="visitor_name">{{ __('Your name*', 'aldine' ) }}</label>
      <input class="input-reset" type="text" placeholder="{{ __('Your name*', 'aldine' ) }}" name="visitor_name" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_name']) }}@endif"></p>
    <p class="flex flex-row items-center @if(@$contact_form_response['field'] === 'visitor_email'){{ 'error' }}@endif">
      <label class="clip" for="visitor_email">{{ __('Your email*', 'aldine' ) }}</label>
      <input class="input-reset" type="email" placeholder="{{ __('Your email*', 'aldine' ) }}" name="visitor_email" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_email']) }}@endif"></p>
    <p class="flex flex-row items-center @if(@$contact_form_response['field'] === 'visitor_institution'){{ 'error' }}@endif">
      <label class="clip" for="visitor_institution">{{ __('Your institution*', 'aldine' ) }}</label>
      <input class="input-reset" type="text" placeholder="{{ __('Your institution*', 'aldine' ) }}" name="visitor_institution" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_institution']) }}@endif"></p>
    <p class="flex flex-row items-center @if(@$contact_form_response['field'] === 'message'){{ 'error' }}@endif">
      <label class="clip" for="message">{{ __('Your message here', 'aldine' ) }}</label>
      <textarea class="input-reset" type="text" placeholder="{{ __('Your message here', 'aldine' ) }}" name="message">@if($contact_form_response['status'] === 'error'){{ @esc_textarea($_POST['message']) }}@endif</textarea></p>
    <p class="tc"><input class="button-reset button button-small button-secondary button-outline input-reset pointer" type="submit" value="{{ __('Send', 'aldine' ) }}" /></p>
  </form>
</section>
