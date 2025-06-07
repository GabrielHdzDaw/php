const pokemonCards = document.querySelectorAll('.pokemon-card');

document.addEventListener('DOMContentLoaded', function () {
    const botonSubir = document.querySelector('.a-volver-arriba');
    const distanciaParaMostrar = 300;

    window.addEventListener('scroll', function () {
        if (window.pageYOffset > distanciaParaMostrar) {
            botonSubir.style.display = 'block';
        } else {
            botonSubir.style.display = 'none';
        }
    });

    botonSubir.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    initGenerationFilter();
});

function initGenerationFilter() {
    const generacionItems = document.querySelectorAll('.generacion-item');
    const pokemonCards = document.querySelectorAll('.pokemon-card');
    let currentFilter = 'all';

    generacionItems.forEach(item => {
        item.addEventListener('click', () => {
            const selectedGen = item.dataset.gen;

            // Toggle: si ya está seleccionada la misma generación, mostrar todos
            if (currentFilter === selectedGen) {
                showAllPokemon();
                removeActiveClass();
                currentFilter = 'all';
            } else {
                filterByGeneration(selectedGen);
                setActiveGeneration(item);
                currentFilter = selectedGen;
            }
        });
    });

    function filterByGeneration(generation) {
        pokemonCards.forEach(card => {
            const pokemonGen = card.dataset.generation;
            if (pokemonGen === generation) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function showAllPokemon() {
        pokemonCards.forEach(card => {
            card.style.display = 'block';
        });
    }

    function setActiveGeneration(activeItem) {
        generacionItems.forEach(item => {
            item.classList.remove('generation-active');
        });
        activeItem.classList.add('generation-active');
    }

    function removeActiveClass() {
        generacionItems.forEach(item => {
            item.classList.remove('generation-active');
        });
    }
}

pokemonCards.forEach(card => {
    card.addEventListener('click', () => {
        const pokemonId = card.dataset.id;
        const pokemonName = card.dataset.name;
        const pokemonType1 = card.dataset.type1;
        const pokemonType2 = card.dataset.type2;
        const pokemonTotal = card.dataset.total;
        const pokemonHP = card.dataset.hp;
        const pokemonAttack = card.dataset.attack;
        const pokemonDefense = card.dataset.defense;
        const pokemonSpecialAttack = card.dataset.specialattack;
        const pokemonSpecialDefense = card.dataset.specialdefense;
        const pokemonSpeed = card.dataset.speed;
        const pokemonGeneration = card.dataset.generation;
        const pokemonLegendary = card.dataset.legendary;
        const pokemonImage = card.dataset.icon;
        const pokemonDescription = card.dataset.description;

        const modalContent = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="stats-info-container">
            <div class="pokemon-header">
            <h2>#${pokemonId} ${pokemonName}</h2> <span>Gen ${pokemonGeneration} ${pokemonLegendary == 1 ? "Legendario" : ""}</span>
            <img class="img-pokemon-pokedex-dialog" src="${pokemonImage}" alt="${pokemonName}">
            <img class="img-pokemon-type" src="img/types/${pokemonType1}.png" alt="${pokemonType1}">
            <img class="img-pokemon-type" src="img/types/${pokemonType2}.png" alt="${pokemonType2}">
            </div>
            <div class="pokemon-stats">
               <table>
               <tr>
               <td>HP:</td>
                        <td class="stats-numbers">${pokemonHP}</td>
                    </tr>
                    <tr>
                        <td>Attack:</td>
                        <td class="stats-numbers">${pokemonAttack}</td>
                    </tr>
                    <tr>
                        <td>Defense:</td>
                        <td class="stats-numbers">${pokemonDefense}</td>
                    </tr>
                    <tr>
                        <td>Special Attack:</td>
                        <td class="stats-numbers">${pokemonSpecialAttack}</td>
                    </tr>
                    <tr>
                        <td>Special Defense:</td>
                        <td class="stats-numbers">${pokemonSpecialDefense}</td>
                    </tr>
                    <tr>
                    <td>Speed:</td>
                    <td class="stats-numbers">${pokemonSpeed}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td class="stats-numbers">${pokemonTotal}</td>
                    </tr>
                    </table>
                    </div>
            </div>
            <div class="pokemon-description">
            <p>${pokemonDescription}</p>
            </div>
        </div>
        `;

        const modal = document.createElement('dialog');
        modal.classList.add('modal');
        modal.classList.add('blur-inverso');
        document.body.classList.add("blur");
        modal.innerHTML = modalContent;
        document.body.appendChild(modal);
        modal.showModal();

        const closeButton = modal.querySelector('.close');
        closeButton.addEventListener('click', () => {
            document.body.classList.remove("blur");
            modal.classList.remove('blur-inverso');
            modal.close();
        });
        modal.addEventListener('cancel', () => {
            document.body.classList.remove("blur");
            modal.classList.remove('blur-inverso');
            modal.close();
        });
    });
});