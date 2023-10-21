<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Welcome;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Livewire\Livewire;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Welcome::class)
            ->assertStatus(200);
    }
}
