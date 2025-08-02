#!/bin/bash

# Script para ejecutar tests rápidos en paralelo
echo "🚀 Ejecutando tests rápidos en paralelo..."
./vendor/bin/sail test --exclude-group=filesystem,slow,integration -p

echo ""
echo "⏳ Ejecutando tests lentos secuencialmente..."
./vendor/bin/sail test --group=filesystem
