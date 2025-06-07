<?php
// Verificar si la información de usuario está en la sesión
if (!isset($_SESSION['user_info'])) {
    echo '<p class="error">No se encontró información del usuario</p>';
    return;
}
?>

<div class="perfil-contenedor">
    <div class="info">
        <h2 class="titulo-perfil" contenteditable="true" id="editable-nombre"><?= htmlspecialchars($_SESSION['user_info']['nombre'] ?? '') ?></h2>

        <div class="perfil-imagen">
            <label for="foto-input">
                <img class="img-perfil" src="<?= htmlspecialchars($_SESSION['user_info']['ruta_foto_perfil'] ?? 'img/profile/profile_placeholder.png') ?>" id="preview-foto">
            </label>
            <input type="file" id="foto-input" accept="image/jpeg, image/png, image/gif, image/webp" hidden>
        </div>

        <p><strong>Email:</strong> <span contenteditable="true" id="editable-email"><?= htmlspecialchars($_SESSION['user_info']['email'] ?? '') ?></span></p>
        <p><strong>Miembro desde:</strong> <?= htmlspecialchars($_SESSION['user_info']['creado'] ?? '') ?></p>

        <?php if (isset($_SESSION['user_info']['combates'])): ?>
            <p><strong>Combates:</strong> <?= htmlspecialchars($_SESSION['user_info']['combates']) ?></p>
            <p><strong>Victorias:</strong> <?= htmlspecialchars($_SESSION['user_info']['combates_ganados'] ?? 0) ?></p>
            <p><strong>Ratio de victorias:</strong>
                <?php
                $victorias = $_SESSION['user_info']['combates_ganados'] ?? 0;
                $combates = $_SESSION['user_info']['combates'] ?? 0;
                echo $combates > 0 ? round($victorias / $combates, 2) : 0;
                ?>
            </p>
        <?php endif; ?>

        <button id="btn-guardar" class="btn-guardar" style="display:none;">Guardar Cambios</button>
    </div>
</div>

