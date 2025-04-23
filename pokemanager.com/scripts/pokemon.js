class Pokemon {
    constructor(name, type1, type2, level, exp, hp, attack, defense, speed) {
        this.name = name;
        this.type1 = type1;
        this.type2 = type2 || null; // Type2 is optional
        this.level = level;
        this.exp = exp
        this.hp = hp || 100; // Default HP
        this.attack = attack || 50; // Default attack
        this.defense = defense || 50; // Default defense
        this.speed = speed || 50; // Default speed      
    }

    getDamage(opponent) {
        // Simple damage calculation based on attack and opponent's defense
        const damage = Math.max(0, this.attack / (1 + (opponent.defense / 100)));
        return damage;
    }
    attackOpponent(opponent) {
        const damage = this.getDamage(opponent);
        opponent.hp -= damage;
        console.log(`${this.name} attacked ${opponent.name} for ${damage} damage!`);
    }
    levelUp() {
        this.level++;
        console.log(`${this.name} leveled up to level ${this.level}!`);
    }

    toString() {
        return `${this.name} (Level ${this.level}) -
         Type: ${this.type1}${this.type2 ? '/' + this.type2 : ''}
         - HP: ${this.hp} - Attack: ${this.attack}
          - Defense: ${this.defense} - Speed: ${this.speed}`;
    }

    
}