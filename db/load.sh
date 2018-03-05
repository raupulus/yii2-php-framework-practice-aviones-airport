#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U examen2 -d examen2 < $BASE_DIR/examen2.sql
fi
psql -h localhost -U examen2 -d examen2_test < $BASE_DIR/examen2.sql
