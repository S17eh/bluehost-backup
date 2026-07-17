@component('mail::message')

Name : {{ $data['name']}} <br />
Email : {{ $data['email']}} <br />
Mobile Number : {{ $data['mobile_number']}} <br />

Message :
{{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent