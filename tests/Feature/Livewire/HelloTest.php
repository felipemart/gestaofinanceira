<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Hello;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class HelloTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Hello::class)
            ->assertStatus(200);
    }
}
