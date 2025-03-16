<!doctype HTML>
<html>
<body style="color: #ededf1; font-size: 20px; background-color: #222226; text-align: center; font-family: Arial, sans-serif; padding: 40px 20px 40px 20px;">
    <h1 style="font-weight: bold; margin-bottom: 0;">
        Welcome to Lunoba
    </h1>
    <p style="margin-bottom: 60px; margin-top: 40px;">
        Please click the button below to verify your email
    </p>
    <a 
        style="color: #ededf1!important; text-decoration: none; background-color: #5DA93D; font-weight: bold; padding: 16px 18px 16px 18px;"
        href="{{ route('user.verify.email', ['id' => $token->id, 'token' => $token->token]) }}"
    >
        Verify Email
    </a>
</body>
</html>