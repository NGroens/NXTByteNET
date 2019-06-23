<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user_name.',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
			   	  Vielen Dank f&uuml;r die Registrierung bei NXTByte.net
                  Klicke auf den folgenden Link um deinen Account zu best&auml;tigen.
               </p>
               <br>
               <a href="'.$url.'activate.php?key='.$verify_code.'">'.$url.'activate.php?key='.$verify_code.'</a>
            </div>
            <a href="'.$url.'activate.php?key='.$verify_code.'" style="padding: 8px 20px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Account aktivieren</a>
            <!--
            <h4 style="margin-bottom: 10px;">
                Hast du eine Frage oder ben&ouml;tigst du Hilfe?
            </h4>
            <div style="color: #A5A5A5; font-size: 12px;">
               <p>
                  Erstelle eine <a href="https://nxtbyte.net/support" style="text-decoration: underline; color: #4B72FA;">Supportanfrage</a> oder schreiben uns eine Mail <a href="mailto:support@nxtbyte.net" style="text-decoration: underline; color: #4B72FA;">support@nxtbyte.net</a>
               </p>
            </div>
            -->
         </div>';
$mailSubject = 'Benutzerkonto Bestaetigung - NXTByte.net';
$emailAltBody = 'Klicke auf diesen Link um den Account zu bestätigen '.$url.'activate.php?key='.$verify_code;
