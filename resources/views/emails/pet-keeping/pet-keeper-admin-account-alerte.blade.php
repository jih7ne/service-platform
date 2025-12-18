<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Keeper Account Alert</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background-color:#e53e3e; padding:20px; text-align:center; color:#ffffff;">
                        <h1 style="margin:0; font-size:24px;">New Pet Keeper Account Created</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333;">
                        <p style="font-size:16px; margin-top:0;">
                            Hello Admin,
                        </p>

                        <p style="font-size:15px; line-height:1.6;">
                            A new <strong>Pet Keeper</strong> account has just been registered on the platform. Here are the details:
                        </p>

                        <h3 style="font-size:16px; margin-bottom:10px;">Pet Keeper Information:</h3>
                        <ul style="font-size:15px; line-height:1.6; padding-left:20px;">
                            <li><strong>Full Name:</strong> {{ $firstName }} {{ $lastName }}</li>
                            <li><strong>Email:</strong> {{ $email }}</li>
                            <li><strong>Telephone:</strong> {{ $pet_keeper_data['telephone'] ?? 'N/A' }}</li>
                            <li><strong>Pet Keeper ID:</strong> {{ $pet_keeper_data['idPetKeeper'] ?? 'N/A' }}</li>
                            <li><strong>Speciality:</strong> {{ $pet_keeper_data['specialite'] ?? 'N/A' }}</li>
                            <li><strong>Years of Experience:</strong> {{ $pet_keeper_data['years_of_experience'] ?? 'N/A' }}</li>
                            <li><strong>Number of Services:</strong> {{ $pet_keeper_data['number_of_services'] ?? '0' }}</li>
                        </ul>

                        <p style="font-size:15px; line-height:1.6;">
                            Please review this account and take any necessary action.
                        </p>

                        <p style="font-size:15px; margin-bottom:0;">
                            Regards,<br>
                            <strong>PetKeeping System</strong>
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
