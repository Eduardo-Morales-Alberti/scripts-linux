# Scripts to setup easily your enviroment.

## Setup the scripts.

1. The scripts files must have the right permissions.
You can change it using the command `'chmod u+x'`.

2. Create the file if not exists `/home/youruser/.bash_aliases`.

3. Then add the followings lines:
```
alias cdir="scriptsdirectory/cdir"
alias vgstart="scriptsdirectory/vagrant8start"
alias phpcs-ultimate="scriptsdirectory/phpcs-ultimate"
```

4. Also add the following line: `source "scriptsdirectory/autocompleteFunctions"` at .bashrc file on your home directory.

## Cdir file
> Only works with yakuake.
```
  cdir vg              -Going into vagrant is
  cdir projectdir vg   -Going to the directory in the vagrant
  cdir projectdir  p   -Going to the docroot project
  cdir vgup            -Start the machine vagrant and rsync // Do a sudo ls or something like that to set the password after execute script
```

## vagrant8start file
> Only works with yakuake
```
  Do a sudo ls or something like that to set the password after execute script

  vgstart projectdir    -Prepare rsync tab, vagrant tab with docroot project, and codebase tab in docroot directory
  vgstart               -Same that previous but it does not change to the docroot directory
```

## phpcs-ultimate
> Use phpcs-ultimate to check the coding standard to your projects.
```
  Use phpcs-ultimate before commit your Drupal Code.
  First add your files to the git stage.
  Then run the command phpcs-ultimate
```
