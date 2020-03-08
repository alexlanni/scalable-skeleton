# Scalar Application Skeleton

## Skeleton di una applicazione PHP con funzionalita' di scalabilita'.

###### Alessandro Lanni (c)2020

## Configutazione

Per poter inizializzare l' applicazione, installare Docker e Docker-Compose.

Creare i files:

- ./secrets/mysql-user
- ./secrets/mysql-password
- ./secrets/mysql-root

Ed inserirci le informazioni che si desidera dare a:

- Utente MySQL da usare
- Password dell'Utente
- Password di Root


Come esempio si usera' il database mydatabase. Puoi aggiungerne altri al master, 
ma dovrai specificare altre righe di:

````
replicate-do-db=<nomedatabase>
````

Nel file `data/configs/slave/conf.d/slave.cnf`.

