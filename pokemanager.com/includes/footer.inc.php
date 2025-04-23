<footer>
    <p><strong>Gabriel Hernández Collado © <?php echo date("Y"); ?></strong></p>
</footer>
<?php
if (!isset($_SESSION['started'])) {
    echo "<script src='scripts/dialogs.js'></script>";
}
?>
<script src="scripts/tabs.js"></script>
<script src="scripts/combat.js"></script>
<script src="scripts/pokedex.js"></script>
</body>

</html>