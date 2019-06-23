<?php

//function sendError($message, $title = 'Fehler'){
//    $sendMessage = '<div class="alert dark alert-danger alert-dismissible" role="alert">
//        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
//        <b>'.$title.'</b> '.$message.'
//        </div>';
//    return $sendMessage;
//}
//
//function sendInfo($message, $title = 'Info'){
//    $sendMessage = '<div class="alert dark alert-info alert-dismissible" role="alert">
//        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
//        <b>'.$title.'</b> '.$message.'
//        </div>';
//    return $sendMessage;
//}
//
//function sendSuccess($message, $title = 'Erfolgreich'){
//    $sendMessage = '<div class="alert dark alert-success alert-dismissible" role="alert">
//        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
//        <b>'.$title.'</b> '.$message.'
//        </div>';
//    return $sendMessage;
//}


function sendError($message, $title = 'Fehler'){
    $sendMessage = '<script>
            toastr.error("'.$message.'", "'.$title.'", {
                "progressBar": true,
                "positionClass": "toast-top-center",
            });
        </script>';
    return $sendMessage;
}

function sendInfo($message, $title = 'Info'){
    $sendMessage = '<script>
            toastr.info("'.$message.'", "'.$title.'", {
                "progressBar": true,
                "positionClass": "toast-top-center",
            });
        </script>';
    return $sendMessage;
}

function sendSuccess($message, $title = 'Erfolgreich'){
    $sendMessage = '<script>
            toastr.success("'.$message.'", "'.$title.'", {
                "progressBar": true,
                "positionClass": "toast-top-center",
            });
        </script>';
    return $sendMessage;
}