document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.dynamic-header');

    const originalImgWidth = 2058;
    const originalImgHeight = 956;

    const imgWidth = originalImgWidth;
    const imgHeight = originalImgHeight;

    function getMaxOffsets() {
        const headerWidth = header.offsetWidth;
        const headerHeight = header.offsetHeight;
        return {
            x: imgWidth - headerWidth,
            y: imgHeight - headerHeight
        };
    }

    let forward = true;

    function updatePosition() {
        const { x: maxX, y: maxY } = getMaxOffsets();
        const posX = forward ? -maxX : 0;
        const posY = forward ? -maxY : 0;
        header.style.backgroundPosition = `${posX}px ${posY}px`;
        forward = !forward;
    }

    updatePosition();
    setInterval(updatePosition, 60000);
});
