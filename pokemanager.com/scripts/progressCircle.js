document.addEventListener('DOMContentLoaded', () => {
    const circumference = 2 * Math.PI * 45;
    const percentageElement = document.querySelector('.percentage');
    const targetPercentage = parseFloat(percentageElement.dataset.percentage);
    const progressCircle = document.querySelector('.progress');

    // Setup inicial
    progressCircle.style.strokeDasharray = circumference;
    progressCircle.style.strokeDashoffset = circumference;

    // Función de animación con JavaScript puro
    function animateProgress() {
        const duration = 2000; // 2 segundos
        const startTime = performance.now();
        const startOffset = circumference;
        const endOffset = circumference * (1 - targetPercentage / 100);

        function updateProgress(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function (ease-in-out)
            const easedProgress = progress < 0.5
                ? 2 * progress * progress
                : -1 + (4 - 2 * progress) * progress;

            // Actualizar el offset del círculo
            const currentOffset = startOffset - (startOffset - endOffset) * easedProgress;
            progressCircle.style.strokeDashoffset = currentOffset;

            // Actualizar el porcentaje mostrado
            const displayPercentage = Math.round(targetPercentage * easedProgress);
            percentageElement.textContent = `${displayPercentage}%`;

            // Cambiar color gradualmente
            const hue = Math.round(120 * easedProgress); // De rojo (0) a verde (120)
            progressCircle.style.stroke = `hsl(${hue}, 70%, 50%)`;

            if (progress < 1) {
                requestAnimationFrame(updateProgress);
            }
        }

        requestAnimationFrame(updateProgress);
    }

    // Iniciar animación después de un pequeño delay
    setTimeout(animateProgress, 500);
});