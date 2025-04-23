class Combat {
    constructor() {
        this.currentEnemy = null;
        this.currentPlayer = null;
        this.enemyHealthBar = document.getElementById('barraVidaRival');
        this.playerHealthBar = document.getElementById('barraVidaRival');
    }

    startCombat(player, enemy) {
        this.currentPlayer = player;
        this.currentEnemy = enemy;
        this.updateHealthBars();
    }

    updateHealthBars() {
        this.enemyHealthBar.style.width = `${(this.currentEnemy.health / this.currentEnemy.maxHealth) * 100}%`;
        this.playerHealthBar.style.width = `${(this.currentPlayer.health / this.currentPlayer.maxHealth) * 100}%`;
    }
}

// const dialogoCombate = document.querySelector('.dialogo-combate');

// dialogoCombate.addEventListener('click', function() {
//     dialogoCombate.showModal();
    
// });