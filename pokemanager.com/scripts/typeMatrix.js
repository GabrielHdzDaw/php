export const typeMultiplier = {
    NORMAL: { ROCK: 0.5, GHOST: 0, STEEL: 0.5 },
    FIRE: { FIRE: 0.5, WATER: 0.5, GRASS: 2, ICE: 2, BUG: 2, ROCK: 0.5, DRAGON: 0.5, STEEL: 2 },
    WATER: { FIRE: 2, WATER: 0.5, GRASS: 0.5, GROUND: 2, ROCK: 2, DRAGON: 0.5 },
    ELECTRIC: { WATER: 2, ELECTRIC: 0.5, GRASS: 0.5, GROUND: 0, FLYING: 2, DRAGON: 0.5 },
    GRASS: { FIRE: 0.5, WATER: 2, GRASS: 0.5, POISON: 0.5, GROUND: 2, FLYING: 0.5, BUG: 0.5, ROCK: 2, DRAGON: 0.5, STEEL: 0.5 },
    ICE: { FIRE: 0.5, WATER: 0.5, GRASS: 2, ICE: 0.5, GROUND: 2, FLYING: 2, DRAGON: 2, STEEL: 0.5 },
    FIGHTING: { NORMAL: 2, ICE: 2, ROCK: 2, DARK: 2, STEEL: 2, POISON: 0.5, FLYING: 0.5, PSYCHIC: 0.5, BUG: 0.5, GHOST: 0, FAIRY: 0.5 },
    POISON: { GRASS: 2, FAIRY: 2, POISON: 0.5, GROUND: 0.5, ROCK: 0.5, GHOST: 0.5, STEEL: 0 },
    GROUND: { FIRE: 2, ELECTRIC: 2, POISON: 2, ROCK: 2, STEEL: 2, GRASS: 0.5, BUG: 0.5, FLYING: 0 },
    FLYING: { GRASS: 2, FIGHTING: 2, BUG: 2, ELECTRIC: 0.5, ROCK: 0.5, STEEL: 0.5 },
    PSYCHIC: { FIGHTING: 2, POISON: 2, PSYCHIC: 0.5, STEEL: 0.5, DARK: 0 },
    BUG: { GRASS: 2, PSYCHIC: 2, DARK: 2, FIRE: 0.5, FIGHTING: 0.5, POISON: 0.5, FLYING: 0.5, GHOST: 0.5, STEEL: 0.5, FAIRY: 0.5 },
    ROCK: { FIRE: 2, ICE: 2, FLYING: 2, BUG: 2, FIGHTING: 0.5, GROUND: 0.5, STEEL: 0.5 },
    GHOST: { PSYCHIC: 2, GHOST: 2, DARK: 0.5, NORMAL: 0 },
    DRAGON: { DRAGON: 2, STEEL: 0.5, FAIRY: 0 },
    DARK: { PSYCHIC: 2, GHOST: 2, FIGHTING: 0.5, DARK: 0.5, FAIRY: 0.5 },
    STEEL: { ICE: 2, ROCK: 2, FAIRY: 2, FIRE: 0.5, WATER: 0.5, ELECTRIC: 0.5, STEEL: 0.5 },
    FAIRY: { FIGHTING: 2, DRAGON: 2, DARK: 2, FIRE: 0.5, POISON: 0.5, STEEL: 0.5 }
};

export function getTypeMultiplier(attackingType, defendingType) {
  const mult = typeMultiplier[attackingType]?.[defendingType];
  return mult !== undefined ? mult : 1.0;
}