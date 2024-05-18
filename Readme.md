# FableFlow
FableFlow is a collaborative storytelling platform that serves as a dynamic social space for individuals to share their stories and contribute to the narratives crafted by others.

# Apache Environement Configuration
The website uses a routing system to manage the requests, to make this happen is needed to configure an "httpd.conf" file, in the apache directory.
The procedure is similar for each OS:

## Windows
On Windows, copy the content of the file "httpd.conf" (located in the directory of the project), and go in the installation directory of XAMPP, from there move to the "apache\conf\" folder, inside of that folder there should be a file named like the one we copied: "httpd.conf", open it, and scroll down to the bottom of it, then paste the copied code and change the path of the htdocs folder so that they match yours.
> NOTE: Even if in Windows, the separator is '\', use '/' instead.\
> NOTE2: When the path ends with '\' put it, when it doesn't, don't.

Examples:
- <Directory "/opt/lampp/htdocs"> ---> <Directory "C:/xampp/htdocs"> **CORRECT**
- <Directory "/opt/lampp/htdocs"> ---> <Directory "C:\xampp\htdocs"> **WRONG separator**
- <Directory "/opt/lampp/htdocs"> ---> <Directory "C:/xampp/htdocs/"> **WRONG ending character**

## Linux
!!! FILL WITH A LINUX TUTORIAL !!!

# TO-DO List
Mockup da  fare:
- [x] Home Page 
- [x] Home Page con side bar
- [x] Notifiche
- [x] Chat (lista contatti)
- [x] Chat (messaggi)
- [x] Racconto (Guest view)
    - [x] Racconto scene
    - [x] Pool scene
    - [x] Proposal scene
- [x] Profilo utente
- [X] Racconto (Master view)
    - [X] Racconto scene 
    - [x] Pool scene
- [X] Creare frecce per tornare indietro e migliorare la navigazione.
+ altre se ci vengono in mente

Main TO-DO:
- [X] Design
- [ ] Registrazione e Login (Ciano)
- [ ] Home con feed di post di utenti seguiti (Giacomo)
- [ ] Post: Storia (con possibile immagine allegata) (Giacomo)
- [ ] Post: Pool (Ciano)
- [ ] Post: Proposals (Giacomo)
- [ ] Post: Commenti (Giacomo)
- [ ] Search bar
- [ ] Gestione del follow tra utenti (Dario)
- [ ] Profilo utente con post (Dario)
- [ ] Gestione delle immagini (Dario)
- [ ] Gestione Notifiche (Giacomo)

Side TO-DO:
- [X] Javascript variables have to be let and const not var
- [ ] Desktop Mockup
- [ ] Security sulle DB query
- [X] MVC pattern (si farà solo in parte per questioni di tempo)
- [ ] Check the difference between SQL tables and SQL diagram
- [ ] Code refactory (check if have been used HTML standard tags where possible) IMPORTANT!!!
- [ ] Check for redundant JS code, and make an Utilities.js class
- [X] Scegliere le palette

Feature da aggiungere potrebbero essere:
- tasto per la lettura automatica del testo
- daily story challenge (tema del giorno che il sistema propone agli utenti) (optional)
- archivements (optional)
- gli utenti possono commentare
- gli utenti possono proporre continui storie
- il master può proporre delle pool per continuare la storia
- notifiche update storia
- spoiler

Per gli effetti wow, si può aggiungere:
- il salt alle password (ancora meglio, autentificazione con google, quindi no password)
- quando clicchi senti il click, quindi fa l'effetto sweet

## Mockup
![Main Page (mobile)](https://github.com/IGieckI/FableFlow/assets/52384860/210674b1-eea4-47c9-8da4-065bda3152a1)
![Main Page Hamburger (mobile)](https://github.com/IGieckI/FableFlow/assets/52384860/8fbeb592-5b46-48f0-86d2-3b8daf65731b)
