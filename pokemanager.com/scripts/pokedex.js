const pokemonCards = document.querySelectorAll('.pokemon-card');

pokemonCards.forEach(card => {
    card.addEventListener('click', () => {
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
            <h2>${pokemonName}</h2>
            <img class="img-pokemon-pokedex-dialog" src="${pokemonImage}" alt="${pokemonName}">
            <p>Type 1: ${pokemonType1}</p>
            <p>Type 2: ${pokemonType2}</p>
            </div>
            <div class="pokemon-stats">
                <p>Total: ${pokemonTotal}</p>
                <p>HP: ${pokemonHP}</p>
                <p>Attack: ${pokemonAttack}</p>
                <p>Defense: ${pokemonDefense}</p>
                <p>Special Attack: ${pokemonSpecialAttack}</p>
                <p>Special Defense: ${pokemonSpecialDefense}</p>
                <p>Speed: ${pokemonSpeed}</p>
            </div>
            </div>
            <div class="pokemon-description">
            <p>${pokemonDescription}</p>
            </div>
            <p>Generation: ${pokemonGeneration}</p>
            <p>Legendary: ${pokemonLegendary}</p>

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