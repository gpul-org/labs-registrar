## GPUL Labs Registrar

Este é o repositorio da aplicación web de rexistro de asistentes aos
GPUL Labs. En breve estará dispoñible.

## Como probar o software

O xeito máis rápido e reproducible é:

1. Baixar [Homestead](https://laravel.com/docs/5.1/homestead)
  1. Instalar Vagrant (`apt-get install vagrant` | `dnf install vagrant`), con VirtualBox
  2. Baixar a imaxe de Homestead para Vagrant (`vagrant box add laravel/homestead`)
2. Baixar o repo de homestead `git clone https://github.com/laravel/homestead.git Homestead`
3. Executar `./init.sh`
4. Modificar `~/.homestead/Homestead.yaml` e axustar os paths ao lugar apropiado
5. Lanzar vagrant (dende o repo de homestead) con `vagrant up`

## Contribucións

Gracias por considerar contribuir aos GPUL Labs. Podes atopar
[issues abertas](https://github.com/gpul-org/labs-registrar/issues) e
tratar de pechalas, e tras iso facer unha pull request. Seguimos o
github-flow para contribucións externas.

### Licencia

Esta versión atópase baixo licencia MIT. Ao contribuir cambios aceptas
publicar os teus baixo esta mesma licencia.

