<!DOCTYPE html>
<html>
<head>
    <title>Verify Email Address</title>
</head>
<body>
<h1>Verify Your Email Address</h1>
<p>Hello {{ $user->name }},</p>
<p>Please click the following link to verify your email address:</p>
<p><a href="{{ route('verification.verify', ['token' => $user->email_verification_token]) }}">Verify Email Address</a></p>
<p>If you didn't create an account, you can safely ignore this email.</p>
</body>
</html>
