<x-mail::message>
{{-- Greeting --}}
# Xin chào {{ $name }},

{{-- Intro Lines --}}
Cảm ơn bạn đã gửi thông tin liên hệ với chúng tôi <br />

Thông tin liên hệ <br />

------------------------ <br />
Tên                     :  **{{$name}}** <br/>
Email                   : **{{$email}}**  <br/>
Nội dung                : **{{$message}}** <br/>
Trạng thái              : **Mới**<br/>
------------------------ <br />

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
