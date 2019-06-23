<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $userInfo['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Vielen Dank f&uuml;r dein vertrauen! soeben wurden '.$paymentInfos['amount'].'&euro; auf dein Kundenkonto aufgeladen.
               </p>
            </div>
         </div>';
$mailSubject = 'Neue Guthabenaufladung - NXTByte.net';
$emailAltBody = '';
