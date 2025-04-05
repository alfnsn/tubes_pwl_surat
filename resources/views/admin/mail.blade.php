<!DOCTYPE html>
<html>
<head>
    <title>Account Information</title>
</head>
<body>
    <h1>Welcome to Maranatha</h1>
    <p>Dear {{ $name }},</p>
    <p>Your account has been created successfully. Below are your login credentials:</p>
    <p><strong>ID:</strong> {{ $id }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please make sure to change your password after logging in for the first time.</p>
    <p>Thank you!</p>
</body>
</html>
