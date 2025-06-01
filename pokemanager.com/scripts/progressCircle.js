document.addEventListener('DOMContentLoaded', () => {
    const circumference = 2 * Math.PI * 45;
    const percentageElement = document.querySelector('.percentage');
    const targetPercentage = parseFloat(percentageElement.dataset.percentage);
    const progressCircle = document.querySelector('.progress');

    progressCircle.style.strokeDasharray = circumference;
    progressCircle.style.strokeDashoffset = circumference;

    function animateProgress() {
        const duration = 2000;
        const startTime = performance.now();
        const startOffset = circumference;
        const endOffset = circumference * (1 - targetPercentage / 100);

        function updateProgress(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            const easedProgress = progress < 0.5
                ? 2 * progress * progress
                : -1 + (4 - 2 * progress) * progress;

            const currentOffset = startOffset - (startOffset - endOffset) * easedProgress;
            progressCircle.style.strokeDashoffset = currentOffset;

            const displayPercentage = Math.round(targetPercentage * easedProgress);
            percentageElement.textContent = `${displayPercentage}%`;

            const hue = Math.round(120 * easedProgress); // De rojo (0) a verde (120)
            progressCircle.style.stroke = `hsl(${hue}, 70%, 50%)`;

            if (progress < 1) {
                requestAnimationFrame(updateProgress);
            }
        }

        requestAnimationFrame(updateProgress);
    }

    setTimeout(animateProgress, 500);
});