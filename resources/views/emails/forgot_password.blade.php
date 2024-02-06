<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}} | Reset Password</title>
</head>
<body>
    <!-- <h1>Hello,{{ $details['name'] }}</h1>
    <p>You are receiving this email because we received a password reset request for your account</p>
 
    <p style="color:blue;" ><a href="{{ route('reset.password.get', $details['token']) }}">Reset Password</a></p>
    <p>Thank you</p> -->
    <table style="font-family: &quot;proxima nova&quot;, &quot;century gothic&quot;, &quot;arial&quot;, &quot;verdana&quot;, sans-serif; font-size: 14px; color: rgba(94, 94, 94, 1); width: 98%; max-width: 600px; float: none; margin: 0 auto" border="0" cellpadding="0" cellspacing="0" valign="top" align="left">
    <tbody>
      <tr align="middle">
        <td style="padding-top: 30px; padding-bottom: 32px"><img height="37"></td>
      </tr>
      <tr bgcolor="#ffffff">
        <td>
          <table bgcolor="#ffffff" style="width: 100%; line-height: 20px; padding: 32px; border: 1px solid rgba(240, 240, 240, 1)" cellpadding="0">
            <tbody>
              <tr>
                <td style="color: rgba(94, 94, 94, 1); font-size: 22px; line-height: 22px">DryHunts -  Password Reset Requested</td>
              </tr>
              <tr>
                <td style="padding-top: 24px; vertical-align: bottom">Hi {{ $details['name'] }},</td>
              </tr>
              <tr>
                <td style="padding-top: 24px">You are receiving this email because we received a password reset request for your account. If you did not make this request, please contact your system administrator immediately.</td>
              </tr>
              <tr>
                <td style="padding-top: 24px">Click this link to reset the password for your email, {{ $details['email'] }}:</td>
              </tr>
              <tr>
                <td align="center">
                  <table border="0" cellpadding="0" cellspacing="0" valign="top">
                    <tbody>
                      <tr>
                        <td align="center" style="height: 32px; padding-top: 24px; padding-bottom: 16px"><a href="{{ route('reset.password.get', $details['token']) }}" style="text-decoration: none"><span style="padding: 9px 32px 7px 31px; border: 1px solid rgba(22, 98, 221, 1); text-align: center; cursor: pointer; color: rgba(255, 255, 255, 1); border-radius: 3px; background-color: rgba(22, 98, 221, 1); box-shadow: 0 1px rgba(22, 98, 221, 1)">Reset Password</span></a></td>
                      </tr>
                      <tr>
                        <td align="center" style="color: rgba(153, 153, 153, 1)">This link expires in 1 hour.</td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr>
                <td style="padding-top: 24px">If you experience difficulties accessing your account, send a help request to your administrator:</td>
              </tr>
              <tr>
            </tr></tbody>
          </table></td>
      </tr>
      <tr>
        <td style="font-size: 12px; padding: 16px 0 30px 50px; color: rgba(153, 153, 153, 1)">This is an automatically generated message from <a href="#" style="color: rgba(97, 97, 97, 1)">DryHunts</a>. Replies are not monitored or answered.</td>
      </tr>
    </tbody>
  </table>
</body>
</html>