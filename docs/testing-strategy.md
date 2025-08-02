# 🧪 Testing Strategy para BlockPC

Este proyecto utiliza una estrategia de testing optimizada para manejar tests que requieren operaciones de filesystem y tests rápidos.

## 📋 **Grupos de Tests**

### ⚡ **Tests Rápidos**
- Todos los tests EXCEPTO los que manipulan archivos
- Se ejecutan en paralelo para máxima velocidad
- Ideal para desarrollo diario y CI/CD

### 🐌 **Tests Lentos (Filesystem)**
- Tests que crean/eliminan directorios y archivos
- Incluyen `CreateModuleCommand` y `DeleteModuleCommand`
- Se ejecutan secuencialmente para evitar conflictos

### 🔄 **Tests de Integración**
- Tests que combinan múltiples comandos
- Se ejecutan secuencialmente

## 🚀 **Comandos de Testing**

### Composer Scripts
```bash
# Tests rápidos en paralelo (recomendado para desarrollo)
composer run test-fast

# Tests lentos secuencialmente
composer run test-slow

# Todos los tests con estrategia optimizada
composer run test-all

# Solo tests de filesystem
composer run test-filesystem

# Tests normales (todo secuencial)
composer run test
```

### Comandos Sail Directos
```bash
# Tests rápidos en paralelo
./vendor/bin/sail test --exclude-group=filesystem,slow,integration -p

# Tests lentos
./vendor/bin/sail test --group=filesystem

# Tests específicos por grupo
./vendor/bin/sail test --group=slow
./vendor/bin/sail test --group=integration

# Todos los tests en paralelo (puede fallar con tests de filesystem)
./vendor/bin/sail test -p
```

## ⚙️ **Configuración de Grupos**

Los tests están organizados en estos grupos:

- `filesystem` - Tests que manipulan archivos/directorios
- `slow` - Tests que tardan mucho tiempo
- `integration` - Tests de integración entre componentes

## 🎯 **Estrategia Recomendada**

### Durante Desarrollo
```bash
# Para cambios rápidos
composer run test-fast

# Para verificar commands completos
composer run test-filesystem
```

### Para CI/CD
```bash
# Ejecutar toda la suite optimizada
composer run test-all
```

### Para Debug
```bash
# Test específico
./vendor/bin/sail test tests/Feature/CreateModuleCommandTest.php

# Test específico con detalles
./vendor/bin/sail test tests/Feature/CreateModuleCommandTest.php --filter="crea un paquete con modelo"
```

## 📊 **Rendimiento**

- **Tests Rápidos**: ~8-10 segundos (116 tests en paralelo)
- **Tests Lentos**: ~16-20 segundos (9 tests secuenciales)
- **Total Optimizado**: ~25-30 segundos
- **Total Secuencial**: ~40-50 segundos

## 🔧 **Agregando Nuevos Tests**

### Tests Rápidos (Default)
```php
it('does something fast', function () {
    // Test code
});
```

### Tests Lentos
```php
it('does something with filesystem', function () {
    // Test code
})->group('filesystem', 'slow');
```

### Tests de Integración
```php
it('integrates multiple components', function () {
    // Test code
})->group('integration', 'slow');
```
