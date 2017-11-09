@component('mail::message')

@component('mail::panel')
${{ $price }}
@endcomponent

Thank you for your payment!

Thanks,<br>
{{ env('MAIL_HEADER') }}
@endcomponent