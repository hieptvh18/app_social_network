<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
 @include('blocks.head')
</head>
<body>
<div id="app">
</div>
<script src="http://localhost:6001/socket.io/socket.io.js"></script>
@include('blocks.script')
</body>
</html>