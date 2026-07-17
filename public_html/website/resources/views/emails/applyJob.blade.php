@component('mail::message')

Name : {{ $data['name']}} <br />
Email : {{ $data['email']}} <br />
Mobile Number : {{ $data['mobile_number']}} <br />
Current Salary : {{ $data['current_salary']}} <br />
Expected Salary : {{ $data['expected_salary']}} <br />
Experience Year : {{ $data['experience_year']}} <br />
Experience Month : {{ $data['experience_month']}} <br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent