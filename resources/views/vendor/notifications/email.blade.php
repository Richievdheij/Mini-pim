<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* Base email styling */
        .email {
            background-color: #edf2f7;
            font-family: Arial, sans-serif;
            padding: 2rem 0;
            text-align: center;
        }

        .email__container {
            background-color: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 0.5rem;
            margin: 0 auto;
            max-width: 600px;
            padding: 2rem;
            text-align: left;
        }

        /* Header styles */
        .email__header {
            margin-bottom: 1.5rem;
        }

        .email__logo {
            display: block;
            margin: 0 auto 1rem;
            max-width: 100px;
        }

        /* Greeting styles */
        .email__greeting {
            color: #333;
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        /* Body text */
        .email__body-text {
            color: #555;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Button styles */
        .email__button-container {
            text-align: center;
            margin: 2.5rem 0;
        }

        .email__button {
            background-color: #567AC5;
            border: none;
            border-radius: 0.5rem;
            color: #ffffff;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            font-weight: bold;
            padding: 0.75rem 2rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .email__button:hover {
            background-color: #2859A6;
        }

        /* Footer styles */
        .email__footer {
            color: #888;
            font-size: 0.875rem;
            margin-top: 2rem;
            text-align: center;
        }

        .email__footer-link {
            color: #007bff;
            text-decoration: none;
        }

        .email__footer-link:hover {
            text-decoration: underline;
        }

        /* Separator line */
        .email__separator {
            border-top: 1px solid #eaeaea;
            margin: 1.5rem 0;
        }

        /* Subcopy styles */
        .email__subcopy {
            color: #666;
            font-size: 0.875rem;
            margin-top: 1.5rem;
            text-align: center;
            word-wrap: break-word;
        }

        .email__subcopy-link {
            color: #007bff;
            text-decoration: none;
            word-break: break-all;
        }
    </style>
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

        <p class="email__body-text">Regards,<br>{{ config('app.name') }}</p>

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

    <div class="email__footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
