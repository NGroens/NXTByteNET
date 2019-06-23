<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $ticketInfos['user_id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Dein erstelltes Ticket wurde soeben von '.$user->getName($odb, $userInfo['id']).' beantwortet.
               </p>
            </div>
         </div>';
$mailSubject = 'Neue Antwort auf dein Ticket - NXTByte.net';
$emailAltBody = '';