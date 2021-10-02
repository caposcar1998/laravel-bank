# GD #2 y #3 - Implementación API y testing

## Oscar Contreras Palacios A01655772

## Manuel Ortiz Hernández A01655515

## Gerardo Arturo Miranda A01338074

# Endoints


### POST crear cuenta

accounts

```
    header: Authorization Bearer token xxxxxxxx

    body: {
        "nombreCuenta": "cuentaOscar"
        }
```
### GET  account

```
accounts/{account}

header: Authorization Bearer token xxxxxxxx
```


### POST movement 

```
accounts/{account}/movements

header: Authorization Bearer token xxxxxxxx

body: {
    "type": 1,
    "description" : "Retiro de 500 para medicamentos",
    "amount": 500
}

```
