<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StoreController
 */
final class StoreControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $stores = Store::factory()->count(3)->create();

        $response = $this->get(route('stores.index'));

        $response->assertOk();
        $response->assertViewIs('stores.index');
        $response->assertViewHas('stores');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('stores.create'));

        $response->assertOk();
        $response->assertViewIs('stores.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'store',
            \App\Http\Requests\StoreStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->post(route('stores.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $stores = Store::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $stores);
        $store = $stores->first();

        $response->assertRedirect(route('stores.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $store = Store::factory()->create();

        $response = $this->get(route('stores.show', $store));

        $response->assertOk();
        $response->assertViewIs('stores.show');
        $response->assertViewHas('stores');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $store = Store::factory()->create();

        $response = $this->get(route('stores.edit', $store));

        $response->assertOk();
        $response->assertViewIs('stores.edit');
        $response->assertViewHas('stores');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'update',
            \App\Http\Requests\StoreUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $store = Store::factory()->create();
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->put(route('stores.update', $store), [
            'name' => $name,
            'description' => $description,
        ]);

        $store->refresh();

        $response->assertRedirect(route('stores.show', ['stores' => $stores]));

        $this->assertEquals($name, $store->name);
        $this->assertEquals($description, $store->description);
    }
}
