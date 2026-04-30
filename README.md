# API REST Template 
## Summary
Simple API REST blank Template with HTTP/HTTPS configuration for read-only or crud.
## Introduction
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
On the root folder, you can copy .env.example file in a .env file and set your own variables.
Windows :

```cmd
xcopy "C:\Users\my\path\to\folder\.env.example" "C:\Users\my\path\to\folder\.env"
```

Linux : 
```bash
cp "C:\Users\my\path\to\folder\.env.example" "C:\Users\my\path\to\folder\.env"
```
## Contributing