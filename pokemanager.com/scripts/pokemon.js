export class Pokemon {
    constructor(name, type1, type2, hp, attack, defense, spAttack, spDefense, speed, img) {
        this.name = name;
        this.type1 = type1;
        this.type2 = type2 || null;
        this.maxHP = hp || 100;
        this.hp = this.maxHP;
        this.attack = attack || 50;
        this.defense = defense || 50;
        this.spAttack = spAttack || 50;
        this.spDefense = spDefense || 50;
        this.speed = speed || 50;
        this.img = img;
    }
    getName() {
        return this.name;
    }
    getType1() {
        return this.type1;
    }
    getType2() {
        return this.type2;
    }
    getHP() {
        return this.hp;
    }
    getMaxHP() {
        return this.maxHP;
    }
    getAttack() {
        return this.attack;
    }
    getDefense() {
        return this.defense;
    }
    getSpAttack() {
        return this.spAttack;
    }
    getSpDefense() {
        return this.spDefense;
    }
    getSpeed() {
        return this.speed;
    }
    getImage() {
        return this.img || 'default.png'; // Default image if not specified
    }

    setHP(hp) {
        this.hp = Math.min(this.maxHP, hp);
    }
    setMaxHP(maxHP) {
        this.maxHP = maxHP;
        this.hp = Math.min(this.hp, this.maxHP); // Ensure current HP does not exceed new max
    }
    setAttack(attack) {
        this.attack = attack;
    }
    setDefense(defense) {
        this.defense = defense;
    }
    setSpAttack(spAttack) {
        this.spAttack = spAttack;
    }
    setSpDefense(spDefense) {
        this.spDefense = spDefense;
    }
    setSpeed(speed) {
        this.speed = speed;
    }
    // Métodos para manejar el daño y la vida del Pokémon
    
    receiveDamage(damage) {
        this.hp = Math.max(0, this.hp - damage);
    }

    isAlive() {
        return this.hp > 0;
    }

    // Métodos opcionales (para futuras expansiones)
    attackOpponent(opponent) {
        const damage = this.attack / (1 + (opponent.defense / 100)) * 0.5;
        opponent.receiveDamage(damage);
    }

    toString() {
        return `${this.name} 
        (${this.type1}${this.type2 ? '/' + this.type2 : ''})
        HP: ${this.hp}/${this.maxHP} 
        Attack: ${this.attack} Defense: ${this.defense},
        Sp. Attack: ${this.spAttack} Sp. Defense: ${this.spDefense},
        Speed: ${this.speed}
        Image: ${this.img}`;
    }
}

