<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    @vite(['resources/sass/auth/pim-email.scss'])
</head>
<body>
<div class="email">
    <div class="email__header">
        <img src="{{ asset('images/pim/mini-pim-logo.png') }}" alt="PIM Logo" class="email__logo">
    </div>

    <div class="email__container">
        <h1 class="email__greeting">Hello!</h1>
        <p class="email__body-text">
            You are receiving this email because we received a password reset request for your account.
        </p>

        <div class="email__button-container">
            <a href="{{ $actionUrl }}" class="email__button">
                Reset Password
            </a>
        </div>

        <p class="email__body-text">
            This password reset link will expire in 60 minutes. <br>
            If you did not request a password reset, no further action is required.
        </p>

        <p class="email__body-text">Regards,<br>Mini-PIM's Team</p>

        <div class="email__separator"></div>

        <div class="email__subcopy">
            <p>
                If you're having trouble clicking the <strong>"Reset Password"</strong> button, copy and paste the URL below
                into your web browser:
            </p>
            <a href="{{ $actionUrl }}" class="email__subcopy-link">
                {{ $displayableActionUrl }}
            </a>
        </div>
    </div>

    {{-- Include the footer component--}}
    {{-- @include('components.footer')--}}
</div>
</body>
</html>
