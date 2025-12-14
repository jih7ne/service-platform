<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TestComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TestComponentTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(TestComponent::class)
            ->assertStatus(200);
    }
}
