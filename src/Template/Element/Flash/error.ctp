<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="modal-card message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
