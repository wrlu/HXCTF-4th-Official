import os
import base64
from cryptography import x509
from cryptography.x509 import Certificate
from cryptography.hazmat.backends import default_backend
from cryptography.hazmat.primitives import serialization
from cryptography.hazmat.primitives import hashes
from cryptography.hazmat.primitives.asymmetric import rsa
from cryptography.hazmat.primitives.asymmetric import padding

def get_public_key():
    certificate_file = open('server.crt','rb')
    certificate = x509.load_pem_x509_certificate(
        certificate_file.read(),
        default_backend()
    )
    certificate_file.close()
    kpub = certificate.public_key()
    return kpub
    
def get_private_key():
    private_key_file = open('server.key','rb')
    kpr = serialization.load_pem_private_key(
        private_key_file.read(),
        password=None,
        backend=default_backend())
    return kpr

def sign_message(code,kpr):
    message = code.encode('utf8')
    signature = kpr.sign(
        message,
        padding.PSS(
            mgf=padding.MGF1(hashes.SHA256()),
            salt_length=padding.PSS.MAX_LENGTH
        ),
        hashes.SHA256()
    )
    return base64.b64encode(signature)

def check_sign(code,signature,kpub):
    message = code.encode('utf8')
    signature = base64.b64decode(signature)
    try:
        kpub.verify(
            signature,
            message,
            padding.PSS(
                mgf=padding.MGF1(hashes.SHA256()),
                salt_length=padding.PSS.MAX_LENGTH
            ),
            hashes.SHA256()
        )
        return True
    except Exception:
        return False

if __name__ == '__main__':
    public_key = get_public_key()
    code = input('[+] Give me your shell code:')
    signature = input('[+] Give me your signature:')
    if check_sign(code, signature, public_key)==True:
        print('OK. Now run your shell code.')
        os.system(code)
    else:
        print('Ohhhhh, we cannot run your shell code.')

    
    