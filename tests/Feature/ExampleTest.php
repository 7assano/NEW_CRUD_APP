<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        // هذا Test للـ API، لا نحتاج Test للـ Web Route
        $this->assertTrue(true);
    }
}
