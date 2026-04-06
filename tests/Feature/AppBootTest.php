<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppBootTest extends TestCase
{
    public function test_the_application_can_boot_correctly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
