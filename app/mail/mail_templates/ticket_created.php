<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $userInfo['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Dein Ticket wurde erfolgreich erstellt.
				  Es wird sich so schnell wie m&ouml;glich ein Mitarbeiter um dein Anliegen k&uuml;mmern.
               </p>
            </div>
         </div>';
$mailSubject = 'Ticket erstellt - NXTByte.net';
$emailAltBody = '';