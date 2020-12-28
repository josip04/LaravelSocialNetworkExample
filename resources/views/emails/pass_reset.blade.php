@component('mail::message')

# We got a request to reset your password.

@component('mail::button', ['url' => '{{ $url }}'])
Reset Password
@endcomponent

Use the following [link]({{ $url }}) if nothing works to reset the password.

If you ignore this message, your password wont`be changed.

If you didnt send this request, let us know at {{ config('admin.admin_email') }}.


Thanks,<br>
{{ config('admin.admin_name') }}
@endcomponent
