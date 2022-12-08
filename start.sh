read -p "Enter namespace for plugin : " namespace
find . -type f \( -iname "*.php" -or -iname "*.yaml" -or -iname "*.json" \) -exec sed -i "s=Bolge\\\=${namespace}\\\=g" {} +
