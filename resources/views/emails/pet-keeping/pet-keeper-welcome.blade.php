<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Pet Keeper</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background-color:#2f855a; padding:20px; text-align:center; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">Welcome to PetKeeping 🐾</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333;">
                        <p style="font-size:16px; margin-top:0;">
                            Hello <strong>{{ $firstName }} {{ $lastName }}</strong>,
                        </p>

                        <p style="font-size:15px; line-height:1.6;">
                            We’re excited to let you know that your <strong>Pet Keeper account</strong> has been successfully created.
                        </p>

                        <p style="font-size:15px; line-height:1.6;">
                            You can now access the platform, manage your services, and connect with pet owners looking for trusted care.
                        </p>

                        <p style="font-size:15px; line-height:1.6;">
                            If you have any questions or need assistance, our team is always here to help.
                        </p>

                        <p style="font-size:15px; margin-bottom:0;">
                            Welcome aboard,<br>
                            <strong>The PetKeeping Team</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#f0f0f0; padding:15px; text-align:center; font-size:12px; color:#666;">
                        © {{ date('Y') }} PetKeeping. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
