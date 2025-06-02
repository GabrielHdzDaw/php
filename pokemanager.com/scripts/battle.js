import { Pokemon } from './pokemon.js';
import { getTypeMultiplier } from './typeMatrix.js';

class Battle {

    constructor(playerPokemons, opponentPokemons) {
        this.playerPokemons = [...playerPokemons];
        this.opponentPokemons = [...opponentPokemons];
        this.currentPlayerPokemon = this.playerPokemons[0];
        this.currentOpponentPokemon = this.opponentPokemons[0];
        this.turn = 0;
        this.log = [];
        this.battleInterval = null;
    }

    start() {
        this.log.push(`¡Comienza el combate entre ${this.currentPlayerPokemon.name} y ${this.currentOpponentPokemon.name}!`);
        this.updateUI();

        this.battleInterval = setInterval(() => {
            if (this.currentPlayerPokemon.isAlive() && this.currentOpponentPokemon.isAlive()) {
                this.takeTurn();
            } else {
                this.checkFaintedPokemon();
            }
        }, 3000); // Aumentado el intervalo para dar tiempo a los ataques secuenciales
    }

    checkFaintedPokemon() {
        if (!this.currentPlayerPokemon.isAlive()) {
            this.log.push(`¡${this.currentPlayerPokemon.name} se debilitó!`);
            const index = this.playerPokemons.indexOf(this.currentPlayerPokemon);
            this.playerPokemons.splice(index, 1);

            if (this.playerPokemons.length > 0) {
                this.currentPlayerPokemon = this.playerPokemons[0];
                this.log.push(`¡Ve! ¡${this.currentPlayerPokemon.name}!`);
            }
        }

        if (!this.currentOpponentPokemon.isAlive()) {
            this.log.push(`¡${this.currentOpponentPokemon.name} se debilitó!`);
            const index = this.opponentPokemons.indexOf(this.currentOpponentPokemon);
            this.opponentPokemons.splice(index, 1);

            if (this.opponentPokemons.length > 0) {
                this.currentOpponentPokemon = this.opponentPokemons[0];
                this.log.push(`¡El rival envió a ${this.currentOpponentPokemon.name}!`);
            }
        }

        this.updateUI();

        if (this.playerPokemons.length === 0 || this.opponentPokemons.length === 0) {
            this.endBattle();
        }
    }

    endBattle() {
        clearInterval(this.battleInterval);
        if (this.playerPokemons.length === 0) {
            this.log.push(`¡Todos tus Pokémon se debilitaron! ¡Has perdido!`);
        } else {
            this.log.push(`¡Has derrotado a todos los Pokémon del rival! ¡Ganaste!`);
        }
        this.updateUI();
    }

    takeTurn() {
        this.turn++;
        let attacker, defender;
        if (this.currentPlayerPokemon.speed >= this.currentOpponentPokemon.speed) {
            attacker = this.currentPlayerPokemon;
            defender = this.currentOpponentPokemon;
        } else {
            attacker = this.currentOpponentPokemon;
            defender = this.currentPlayerPokemon;
        }

        this.log.push(`Turno ${this.turn}: ¡${attacker.name} ataca primero!`);
        this.updateUI();

        // Primer ataque
        setTimeout(() => {
            this.performAttack(attacker, defender);
            this.updateUI();

            // Verificar si el defensor sigue vivo después del primer ataque
            if (defender.isAlive()) {
                // ✅ SEGUNDO ATAQUE: Anidado dentro del primer setTimeout
                setTimeout(() => {
                    this.performAttack(defender, attacker);
                    this.updateUI();
                }, 1500); // 1.5 segundos después del primer ataque
            }
        }, 500); // 0.5 segundos antes del primer ataque
    }

    performAttack(attacker, defender) {
        let damage;
        let attackType;
        let effectiveness = "";

        if (Math.random() < 0.5) {
            attackType = "ataque físico";
            damage = attacker.attack / (1 + (defender.defense / 100)) * 0.5;
        } else {
            attackType = "ataque especial";
            const typeMultiplier = getTypeMultiplier(attacker.type1.toUpperCase(), defender.type1.toUpperCase());
            damage = attacker.spAttack / (1 + (defender.spDefense / 100)) * 0.5 * typeMultiplier;

            if (typeMultiplier > 1) effectiveness = " ¡Es muy efectivo!";
            else if (typeMultiplier < 1 && typeMultiplier > 0) effectiveness = " ¡No es muy efectivo...";
            else if (typeMultiplier === 0) effectiveness = " ¡No afecta a este tipo de Pokémon!";
        }

        defender.receiveDamage(Math.round(damage));

        const logMessage = `${attacker.name} usa ${attackType}! ${defender.name} pierde ${Math.round(damage)} PS.${effectiveness}`;
        this.log.push(logMessage);
    }

    scrollToBottom(element) {
        element.scrollTop = element.scrollHeight;

        requestAnimationFrame(() => {
            element.scrollTop = element.scrollHeight;
            const lastItem = element.lastElementChild;
            if (lastItem) {
                lastItem.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }
        });
    }

