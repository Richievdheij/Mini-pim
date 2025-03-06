<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Run it with: php artisan test --filter=SecurityTest
class SecurityTest extends TestCase
{
    use WithoutMiddleware, WithFaker;

    // Test to check if XSS attacks are properly blocked
    public function test_xss_attack_prevention(): void
    {
        // Step 1: Prepare the malicious XSS payload
        $xssPayload = '<script>alert("XSS Test")</script>'; // Payload injection

        // Step 2: Mock the HTTP request and response
        $response = $this->post('/product', [
            'name' => $xssPayload, // Injecting XSS in the name field
            'price' => 100, // A regular field to simulate a product creation
        ]);

        // Step 3: Assert that the injected script is NOT present in the response (XSS is blocked)
        $response->assertSessionHasNoErrors();  // Ensure no form errors
        $this->assertStringNotContainsString('<script>', $response->getContent());  // Assert the script tag is not in the response
    }
}
