#!/bin/bash

# Script mejorado para ejecutar tests paralelos con limpieza
echo "🧹 Limpiando bases de datos de tests paralelos anteriores..."

# Limpiar bases de datos de workers anteriores
for i in {1..16}; do
    docker exec -it blockpc-mariadb-1 mysql -u root -e "DROP DATABASE IF EXISTS testing_test_$i;" 2>/dev/null
done

# Limpiar archivos de checksum
rm -f /home/blockpc/proyectos/blockpc/.phpunit.database.checksum.*

# Limpiar vistas compiladas de workers anteriores
rm -rf /home/blockpc/proyectos/blockpc/storage/framework/views/worker_*

echo "🚀 Ejecutando tests rápidos en paralelo..."
./vendor/bin/sail test --exclude-group=filesystem,slow,integration --parallel --processes=4

echo ""
echo "⏳ Ejecutando tests lentos secuencialmente..."
./vendor/bin/sail test --group=filesystem

echo ""
echo "✅ Limpiando recursos después de tests..."
# Limpiar después de la ejecución
for i in {1..16}; do
    docker exec -it blockpc-mariadb-1 mysql -u root -e "DROP DATABASE IF EXISTS testing_test_$i;" 2>/dev/null
done

rm -f /home/blockpc/proyectos/blockpc/.phpunit.database.checksum.*
rm -rf /home/blockpc/proyectos/blockpc/storage/framework/views/worker_*

echo "🎉 Tests completados y recursos limpiados!"
