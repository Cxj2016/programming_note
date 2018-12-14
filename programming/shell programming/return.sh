#!/bin/sh

STRING=

if [ -z "$STRING" ]; then 
    echo "STRING is empty" 
fi

if [ -n "$STRING" ]; then 
    echo "STRING is not empty" 
fi
