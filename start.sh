mainfile='bolge'

printf "Hello in Bolge installation wizard\n\n"

echo "Did you change plugin directory name or main file name [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter name : " mainfile
fi



echo "Would you like me to rename namespace [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter namespace : " namespace
find . -type f \( -iname "*.php" -or -iname "*.yaml" -or -iname "*.json" \) -exec sed -i "s=Bolge\\\=${namespace}\\\=g" {} +
fi

echo "Would you like me to rename plugin name [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter name : " pluginname
sed -i "s=Plugin Name: .*=Plugin Name: ${pluginname}=g" ./$mainfile.php
fi

echo "Would you like me to rename plugin description [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter description : " plugindescription
sed -i "s=description: .*=description: ${plugindescription}=g" ./$mainfile.php
fi

echo "Would you like me to rename text domain [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter text domain : " plugintextdomain
sed -i "s=Text Domain: .*=Text Domain: ${plugintextdomain}=g" ./$mainfile.php
sed -i "s=load_plugin_textdomain('[^']*'=load_plugin_textdomain('${plugintextdomain}'=g" ./$mainfile.php
fi

echo "Would you like me to rename plugin directory and main file [y/n]? "
read q
if [[ "${q}" == "yes" ]] || [[ "${q}" == "y" ]]; then
read -p "Enter name (without special characters and spaces, use only if name is default - bolge) : " pluginnamedirectory
mv $mainfile.php $pluginnamedirectory.php
mv ../$mainfile ../$pluginnamedirectory
fi
