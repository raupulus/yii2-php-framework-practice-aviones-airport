#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE examen2_test;"
    psql -U postgres -c "CREATE USER examen2 PASSWORD 'examen2' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists examen2
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists examen2_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists examen2
    sudo -u postgres psql -c "CREATE USER examen2 PASSWORD 'examen2' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O examen2 examen2
    sudo -u postgres createdb -O examen2 examen2_test
    LINE="localhost:5432:*:examen2:examen2"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
