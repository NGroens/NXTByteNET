<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $ownerInfo['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Dein MusikBot wurde soeben Suspendiert du hast nun 3 Tage Zeit diesen zu verl&auml;gern ansonsten wird dieser gel&ouml;scht.
               </p>
            </div>
         </div>';
$mailSubject = 'MusikBot abgelaufen - NXTByte.net';
$emailAltBody = '';