<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🎉 Welcome to Task Manager!</h1>
    </div>

    <div class="content">
        <h2>Hello {{ $user->name }}! 👋</h2>

        <p>Thank you for joining our Task Manager application!</p>

        <p>We're excited to have you on board. With our app, you can:</p>

        <ul>
            <li>✅ Create and manage tasks efficiently</li>
            <li>🏷️ Organize with categories and tags</li>
            <li>⭐ Mark important tasks as favorites</li>
            <li>🎯 Set priorities for your tasks</li>
        </ul>

        <p>Your account details:</p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Registered:</strong> {{ $user->created_at->format('F d, Y') }}</li>
        </ul>

        <a href="{{ config('app.url') }}" class="button">Get Started 🚀</a>

        <p style="margin-top: 30px;">If you have any questions, feel free to reach out!</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>