<x-mail::message>
{{-- Greeting --}}
# Xin chào **{{ $name }}**,

{{-- Intro Lines --}}
Yêu cầu đổi thưởng **{{ $mission_gift_name }}** đã bị từ chối !!! <br />

Với lý do: **{{ $reason_refuse_approve }}**

-------------------------------- <br />

Mọi thắc mắc xin liên hệ: <br />

<i>Fanpage : </i><a href="https://www.facebook.com/eduquiz.vn" target="_blank">https://www.facebook.com/eduquiz.vn</a><br />
<i>Nhóm cộng đồng : </i> <a href="https://www.facebook.com/groups/eduquiz.vn" target="_blank">https://www.facebook.com/groups/eduquiz.vn</a><br />
<i>Hotline : </i> 0963004496<br />

Chân thành cảm ơn quý khách đã sử dụng ứng dụng!<br>
{{ config('app.name') }}
</x-mail::message>
