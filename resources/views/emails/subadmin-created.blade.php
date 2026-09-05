<!DOCTYPE html>
<html>
<head>
    <title>Your Admin Account</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #2c3e50; text-align: center; border-bottom: 2px solid #52ead2; padding-bottom: 10px;">Welcome to Rydaris Admin</h2>
        
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        
        <p>An administrative account has been created for you. You can use the following credentials to access the admin panel:</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #52ead2; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Login URL:</strong> <a href="{{ url('/admin/login') }}" style="color: #3498db;">{{ url('/admin/login') }}</a></p>
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin: 5px 0;"><strong>Password:</strong> {{ $password }}</p>
        </div>
        
        <p><em>For security reasons, we strongly recommend changing your password after your first login.</em></p>
        
        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
        
        <p style="font-size: 0.85rem; color: #7f8c8d; text-align: center;">
            Regards,<br>
            Rydaris Team
        </p>
    </div>
</body>
</html>