    updateUI() {
        if (this.currentPlayerPokemon) {
            const playerName = document.getElementById('pokemon-usuario-nombre');
            const playerImg = document.getElementById('pokemon-usuario-img');
            const playerHP = document.querySelector('#pokemon-usuario .health-bar');

            if (playerName) playerName.textContent = this.currentPlayerPokemon.name;
            if (playerImg) playerImg.src = this.currentPlayerPokemon.getImage();
            if (playerHP) {
                const percentage = this.currentPlayerPokemon.hp / this.currentPlayerPokemon.maxHP;
                playerHP.style.width = `${percentage * 100}%`;
                playerHP.style.backgroundColor = this.getHealthBarColor(percentage);
            }
        }

        if (this.currentOpponentPokemon) {
            const opponentName = document.getElementById('pokemon-rival-nombre');
            const opponentImg = document.getElementById('pokemon-rival-img');
            const opponentHP = document.querySelector('#pokemon-rival .health-bar');

            if (opponentName) opponentName.textContent = this.currentOpponentPokemon.name;
            if (opponentImg) opponentImg.src = this.currentOpponentPokemon.getImage();
            if (opponentHP) {
                const percentage = this.currentOpponentPokemon.hp / this.currentOpponentPokemon.maxHP;
                opponentHP.style.width = `${percentage * 100}%`;
                opponentHP.style.backgroundColor = this.getHealthBarColor(percentage);
            }
        }

        const playerRemaining = document.querySelector('#pokemon-usuario .pokemon-usuario-restantes');
        const opponentRemaining = document.querySelector('#pokemon-rival .pokemon-usuario-restantes');

        if (playerRemaining) playerRemaining.textContent = `Pokémon restantes: ${this.playerPokemons.length}`;
        if (opponentRemaining) opponentRemaining.textContent = `Pokémon restantes: ${this.opponentPokemons.length}`;

        const logList = document.getElementById('log-list');
        if (logList) {
            logList.innerHTML = this.log.map(entry => `<li>${entry}</li>`).join('');
            this.scrollToBottom(logList);
            console.log('Altura del log:', logList.scrollHeight, 'Posición scroll:', logList.scrollTop);
            console.log('Altura visible:', logList.clientHeight);
        }
    }

    getHealthBarColor(percentage) {
        if (percentage > 0.6) return '#4CAF50'; // Verde
        if (percentage > 0.2) return '#FFC107'; // Amarillo
        return '#F44336'; // Rojo
    }
}

function getPokemons(list) {
    const pokemonList = [];

    list.forEach((pokemonCard, index) => {
        const pokemonName = pokemonCard.dataset.name;
        const pokemonType1 = pokemonCard.dataset.type1 || 'Normal';
        const pokemonType2 = pokemonCard.dataset.type2 || null;
        const pokemonHP = parseInt(pokemonCard.dataset.hp) || 100;
        const pokemonAttack = parseInt(pokemonCard.dataset.attack) || 50;
        const pokemonDefense = parseInt(pokemonCard.dataset.defense) || 50;
        const pokemonSpAttack = parseInt(pokemonCard.dataset.specialattack) || 50;
        const pokemonSpDefense = parseInt(pokemonCard.dataset.specialdefense) || 50;
        const pokemonSpeed = parseInt(pokemonCard.dataset.speed) || 50;
        const pokemonImg = pokemonCard.dataset.iconpath;

        pokemonList[index] = new Pokemon(
            pokemonName,
            pokemonType1,
            pokemonType2,
            pokemonHP,
            pokemonAttack,
            pokemonDefense,
            pokemonSpAttack,
            pokemonSpDefense,
            pokemonSpeed,
            pokemonImg
        );
    });
    return pokemonList;
}

const userPokemonCards = document.querySelector('.combate-pokemons-usuario').querySelectorAll('.pokemon-card');
const opponentPokemonCards = document.querySelector('.combate-pokemons-rival').querySelectorAll('.pokemon-card');

const userPokemon = getPokemons(userPokemonCards);
const opponentPokemon = getPokemons(opponentPokemonCards);

console.log(userPokemon);

const battleContainer = document.querySelector('.combate-pokemons-container');
const startButton = document.getElementById('start-battle');

startButton.addEventListener('click', () => {
    battleContainer.innerHTML = '';
    battleContainer.innerHTML = `
    <div class="contenedor-combate">
        <div id="combate">
            <div class="pokemon-usuario-restantes"></div>   
                <div id="pokemon-usuario" class="pokemon-container">
                    <div class="pokemon-info">
                        <h3 id="pokemon-usuario-nombre">${userPokemon[0].getName()}</h3>
                        <div class="health-bar-container">
                            <div class="health-bar" style="width: 100%"></div>
                        </div>
                    </div>
                    <img id="pokemon-usuario-img" src="${userPokemon[0].getImage()}" alt="Imagen Pokémon">
                </div>
            </div>

            <div id="pokemon-rival" class="pokemon-container">
                <div class="pokemon-usuario-restantes"></div>
                    <div class="pokemon-info">
                        <h3 id="pokemon-rival-nombre">${opponentPokemon[0].getName()}</h3>
                        <div class="health-bar-container">
                        <div class="health-bar" style="width: 100%"></div>
                    </div>
                </div>
                <img id="pokemon-rival-img" src="${opponentPokemon[0].getImage()}" alt="Imagen Pokémon">
            </div>  
            <div id="battle-log" class="battle-log">
                <h2>Battle Log</h2>
                <ul id="log-list"></ul>
            </div>      
        </div>
    </div>
    `;

    // Start the battle
    const battle = new Battle(userPokemon, opponentPokemon);
    console.log(userPokemon);
    console.log(opponentPokemon);
    battle.start();
});