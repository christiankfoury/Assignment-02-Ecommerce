<html>

<head>
    <title>2-FA set up</title>
</head>

<body>
    <h1>Creating 2-factor authentication tokent</h1>
    <h3>Please scan</h3>
    <a href="/Profile/index">Home</a><br><br>
    <img src="/Profile/makeQRCode?data=<?= $data ?>" /><br>
    Please scan the QR-code on the screen with your favorite
    Authenticator software, such as Google Authenticator. The
    authenticator software will generate codes that are valid for 30
    seconds only. Enter such a code while and submit it while it is
    still valid to confirm that the 2-factor authentication can be
    applied to your account.
</body>

</html>