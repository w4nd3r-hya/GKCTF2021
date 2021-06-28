#!/bin/bash

echo $FLAG > /flag
export DASFLAG=flag_not_here
DASFLAG=flag_not_here
rm -f /flag.sh
