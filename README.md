# Scripts to setup easily your enviroment.

## Setup the scripts.

1. The scripts files must have the right permissions.
You can change it using the command `'chmod u+x'`.

2. Create the file if not exists `/home/youruser/.bash_aliases`.

3. Then add the follow line: `alias cdir="scriptsdirectory/cdir"`

## Cdir file
> Only works with yakuake.
```
  cdir vg                              -Going into vagrant is
  cdir vg projectdir [subdirectory]    -Going to the docroot in the vagrant
  cdir p projectdir [subdirectory]     -Going to the docroot project
  cdir vgup                            -Start the machine vagrant and rsync // Do a sudo ls or something like that to set the password after execute script
```

## vagrant8start file
> Only works with yakuake
```
  Do a sudo ls or something like this to set the password after execute script

  vgstart projectdir [projectdirvagrant] -Prepare rsync tab, vagrant tab with docroot project, and codebase tab in docroot directory
  vgstart nop                            -Same that previous but it does not change to the docroot directory
```
