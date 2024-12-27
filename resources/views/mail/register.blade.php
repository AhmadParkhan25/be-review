<!doctype html>
<html>

<head>
    <meta http-equiv=3D"Content-Type" content=3D"text/html; charset=3DUTF-8">
</head>

<body style=3D"font-family: sans-serif;">
    <div style=3D"display: block; margin: auto; max-width: 600px;" class=3D"main">
        <h1 style=3D"font-size: 18px; font-weight: bold; margin-top: 20px">Selamat bapak/ibu {{ $name }} email
            Berhasil Register</h1>
        <p>Silahkan gunakan OTP code dibawah batas kadaluarsanya 5 menit dari sekarang.</p>
        <h3 style="background-color: yellow; text-align: center; font-size: 50px">{{ $otp }}</h3>


    </div>
    <!-- Example of invalid for email html/css, will be detected by Mailtrap: -->
    <style>
        .main {
            background-color: white;
        }

        a:hover {
            border-left-width: 1em;
            min-height: 2em;
        }
    </style>
</body>

</html>
