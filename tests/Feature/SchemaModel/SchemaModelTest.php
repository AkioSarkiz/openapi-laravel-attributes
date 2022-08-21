<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Feature\SchemaModel;

use AkioSarkiz\Openapi\Adapters\SchemaModel;
use AkioSarkiz\Openapi\Tests\Feature\SchemaModel\Models\User;
use AkioSarkiz\Openapi\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

class SchemaModelTest extends TestCase
{
    private function setUpUsersTable()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function test_user(): void
    {
        $this->setUpUsersTable();

        $adapter = new SchemaModel();
        $adapter->init(new ReflectionClass(new User()));

        $this->assertSame($adapter->getPath(), 'components.schemas.User');
        $this->assertSame($adapter->getSchema(), [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'int64',
                ],
                'email' => [
                    'type' => 'string',
                ],
                'password' => [
                    'type' => 'string',
                ],
                'created_at' => [
                    'type' => 'string',
                    'format' => 'date-time',
                ],
                'updated_at' => [
                    'type' => 'string',
                    'format' => 'date-time',
                ],
            ],
        ]);
    }
}
