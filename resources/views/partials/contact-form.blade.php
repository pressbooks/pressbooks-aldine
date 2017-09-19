<section class="contact" id="contact">
  <h2>{{ $contact_form_title }}</h2>
  <form class="form" action="{{ network_home_url('/#contact') }}" method="post">
    @if($contact_form_response)
    <p class="form__notice form__notice--{{ $contact_form_response['status'] }}">{{ $contact_form_response['message'] }}</p>
    @endif
    <input type="hidden" name="submitted" value="1">
    <p class="form__row @if(@$contact_form_response['field'] === 'visitor_name'){{ 'form__row--error' }}@endif">
      <label class="clip" for="visitor_name">{{ __('Your name*', 'aldine' ) }}</label>
      <input type="text" placeholder="{{ __('Your name*', 'aldine' ) }}" name="visitor_name" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_name']) }}@endif"></p>
    <p class="form__row @if(@$contact_form_response['field'] === 'visitor_email'){{ 'form__row--error' }}@endif">
      <label class="clip" for="visitor_email">{{ __('Your email*', 'aldine' ) }}</label>
      <input type="email" placeholder="{{ __('Your email*', 'aldine' ) }}" name="visitor_email" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_email']) }}@endif"></p>
    <p class="form__row @if(@$contact_form_response['field'] === 'visitor_institution'){{ 'form__row--error' }}@endif">
      <label class="clip" for="visitor_institution">{{ __('Your institution*', 'aldine' ) }}</label>
      <input type="text" placeholder="{{ __('Your institution*', 'aldine' ) }}" name="visitor_institution" value="@if($contact_form_response['status'] === 'error'){{ @esc_attr($_POST['visitor_institution']) }}@endif"></p>
    <p class="form__row @if(@$contact_form_response['field'] === 'message'){{ 'form__row--error' }}@endif">
      <label class="clip" for="message">{{ __('Your message here', 'aldine' ) }}</label>
      <textarea type="text" placeholder="{{ __('Your message here', 'aldine' ) }}" name="message">@if($contact_form_response['status'] === 'error'){{ @esc_textarea($_POST['message']) }}@endif</textarea></p>
    <p class="form__row"><input class="button button--small button--outline" type="submit" value="{{ __('Send', 'aldine' ) }}" /></p>
  </form>
</section>
