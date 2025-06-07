document.addEventListener('DOMContentLoaded', () => {
    const generaciones = document.querySelectorAll('.generacion-item');
    
    generaciones.forEach((generacion, index) => {
        const progressBar = generacion.querySelector('.progress-bar');
        const progressText = generacion.querySelector('.progress-text');
        const circularProgressBar = generacion.querySelector('.circular-progress-bar');
        const circularText = generacion.querySelector('.circular-text');
        const pokemonCapturados = generacion.querySelector('.pokemon-capturados');
        const pokemonTotal = parseInt(generacion.querySelector('.pokemon-total').textContent);
        
        if (!progressBar || !progressText) {
            console.log(`Elementos no encontrados para generación ${index + 1}`);
            return;
        }
        
        const targetPercentage = parseFloat(progressBar.dataset.percentage) || 0;
        const targetCaptured = parseInt(progressBar.dataset.capturados) || 0;
        
        if (circularProgressBar) {
            const circumference = 2 * Math.PI * 16;
            circularProgressBar.style.strokeDasharray = circumference;
            circularProgressBar.style.strokeDashoffset = circumference;
        }
        
        setTimeout(() => {
            animateGenerationProgress(
                progressBar, 
                progressText, 
                circularProgressBar, 
                circularText, 
                pokemonCapturados, 
                targetPercentage, 
                targetCaptured, 
                pokemonTotal
            );
        }, 800 + (index * 300));
    });
});

function animateGenerationProgress(progressBar, progressText, circularProgressBar, circularText, pokemonCapturados, targetPercentage, targetCaptured) {
    const duration = 2000;
    const startTime = performance.now();
    const circumference = circularProgressBar ? 2 * Math.PI * 16 : 0;

    function updateProgress(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const easedProgress = 1 - Math.pow(1 - progress, 3);

        const currentPercentage = targetPercentage * easedProgress;
        progressBar.style.width = `${currentPercentage}%`;
        progressText.textContent = `${Math.round(currentPercentage)}%`;

        if (circularProgressBar && circularText) {
            const currentOffset = circumference * (1 - easedProgress * (targetPercentage / 100));
            circularProgressBar.style.strokeDashoffset = currentOffset;
            circularText.textContent = `${Math.round(currentPercentage)}%`;
        }

        const currentCaptured = Math.round(targetCaptured * easedProgress);
        if (pokemonCapturados) {
            pokemonCapturados.textContent = currentCaptured;
        }

        const normalizedProgress = targetPercentage / 100;
        const hue = Math.round(120 * normalizedProgress * easedProgress); // De rojo (0) a verde (120)
        const saturation = 70;
        const lightness = 60;
        
        progressBar.style.background = `linear-gradient(90deg, 
            hsl(${hue}, ${saturation}%, ${lightness}%) 0%, 
            hsl(${hue + 20}, ${saturation}%, ${lightness + 5}%) 100%)`;
            
        if (circularProgressBar) {
            circularProgressBar.style.stroke = `hsl(${hue}, ${saturation}%, ${lightness}%)`;
        }

        if (progress < 1) {
            requestAnimationFrame(updateProgress);
        }
    }

    requestAnimationFrame(updateProgress);
}