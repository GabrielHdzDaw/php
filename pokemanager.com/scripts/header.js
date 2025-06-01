document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.dynamic-header');

    // Tamaño original de tu imagen
    const originalImgWidth = 2058;
    const originalImgHeight = 956;

    // Factor de zoom (ajusta según tu background-size)
    const zoomFactor = 2; // Para background-size: 150%
    // Si usas 200%, pon 2.0
    // Si usas cover, calculamos dinámicamente más abajo

    const imgWidth = originalImgWidth * zoomFactor;
    const imgHeight = originalImgHeight * zoomFactor;
    const minDistance = 700; // Distancia mínima entre zonas

    let lastPosition = { x: 0, y: 0 };
    let movementType = 'random'; // 'horizontal', 'vertical', 'diagonal', 'random'

    function getRandomPosition() {
        const headerWidth = header.offsetWidth;
        const headerHeight = header.offsetHeight;

        // Calculamos el rango máximo de movimiento
        const maxX = Math.max(0, imgWidth - headerWidth);
        const maxY = Math.max(0, imgHeight - headerHeight);

        // Si la imagen es más pequeña que el contenedor, centramos
        if (maxX <= 0 || maxY <= 0) {
            return {
                x: maxX <= 0 ? Math.floor(-maxX / 2) : 0,
                y: maxY <= 0 ? Math.floor(-maxY / 2) : 0
            };
        }

        // Alternar tipo de movimiento para más variedad
        const movements = ['horizontal', 'vertical', 'diagonal', 'random'];
        movementType = movements[Math.floor(Math.random() * movements.length)];

        let newPosition;
        let attempts = 0;
        const maxAttempts = 50;

        do {
            switch (movementType) {
                case 'horizontal':
                    // Priorizar movimiento horizontal
                    newPosition = {
                        x: -Math.floor(Math.random() * maxX),
                        y: lastPosition.y + (Math.random() - 0.5) * Math.min(maxY * 0.3, 200) // Pequeña variación vertical
                    };
                    // Asegurar que Y esté en rango válido
                    newPosition.y = Math.max(-maxY, Math.min(0, newPosition.y));
                    break;

                case 'vertical':
                    // Priorizar movimiento vertical
                    newPosition = {
                        x: lastPosition.x + (Math.random() - 0.5) * Math.min(maxX * 0.3, 200), // Pequeña variación horizontal
                        y: -Math.floor(Math.random() * maxY)
                    };
                    // Asegurar que X esté en rango válido
                    newPosition.x = Math.max(-maxX, Math.min(0, newPosition.x));
                    break;

                case 'diagonal':
                    // Movimiento diagonal pronunciado
                    const direction = Math.random() > 0.5 ? 1 : -1;
                    const baseX = -Math.floor(Math.random() * maxX);
                    const baseY = -Math.floor(Math.random() * maxY);
                    newPosition = { x: baseX, y: baseY };
                    break;

                default: // 'random'
                    // Movimiento completamente aleatorio
                    newPosition = {
                        x: -Math.floor(Math.random() * maxX),
                        y: -Math.floor(Math.random() * maxY)
                    };
            }

            // Calcular distancia con la posición anterior
            const distance = Math.sqrt(
                Math.pow(Math.abs(newPosition.x - lastPosition.x), 2) +
                Math.pow(Math.abs(newPosition.y - lastPosition.y), 2)
            );

            attempts++;

            // Si la distancia es suficiente o hemos intentado muchas veces, usar esta posición
            if (distance >= minDistance || attempts >= maxAttempts) {
                console.log(`Movimiento: ${movementType}, Distancia: ${Math.round(distance)}px, Posición: ${newPosition.x}px ${newPosition.y}px`);
                break;
            }

        } while (attempts < maxAttempts);

        return newPosition;
    }

    function changeBackgroundPosition() {
        const pos = getRandomPosition();
        header.style.backgroundPosition = `${pos.x}px ${pos.y}px`;
        lastPosition = pos; // Guardar la posición actual
    }

    // Establecer posición inicial aleatoria
    changeBackgroundPosition();

    // Cambiar posición cada 8 segundos
    setInterval(changeBackgroundPosition, 12000);
});