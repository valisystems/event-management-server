#!/bin/bash

PATH_FROM="${1}"
PATH_TO="${2}"

cd $PATH_FROM
echo -e 'Folder Changed Successfuly ...\n'
cp -Ruf * $PATH_TO
echo -e 'Files updated successfuly ...\n'
cd ..
rm -rf $PATH_FROM
echo -e 'Temporary file removed successfuly ... \n'
rm -rf "${PATH_FROM}.tar"
rm -rf "${PATH_FROM}.tar.gz"

echo -e 'Temporary archive removed successfuly ...'

#php "${PATH_TO}/protected/yiic migrate up --interactive=0"