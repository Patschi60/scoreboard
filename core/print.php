<?php include("scoreboard.php"); ?>

<script>
function druckenUndWeiterleiten() {
  window.print();

  setTimeout(function() {
    window.location.href = 'logedin.php';
  }, 1000);
}
window.addEventListener('load', druckenUndWeiterleiten);
</script>