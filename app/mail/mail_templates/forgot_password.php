<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $userInfo['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Du hast anscheinend dein Passwort vergessen? Kein Problem klicke einfach auf den folgenden Link um dein Passwort zur&uuml;cksetzen.
               </p>
               <p>
                  Solltest du kein Passwort-Reset angefordert haben ignoriere diese Mail einfach der Link wird nach 12 Stunden ung&uuml;ltig.
               </p>
               
               <a href="'.$url.'passwort_reset/'.$verify_code.'">'.$url.'passwort_reset/'.$verify_code.'</a>
               
            </div>
            <a href="'.$url.'passwort_reset/'.$verify_code.'" style="padding: 8px 20px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Passwort zur&uuml;cksetzen</a>
          
         </div>';
$mailSubject = 'Passwort vergessen - NXTByte.net';
$emailAltBody = 'Klicke auf diesen Link um dein Passwort zu ändern '.$url.'passwort_reset/'.$verify_code;