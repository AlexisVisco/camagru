<?php

if (FlashMessage::hasFlash()) {
    $msg = FlashMessage::consume();
    $type = "is-success";
    if ($msg->type == FlashType::$ERROR) {
        $type = "is-danger";
    } else if ($msg->type == FlashType::$WARNING) {
        $type = "is-warning";
    }
    ?>
    <div style="text-align: left" class="notification <?php echo $type ?>">
        <?php echo $msg->message ?>
    </div>
    <?php
}
?>