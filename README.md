# DnD
This project is the MVP version. This application allows you:
* render your player character card
* create item or spell cards
* set the date of the next session by voting

The application can be found at https://dnd.vxm.pl, after registration, please write me an e-mail at: p.czyzewski5@gmail.com to activate your account.

## Local environment requirements
Console, docker, docker-compose, make, internet.

## How to launch on the local environment
1. navigate to project dir in console and execute `make start`
2. answer `yes` on migration prompt<br/>![migration prompt](public/images/migration_prompt.jpg)
3. when console is ready execute `docker-compose ps` and locate port near nginx container e.g `8080`<br/>![docker-compose ps](public/images/docker_compose_ps.jpg "San Juan Mountains")
4. navigate to localhost with found port e.g `localhost:8080` and login with `example@test.com` and `Pass123@`