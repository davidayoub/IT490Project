<?php
function getMessages($session)
{
    if (isset($session['flash'])) {
        $flashes = $session['flash'];
        unset($session['flash']); 
        return $flashes;
    }
    return array();
}

function flash($msg = "", $color = "info")
{
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}



?>
<div class="container" id="flash">
    
<?php $messages = getMessages($_SESSION);?>
<?php if (!empty($messages)): ?> <!-- Checking if the array is not empty is more readable -->
    <?php foreach ($messages as $msg): ?>
    <div class="row justify-content-center">
        <div class="alert alert-<?php echo htmlspecialchars(isset($msg['color']) ? $msg['color'] : 'info'); ?>" role="alert">
            <?php echo htmlspecialchars(isset($msg['text']) ? $msg['text'] : ''); ?>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<script>
function moveMeUp(ele) {
    let target = document.getElementsByTagName("nav")[0];
    if (target) {
        target.after(ele);
    }
}
moveMeUp(document.getElementById("flash"));
</script>


