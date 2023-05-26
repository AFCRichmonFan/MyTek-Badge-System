<?php
if(!isset($_SESSION)) {
    session_start();
}

// notify user helper
function notify($message) {
    if(!empty($_SESSION['notify'])){
        unset($_SESSION['notify']);
    }

    $_SESSION['notify'] = $data = [
                'notification' => $message
            ];
}
?>
