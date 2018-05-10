<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="modal-card message success" onclick="this.classList.add('hidden')"><?= $message ?></div>
