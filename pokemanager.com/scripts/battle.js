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

        // Guardar el número inicial de Pokémon para las pokéballs
        this.initialPlayerCount = this.playerPokemons.length;
        this.initialOpponentCount = this.opponentPokemons.length;

        this.setAttackPriority();  // Inicializar la prioridad de ataque
    }

    setAttackPriority() {
        if (this.currentPlayerPokemon.speed >= this.currentOpponentPokemon.speed) {
            this.attacker = this.currentPlayerPokemon;
            this.defender = this.currentOpponentPokemon;
        } else {
            this.attacker = this.currentOpponentPokemon;
            this.defender = this.currentPlayerPokemon;
        }
    }

    /**
     * Muestra la animación de lanzar pokéball
     */
    showPokeballAnimation(isPlayer = true) {
        const combateDiv = document.getElementById('combate');
        if (!combateDiv) return;

        // Crear elemento de pokéball
        const pokeball = document.createElement('img');
        pokeball.src = 'img/pokeball_launch.png';
        pokeball.alt = 'Pokéball';
        pokeball.className = isPlayer ? 'pokeball-usuario-animation' : 'pokeball-rival-animation';

        // Añadir la pokéball al combate
        combateDiv.appendChild(pokeball);

        // Remover la pokéball después de la animación
        setTimeout(() => {
            if (pokeball.parentNode) {
                pokeball.parentNode.removeChild(pokeball);
            }
        }, 1200); // Duración de la animación
    }

    /**
     * Muestra la animación de aparición del Pokémon
     */
    showPokemonAppearAnimation(isPlayer = true) {
        const pokemonImg = isPlayer ?
            document.getElementById('pokemon-usuario-img') :
            document.getElementById('pokemon-rival-img');

        if (pokemonImg) {
            pokemonImg.classList.add(isPlayer ? 'pokemon-appear-user' : 'pokemon-appear-rival');

            // Remover la clase después de la animación
            setTimeout(() => {
                pokemonImg.classList.remove(isPlayer ? 'pokemon-appear-user' : 'pokemon-appear-rival');
            }, 1000);
        }
    }

    /**
     * Comienza el combate.
     */
    start() {
        this.log.push("¡Comienza el combate!");

        // Ocultar inicialmente los Pokémon
        const playerImg = document.getElementById('pokemon-usuario-img');
        const rivalImg = document.getElementById('pokemon-rival-img');
        if (playerImg) playerImg.style.opacity = '0';
        if (rivalImg) rivalImg.style.opacity = '0';

        // Mostrar animaciones iniciales
        this.showPokeballAnimation(true);
        setTimeout(() => {
            this.showPokeballAnimation(false);
        }, 200);

        // Mostrar Pokémon después de las animaciones de Pokéball
        setTimeout(() => {
            if (playerImg) {
                playerImg.style.opacity = '1';
                this.showPokemonAppearAnimation(true);
            }
        }, 1200);

        setTimeout(() => {
            if (rivalImg) {
                rivalImg.style.opacity = '1';
                this.showPokemonAppearAnimation(false);
            }
        }, 1400);

        this.updateUI();

        this.battleInterval = setInterval(() => {
            if (this.currentPlayerPokemon.isAlive() && this.currentOpponentPokemon.isAlive()) {
                this.takeTurn();
            } else {
                this.checkFaintedPokemon();
            }
        }, 2500);
    }

    /**
     * Verifica si algún Pokémon se ha debilitado.
     */
    checkFaintedPokemon() {
        let pokemonSwitched = false;

        if (!this.currentPlayerPokemon.isAlive()) {
            this.log.push(`¡${this.currentPlayerPokemon.name} se debilitó!`);
            const index = this.playerPokemons.indexOf(this.currentPlayerPokemon);
            this.playerPokemons.splice(index, 1);

            if (this.playerPokemons.length > 0) {
                this.currentPlayerPokemon = this.playerPokemons[0];
                this.log.push(`¡Ve! ¡${this.currentPlayerPokemon.name}!`);

                // Mostrar animación de pokéball al enviar nuevo Pokémon
                setTimeout(() => {
                    this.showPokeballAnimation(true);
                }, 500);

                this.setAttackPriority();  // Recalcular quién ataca primero
                pokemonSwitched = true;
            }
        }

        if (!this.currentOpponentPokemon.isAlive()) {
            this.log.push(`¡${this.currentOpponentPokemon.name} se debilitó!`);
            const index = this.opponentPokemons.indexOf(this.currentOpponentPokemon);
            this.opponentPokemons.splice(index, 1);

            if (this.opponentPokemons.length > 0) {
                this.currentOpponentPokemon = this.opponentPokemons[0];
                this.log.push(`¡El rival envió a ${this.currentOpponentPokemon.name}!`);

                // Mostrar animación de pokéball al enviar nuevo Pokémon
                setTimeout(() => {
                    this.showPokeballAnimation(false);
                }, 500);

                this.setAttackPriority();  // Recalcular quién ataca primero
                pokemonSwitched = true;
            }
        }

        // Si se cambió un Pokémon, esperar un poco antes de actualizar la UI
        if (pokemonSwitched) {
            setTimeout(() => {
                this.updateUI();
            }, 1500);
        } else {
            this.updateUI();
        }

        if (this.playerPokemons.length === 0 || this.opponentPokemons.length === 0) {
            this.endBattle();
        }
    }

    endBattle() {
        clearInterval(this.battleInterval);
        if (this.playerPokemons.length === 0) {
            this.log.push("¡Todos tus Pokémon se debilitaron! ¡Has perdido!");
        } else {
            this.log.push("¡Has derrotado a todos los Pokémon del rival! ¡Ganaste!");
            fetch('includes/agregar_sobres.inc.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.log.push("¡Has recibido dos sobres por ganar!");
                    }
                });
        }
        this.updateUI();
    }

    takeTurn() {
        this.turn++;
        this.log.push(`Turno ${this.turn}`);
        this.updateUI();

        setTimeout(() => {
            this.performAttack(this.attacker, this.defender);
            this.updateUI();

            if (this.defender.isAlive()) {
                setTimeout(() => {
                    this.performAttack(this.defender, this.attacker);
                    this.updateUI();
                }, 1000);
            }
        }, 500);
    }

    performAttack(attacker, defender) {
        let damage;
        let attackType;
        let effectiveness = "";

        const typeMultiplier = getTypeMultiplier(attacker.type1.toUpperCase(), defender.type1.toUpperCase());
        if (Math.random() < 0.5) {
            attackType = "ataque físico";
            damage = attacker.attack / (1 + (defender.defense / 100)) * 0.5 * typeMultiplier;
        } else {
            attackType = "ataque especial";
            damage = attacker.spAttack / (1 + (defender.spDefense / 100)) * 0.5 * typeMultiplier;
        }
        if (typeMultiplier > 1) effectiveness = " ¡Es muy efectivo!";
        else if (typeMultiplier < 1 && typeMultiplier > 0) effectiveness = " ¡No es muy efectivo...";
        else if (typeMultiplier === 0) effectiveness = " ¡No afecta a este tipo de Pokémon!";

        defender.receiveDamage(Math.round(damage));

        const logMessage = `${attacker.name} usa ${attackType}! ${defender.name} pierde ${Math.round(damage)} PS.${effectiveness}`;
        this.log.push(logMessage);
    }

    /**
     * Genera las pokéballs para mostrar los Pokémon restantes
     */
    generatePokeballs(currentCount, totalCount, isPlayer = true) {
        let pokeballs = '';
        for (let i = 0; i < totalCount; i++) {
            const src = i < currentCount ? 'img/pokeball.png' : 'img/pokeball_hollow.png';
            const alt = i < currentCount ? 'Pokémon disponible' : 'Pokémon debilitado';
            pokeballs += `<img src="${src}" alt="${alt}" class="pokeball-icon">`;
        }
        return pokeballs;
    }

    scrollToBottom(element) {
        element.scrollTop = element.scrollHeight;

        requestAnimationFrame(() => {
            element.scrollTop = element.scrollHeight;
            const lastItem = element.lastElementChild;
            if (lastItem) {
                lastItem.scroll({
                    behavior: 'smooth',
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

        // Actualizar las pokéballs
        const playerRemaining = document.querySelector('.pokemon-restantes-usuario');
        const opponentRemaining = document.querySelector('.pokemon-restantes-rival');

        if (playerRemaining) {
            playerRemaining.innerHTML = this.generatePokeballs(this.playerPokemons.length, this.initialPlayerCount, true);
        }
        if (opponentRemaining) {
            opponentRemaining.innerHTML = this.generatePokeballs(this.opponentPokemons.length, this.initialOpponentCount, false);
        }

        const logList = document.getElementById('log-list');
        if (logList) {
            logList.innerHTML = this.log.map(entry => `<li>${entry}</li>`).join('');
            this.scrollToBottom(logList);
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

const battleContainer = document.querySelector('.combate-pokemons-container');
const startButton = document.getElementById('start-battle');

startButton.addEventListener('click', () => {
    battleContainer.innerHTML = '';
    battleContainer.innerHTML = `
    <div class="contenedor-combate">
    <div id="combate">
            <div id="pokemon-usuario" class="pokemon-container">
                <div class="pokemon-info">
                <div class="pokemon-restantes-usuario pokeballs-container"></div> 
                        <h3 id="pokemon-usuario-nombre">${userPokemon[0].getName()}</h3>
                        <div class="health-bar-container">
                            <div class="health-bar" style="width: 100%"></div>
                        </div>
                    </div>
                    <img id="pokemon-usuario-img" src="${userPokemon[0].getImage()}" alt="Imagen Pokémon">
            </div>
        </div>

        <div id="pokemon-rival" class="pokemon-container">
                <div class="pokemon-info">
                    <div class="pokemon-restantes-rival pokeballs-container"></div>
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

    battle.start();
});