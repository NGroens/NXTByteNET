<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $userInfo['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Vielen Dank f&uuml;r deine Bestellung.
                  Dein bestellter MusikBot ist nun online und kann von dir unter <a href="https://www.nxtbyte.net/service/list">www.nxtbyte.net</a> verwaltet werden.
               </p>
            </div>
         </div>';
$mailSubject = 'MusikBot bestellung - NXTByte.net';
$emailAltBody = '';