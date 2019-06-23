<?php

if(empty($url)){
    $logoUrl = 'https://www.nxtbyte.net';
    $picUrl = 'https://www.nxtbyte.net/assets/images/';
    $url = "https://www.nxtbyte.net/";
    $cdnUrl = "https://www.nxtbyte.net/assets/style/";
    $siteDomain = "NXTByte.net";
    $name = "NXTByte";
}

$emailBody = '
<!DOCTYPE html>
<html>
   <body style="background-color: #222533; padding: 20px; font-family: font-size: 14px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;">
      <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
         <table style="width: 100%;">
            <tr>
               <td style="background-color: #fff;">
                  <img alt="" src="'.$picUrl.'logo/logo.png" style="width: 70px; padding: 20px">
               </td>
               <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                  <a href="'.$url.'login" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;">Zum Login</a><a href="'.$url.'forgot_password" style="color: #7C2121; text-decoration: underline; font-size: 14px; margin-left: 20px; letter-spacing: 1px;">Passwort vergessen?</a>
               </td>
            </tr>
         </table>
'.$mailContent.'
      </div>
   </body>
</html>
';