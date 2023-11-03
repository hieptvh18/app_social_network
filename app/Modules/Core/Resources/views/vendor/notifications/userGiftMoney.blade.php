<x-mail::message>
{{-- Greeting --}}
# Xin chào,

{{-- Intro Lines --}}
**{{ $name }}** yêu cầu đổi thưởng tiền mặt **{{ $mission_name }}**
với phương thức nhận quà qua **{{ $info_method_receive }}** : **{{ $method_receive }}**<br />

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
