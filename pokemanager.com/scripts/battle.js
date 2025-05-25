import { Pokemon } from './pokemon.js';
import { getTypeMultiplier } from './typeMatrix.js';

class Battle {
    /**
     * Represents a battle between two Pokémon trainers.
     * @param {Pokemon} player - The player's Pokémon.
     * @param {Pokemon} opponent - The opponent's Pokémon.
     */
    constructor(player, opponent) {
        this.player = player;
        this.opponent = opponent;
        this.turn = 0;
        this.log = [];
        this.battleInterval = null;
    }

    start() {
        console.log(`Battle started between ${this.player.name} and ${this.opponent.name}`);
        this.log.push(`Battle started between ${this.player.name} and ${this.opponent.name}`);
        this.updateUI();

        // Start battle with 1-second intervals between turns
        this.battleInterval = setInterval(() => {
            if (this.player.isAlive() && this.opponent.isAlive()) {
                this.takeTurn();
                this.updateUI();
            } else {
                this.endBattle();
            }
        }, 1000);
    }

    endBattle() {
        clearInterval(this.battleInterval);
        if (!this.player.isAlive()) {
            this.log.push(`${this.player.name} has fainted!`);
            console.log(`${this.player.name} has fainted!`);
        }
        if (!this.opponent.isAlive()) {
            this.log.push(`${this.opponent.name} has fainted!`);
            console.log(`${this.opponent.name} has fainted!`);
        }
        this.updateUI();
    }

    takeTurn() {
        this.turn++;
        let attacker, defender;

        // Determine who attacks first based on speed
        if (this.player.speed >= this.opponent.speed) {
            attacker = this.player;
            defender = this.opponent;
        } else {
            attacker = this.opponent;
            defender = this.player;
        }

        this.log.push(`Turn ${this.turn}: ${attacker.name} attacks first!`);
        console.log(`Turn ${this.turn}: ${attacker.name} attacks first!`);

        // Perform attack
        this.performAttack(attacker, defender);

        // If defender is still alive, they attack back
        if (defender.isAlive()) {
            this.performAttack(defender, attacker);
        }
    }

    performAttack(attacker, defender) {
        let damage;
        let attackType;

        // 50% chance for physical or special attack
        if (Math.random() < 0.5) {
            // Physical attack
            attackType = "Physical";
            damage = attacker.attack / (1 + (defender.defense / 100)) * 0.5;
        } else {
            // Special attack
            attackType = "Special";
            const typeMultiplier = getTypeMultiplier(attacker.type1.toUpperCase(), defender.type1.toUpperCase());
            damage = attacker.spAttack / (1 + (defender.spDefense / 100)) * 0.5 * typeMultiplier;
        }

        defender.receiveDamage(Math.round(damage));

        const logMessage = `${attacker.name} uses ${attackType} attack! ${defender.name} takes ${Math.round(damage)} damage.`;
        this.log.push(logMessage);
        console.log(logMessage);
    }

    updateUI() {
        // Update health bars
        const playerHP = document.querySelector('#pokemon-usuario .health-bar');
        const opponentHP = document.querySelector('#pokemon-rival .health-bar');

        if (playerHP) {
            playerHP.style.width = `${(this.player.hp / this.player.maxHP) * 100}%`;
        }
        if (opponentHP) {
            opponentHP.style.width = `${(this.opponent.hp / this.opponent.maxHP) * 100}%`;
        }

        // Update battle log
        const logList = document.getElementById('log-list');
        if (logList) {
            logList.innerHTML = this.log.map(entry => `<li>${entry}</li>`).join('');
            logList.scrollTop = logList.scrollHeight;
        }
    }
}

function getPokemons(list) {
    const pokemonList = [];

    list.forEach((pokemonCard, index) => {
        const pokemonName = pokemonCard.dataset.name;
        const pokemonType1 = pokemonCard.dataset.type1 || 'Normal'; // Default to Normal type if not specified
        const pokemonType2 = pokemonCard.dataset.type2 || null;
        const pokemonHP = parseInt(pokemonCard.dataset.hp) || 100;
        const pokemonAttack = parseInt(pokemonCard.dataset.attack) || 50;
        const pokemonDefense = parseInt(pokemonCard.dataset.defense) || 50;
        const pokemonSpAttack = parseInt(pokemonCard.dataset.specialattack) || 50;
        const pokemonSpDefense = parseInt(pokemonCard.dataset.specialdefense) || 50;
        const pokemonSpeed = parseInt(pokemonCard.dataset.speed) || 50;
        const pokemonImg = pokemonCard.dataset.iconpath; // Default image if not specified

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

userPokemon.forEach(pokemon => {
    console.log(pokemon.toString());
});

const battle = new Battle(userPokemon[0], opponentPokemon[0]);

const battleContainer = document.querySelector('.combate-pokemons-container');
const startButton = document.getElementById('start-battle');

startButton.addEventListener('click', () => {
    battleContainer.innerHTML = '';
    battleContainer.innerHTML = `
    <div id="contenedor-combate">
        <div id="pokemon-usuario" class="pokemon-container">
            <div class="pokemon-usuario-restantes"></div>
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
    </div>
    <div id="battle-log" class="battle-log">
        <h2>Battle Log</h2>
        <ul id="log-list"></ul>
    </div>
    `;

    // Start the battle
    const battle = new Battle(userPokemon[0], opponentPokemon[0]);
    battle.start();
});