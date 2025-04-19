import requests
import time


API_KEY = ''
API_URL = 'https://api.deepseek.com/v1/chat/completions'
HEADERS = {
    'Authorization': f'Bearer {API_KEY}',
    'Content-Type': 'application/json'
}


PROMPT_TEMPLATE = """
Proporciona una descripción breve y concisa (máximo 2 oraciones) del Pokémon con número {id} 
en tercera persona. Solo incluye la descripción sin formato, números, ni nombres de usuario.
"""


def get_pokemon_description(pokemon_id):
    prompt = PROMPT_TEMPLATE.format(id=pokemon_id)

    payload = {
        "model": "deepseek-chat",
        "messages": [{"role": "user", "content": prompt}],
        "temperature": 0.7,
        "max_tokens": 100
    }

    try:
        response = requests.post(API_URL, headers=HEADERS, json=payload)
        response.raise_for_status()

        description = response.json(
        )['choices'][0]['message']['content'].strip()
        return description.replace("'", "''")

    except Exception as e:
        print(f"Error en ID {pokemon_id}: {str(e)}")
        return None


def generate_update_queries():
    with open('pokemon_updates.sql', 'a', encoding='utf-8') as file:
        for id in range(293, 722):
            description = None
            retries = 3

            while retries > 0 and not description:
                description = get_pokemon_description(id)
                if not description:
                    time.sleep(2)
                    retries -= 1

            if description:
                update_query = f"UPDATE pokemon SET Description = '{description}' WHERE id = {id};\n"
                file.write(update_query)
                print(f"ID {id} procesado")
                print(update_query.strip())
            else:
                print(f"Error persistente en ID {id}")

            time.sleep(1)


if __name__ == '__main__':
    generate_update_queries()
