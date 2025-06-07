import requests

def get_pokemon_description(pokemon_id):
    try:
        response = requests.get(f"https://pokeapi.deepseek.com/v1/pokemon/{pokemon_id}")
        response.raise_for_status()
        return response.json().get('description', '').replace("'", "''")
    except:
        return None

def main():
    with open('pokemon_updates.sql', 'w') as f:
        f.write("-- Updates Pokémon descriptions\n\n")
        
        for pokemon_id in range(1, 722):
            desc = get_pokemon_description(pokemon_id)
            if desc:
                f.write(f"UPDATE pokemon SET descripcion = '{desc}' WHERE id = {pokemon_id};\n")
            
            print(f"Procesados {pokemon_id} Pokémon...")

if __name__ == "__main__":
    main()