<footer>
    <h2><strong>Gabriel Hernández Collado © <?php echo date("Y"); ?></strong></h2>
</footer>
<?php
if (!isset($_SESSION['started'])) {
    echo "<script src='scripts/dialogs.js'></script>";
}
?>
<script src="scripts/dialogsSobres.js"></script>
<script type="module" src="scripts/battle.js"></script>
<script src="scripts/progressCircle.js"></script>
<script src="scripts/progressGenerations.js"></script>
<script src="scripts/tabs.js"></script>
<script src="scripts/pokedex.js"></script>
<script src="scripts/header.js"></script>
<script src="scripts/admin.js"></script>
<script src="scripts/perfil.js"></script>
</body>

</html>