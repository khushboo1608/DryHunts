<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}} | Reset Password</title>
</head>
<body>
    <h1>Hello,{{ $details['name'] }}</h1>
    <p>You are receiving this email because we received a password reset request for your account</p>
    <p><a href="{{ route('reset.password.get', $details['token']) }}">Reset Password</a></p>

    <p>Thank you</p>
</body>
</html>