<?php
$mailContent = '<div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px;">
               Hallo '.$user->getName($odb, $_SESSION['id']).',
            </h1>
            <div style="color: #636363; font-size: 14px;">
               <p>
                  Klicke auf den folgenden Button um die Spende an <b>'.$_POST['username'].'</b> zu best&auml;tigen.
               </p>
               <a href="'.$url.'confirm_money.php?key='.$verify_code.'" style="padding: 8px 20px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none;">Guthaben senden</a>
               
               <p>
               <a href="'.$url.'confirm_money.php?key='.$verify_code.'">'.$url.'confirm_money.php?key='.$verify_code.'</a>
               </p>
               
               <p>
                  Bitte beachte das nach der Best&auml;tigung keine R&uuml;ckerstattung mehr m&ouml;glich ist!
               </p>
               
            </div>
          
         </div>';
$mailSubject = 'Spende bestaetigen - NXTByte.net';
$emailAltBody = 'Klicke auf diesen Link um deine Spende zu bestaetigen '.$url.'confirm_money.php?key='.$verify_code;