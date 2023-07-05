<?php

namespace Tests\Feature;

use App\Core\Domain\Category\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryEntityBasicTest(): void
    {
        $result = true;
        $reflector = new \ReflectionClass(Category::class);
        $oCategory = new Category();

        $properties = [];

        // Llamamos a todos los setters y nos guardamos el valor pasado
        foreach ($reflector->getMethods() as $metodo) {
            $nombreMetodo = $metodo->getName();
            if (strpos($nombreMetodo, 'set') === 0) {
                // Llamar al método set con un valor de ejemplo
                $params = $metodo->getParameters();
                $tipo = ltrim((string) $params[0]->getType(), '?');

                $valor = match ($tipo) {
                    'int' => 123,
                    'float' => 1.23,
                    'string' => 'ejemplo',
                    'bool' => true,
                    'array' => ['a', 'b', 'c'],
                    'DateTime' => new \DateTime(),
                    default => null,
                };
                $metodo->invoke($oCategory, $valor);

                // Almacenar el valor asignado
                $properties[substr($nombreMetodo, 3)] = $valor;
            }
        }

        // Llamamos a todos los getters y comprobamos si devuelven el valor que habíamos asignado
        foreach ($reflector->getMethods() as $metodo) {
            $nombreMetodo = $metodo->getName();
            if ($nombreMetodo === 'getId') {
                continue;
            }
            if (strpos($nombreMetodo, 'get') === 0) {
                // Llamar al método get
                $valor = $metodo->invoke($oCategory);

                // Comprobar si el valor devuelto es igual al valor asignado
                $key = substr($nombreMetodo, 3);
                $this->assertArrayHasKey($key, $properties);
                $this->assertSame($properties[$key], $valor);
            }
        }
    }

    public function testEloquentCategoryRepositoryGetAllCategories(): void
    {
        $categoryRepository = app(\App\Core\Infrastructure\CategoryRepositoryInterface::class);
        $categories = $categoryRepository->getAllCategories();

        $this->assertNotEmpty($categories);
        $this->assertIsIterable($categories);
        $this->assertContainsOnlyInstancesOf(Category::class, $categories);
        $this->assertCount(13, $categories);
    }

    public function testEloquentCategoryRepositoryGetCategoryById(): void
    {
        $categoryRepository = app(\App\Core\Infrastructure\CategoryRepositoryInterface::class);
        $category = $categoryRepository->getCategoryById(1);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame(1, $category->getId());
    }

    public function testEloquentCategoryRepositorySave(): void
    {
        $name = 'nombre';

        $oCategory = new Category();
        $oCategory->setName($name);

        $categoryRepository = app(\App\Core\Infrastructure\CategoryRepositoryInterface::class);
        $categoryRepository->saveCategory($oCategory);

        $this->assertDatabaseHas('categories', [
            'id' => 14,
            'name' => $name,
        ]);
    }

    public function testEloquentCategoryRepositoryDelete(): void
    {
        $categoryRepository = app(\App\Core\Infrastructure\CategoryRepositoryInterface::class);
        $categoryRepository->deleteCategory(1);

        $this->assertDatabaseMissing('categories', [
            'id' => 1,
        ]);
    }
}
