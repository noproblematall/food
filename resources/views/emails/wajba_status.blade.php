
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Experience Status</title>
</head>

<body style="background:#f1f1f1;padding-top:20px;padding-bottom:20px;">
    <center>
        <table class="" border="0" cellspacing="0" cellpadding="0" width="600"
            style="max-width:600px;background-color:#ffffff; border-collapse:collapse">
            <tbody>
                <tr>
                    <td height="50"></td>
                </tr>
                
                <tr>
                    <td style="padding-left:20px;" align="center">
                        <p style="margin:5px 0px 5px 0px;font-weight:600;font-size:36px;"><span style="color:#004000;">Experience Status</span></p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                @if ($status_id == 1)
                    <tr>
                        <td style="text-align:center; font-size: 24px;">Hello! {{$host_name}}, Congratulations! Your Experience "{{$wajba_title}}" are just approved.</td>
                    </tr>                    
                @endif
                @if ($status_id == 2)
                    <tr>
                        <td style="text-align:center; font-size: 24px;">Hello! {{$host_name}}, Unfortunately, Your Experience "{{$wajba_title}}" was pended.</td>
                    </tr>                    
                @endif
                @if ($status_id == 3)
                    <tr>
                        <td style="text-align:center; font-size: 24px;">Hello! {{$host_name}}, Unfortunately, Your Experience "{{$wajba_title}}" was rejected.</td>
                    </tr>                    
                @endif
                     
                <tr>
                    <td height="10"></td>
                </tr>
               
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:16px;color:#222;font-family: Montserrat;font-weight:500;">
                            For any further assistance contact our support team at &nbsp;&nbsp; <a
                                href="#" style="color:#0000ee;font-size:18px">info@hihome.sa</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color:#222;font-family: Montserrat;font-weight:600;">
                            Sincerely
                        </p>
                    </td>
                </tr>

                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color:#222;font-family: Montserrat;font-weight:600;">
                            Hihome Team
                        </p>
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color: #0738ca;font-family: Montserrat;font-weight:600;">
                            SA
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
            </tbody>
        </table>


    </center>
</body>

</html>