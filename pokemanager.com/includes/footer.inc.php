<footer>
    <p><strong>Gabriel Hernández Collado © <?php echo date("Y"); ?></strong></p>
</footer>
<?php
if (!isset($_SESSION['started'])) {
    echo "<script src='scripts/dialogs.js'></script>";
}
?>
<script src="scripts/dialogsSobres.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script> -->
<script type="module" src="scripts/battle.js"></script>
<script src="scripts/progressCircle.js"></script>
<script src="scripts/progressGenerations.js"></script>
<script src="scripts/tabs.js"></script>
<script src="scripts/pokedex.js"></script>
</body>

</html>