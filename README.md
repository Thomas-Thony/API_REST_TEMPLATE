# API REST Template 
- [Introduction](#introduction)
- [Getting started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Environnement Configuration](#environnement-configuration)
- [Contributing](#contributing)
## Introduction
Simple API REST blank Template with HTTP/HTTPS configuration for read-only or crud.
## Getting started
### Requirements
You need this tools below :
 1. Composer 
 2. LAMP or XAMP (MAMP not tested yet)
### Installation
You can clone easly the repo in your LAMP or XAMP folder `www`.
Then, place yourself in the folder and install composer's packages : 
```composer
composer install || composer update
```
### Environnement configuration
On the root folder, you can copy .env.example file in a .env file and set your own variables. <br>
Windows :

```cmd
xcopy "C:\Users\my\path\to\folder\.env.example" "C:\Users\my\path\to\folder\.env"
```

Linux : 
```bash
cp "C:\Users\my\path\to\folder\.env.example" "C:\Users\my\path\to\folder\.env"
```
## Contributing
Actually, this project is just a base for every API Rest in PHP, so the project doesn't have an objective to be an all in one API or used on a large scale. But rather by developpers on their own that don't want to recreate the wheel everytime. However, I would enjoy that people give importance to this project and add their own work.