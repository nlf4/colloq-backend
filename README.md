# lexik_jwt_test
### Test Lexik JWT Authorisation Bundle

### Installatie
- Clone dit project
- Creëer een nieuwe lege **databank**
- Voeg een **.env** bestand toe met daarin de connectie naar de databank
- **composer install**
- Voer de **migrations** uit om de **user** table te creëren
- Voer de **fixtures** uit om **één gebruiker** aan te maken zoals voorzien in de **UserFixture**
- Voorzie in de map **config/jwt** de sleutelbestanden **private.pem** en **public.pem** (zie handleiding); gebruik
hierbij een eigen passphrase, en zet die in **config/packages/lexik_jwt_authentication.yaml**

### Gebruik
- de route **POST** -> **/api/login_check** geeft een JWT mits een geldige username en password verzonden worden (in JSON formaat)
- de route **GET** -> **/api/someinfo** geeft een eenvoudige JSON response terug mits verzonden met een JWT
- de route **GET** -> **/api/account** geeft een eenvoudige JSON response met extra user info terug mits verzonden met een JWT
