<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TechnicianOwnedServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a service category as a prerequisite for creating services
        ServiceCategory::factory()->create();
    }

    /**
     * Test a technician can create their own service.
     *
     * @return void
     */
    public function test_technician_can_create_an_owned_service()
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $serviceCategory = ServiceCategory::factory()->create();

        Sanctum::actingAs($technician, ['*']);

        $serviceData = [
            'category_id' => $serviceCategory->id,
            'name' => 'Layanan Baru Teknisi',
            'description' => 'Deskripsi layanan yang dibuat oleh teknisi.',
            'price' => 150000,
        ];

        $response = $this->postJson('/api/technician/owned-services', $serviceData);

        $response->assertStatus(201) // HTTP_CREATED
                 ->assertJsonFragment([
                     'name' => 'Layanan Baru Teknisi',
                     'user_id' => $technician->id,
                 ]);

        $this->assertDatabaseHas('services', [
            'name' => 'Layanan Baru Teknisi',
            'user_id' => $technician->id,
        ]);
    }

    /**
     * Test a technician can list their owned services.
     *
     * @return void
     */
    public function test_technician_can_list_their_owned_services()
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $services = Service::factory()->for($technician, 'user')->count(3)->create(); // Services owned by this technician

        Sanctum::actingAs($technician, ['*']);

        $response = $this->getJson('/api/technician/owned-services');

        $response->assertOk()
                 ->assertJsonCount(3)
                 ->assertJson($services->toArray());
    }

    /**
     * Test a technician can view their own service.
     *
     * @return void
     */
    public function test_technician_can_view_their_owned_service()
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $service = Service::factory()->for($technician, 'user')->create();

        Sanctum::actingAs($technician, ['*']);

        $response = $this->getJson('/api/technician/owned-services/' . $service->id);

        $response->assertOk()
                 ->assertJsonFragment(['name' => $service->name]);
    }

    /**
     * Test a technician cannot view another technician's service.
     *
     * @return void
     */
    public function test_technician_cannot_view_another_technicians_service()
    {
        $technician1 = User::factory()->create(['role' => 'teknisi']);
        $technician2 = User::factory()->create(['role' => 'teknisi']);
        $serviceOfTech2 = Service::factory()->for($technician2, 'user')->create();

        Sanctum::actingAs($technician1, ['*']); // Acting as technician1

        $response = $this->getJson('/api/technician/owned-services/' . $serviceOfTech2->id);

        $response->assertForbidden(); // Should be forbidden
    }

    /**
     * Test a technician can update their own service.
     *
     * @return void
     */
    public function test_technician_can_update_their_owned_service()
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $service = Service::factory()->for($technician, 'user')->create();

        Sanctum::actingAs($technician, ['*']);

        $updateData = ['name' => 'Nama Layanan Diperbarui', 'price' => 200000];
        $response = $this->putJson('/api/technician/owned-services/' . $service->id, $updateData);

        $response->assertOk()
                 ->assertJsonFragment(['name' => 'Nama Layanan Diperbarui']);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Nama Layanan Diperbarui',
            'price' => 200000,
        ]);
    }

    /**
     * Test a technician cannot update another technician's service.
     *
     * @return void
     */
    public function test_technician_cannot_update_another_technicians_service()
    {
        $technician1 = User::factory()->create(['role' => 'teknisi']);
        $technician2 = User::factory()->create(['role' => 'teknisi']);
        $serviceOfTech2 = Service::factory()->for($technician2, 'user')->create();

        Sanctum::actingAs($technician1, ['*']); // Acting as technician1

        $updateData = ['name' => 'Attempt to update'];
        $response = $this->putJson('/api/technician/owned-services/' . $serviceOfTech2->id, $updateData);

        $response->assertForbidden();
    }

    /**
     * Test a technician can delete their own service.
     *
     * @return void
     */
    public function test_technician_can_delete_their_owned_service()
    {
        $technician = User::factory()->create(['role' => 'teknisi']);
        $service = Service::factory()->for($technician, 'user')->create();

        Sanctum::actingAs($technician, ['*']);

        $response = $this->deleteJson('/api/technician/owned-services/' . $service->id);

        $response->assertStatus(204); // HTTP_NO_CONTENT
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    /**
     * Test a technician cannot delete another technician's service.
     *
     * @return void
     */
    public function test_technician_cannot_delete_another_technicians_service()
    {
        $technician1 = User::factory()->create(['role' => 'teknisi']);
        $technician2 = User::factory()->create(['role' => 'teknisi']);
        $serviceOfTech2 = Service::factory()->for($technician2, 'user')->create();

        Sanctum::actingAs($technician1, ['*']); // Acting as technician1

        $response = $this->deleteJson('/api/technician/owned-services/' . $serviceOfTech2->id);

        $response->assertForbidden();
        $this->assertDatabaseHas('services', ['id' => $serviceOfTech2->id]); // Ensure it was not deleted
    }

    /**
     * Test a customer can view technicians with their owned services.
     *
     * @return void
     */
    public function test_customer_can_view_technicians_with_their_owned_services()
    {
        $customer = User::factory()->create(['role' => 'pelanggan']);
        $technician1 = User::factory()->create(['role' => 'teknisi']);
        $technician2 = User::factory()->create(['role' => 'teknisi']);

        $service1_tech1 = Service::factory()->for($technician1, 'user')->create();
        $service2_tech1 = Service::factory()->for($technician1, 'user')->create();
        $service1_tech2 = Service::factory()->for($technician2, 'user')->create();

        Sanctum::actingAs($customer, ['*']);

        $response = $this->getJson('/api/customer/technicians');

        $response->assertOk()
                 ->assertJsonCount(2); // Should return 2 technicians

        $response->assertJsonFragment([
            'id' => $technician1->id,
            'role' => 'teknisi',
        ]);
        $response->assertJsonFragment([
            'id' => $service1_tech1->id,
            'name' => $service1_tech1->name,
            'user_id' => $technician1->id, // Ensure user_id is correct
        ]);
        $response->assertJsonFragment([
            'id' => $service2_tech1->id,
            'name' => $service2_tech1->name,
            'user_id' => $technician1->id,
        ]);


        $response->assertJsonFragment([
            'id' => $technician2->id,
            'role' => 'teknisi',
        ]);
        $response->assertJsonFragment([
            'id' => $service1_tech2->id,
            'name' => $service1_tech2->name,
            'user_id' => $technician2->id,
        ]);
    }

    /**
     * Test non-technician cannot manage owned services.
     *
     * @return void
     */
    public function test_non_technician_cannot_manage_owned_services()
    {
        $customer = User::factory()->create(['role' => 'pelanggan']);
        $serviceCategory = ServiceCategory::factory()->create(); // Create service category for testing

        Sanctum::actingAs($customer, ['*']);

        // Attempt to create
        $serviceData = [
            'category_id' => $serviceCategory->id,
            'name' => 'Layanan Non-Teknisi',
            'description' => 'Deskripsi',
            'price' => 10000,
        ];
        $response = $this->postJson('/api/technician/owned-services', $serviceData);
        $response->assertForbidden();

        // Attempt to list
        $response = $this->getJson('/api/technician/owned-services');
        $response->assertForbidden();

        // Attempt to view specific
        $technician = User::factory()->create(['role' => 'teknisi']);
        $serviceOfTech = Service::factory()->for($technician, 'user')->create();
        $response = $this->getJson('/api/technician/owned-services/' . $serviceOfTech->id);
        $response->assertForbidden();

        // Attempt to update
        $response = $this->putJson('/api/technician/owned-services/' . $serviceOfTech->id, ['name' => 'Updated']);
        $response->assertForbidden();

        // Attempt to delete
        $response = $this->deleteJson('/api/technician/owned-services/' . $serviceOfTech->id);
        $response->assertForbidden();
    }

    /**
     * Test unauthenticated user cannot access owned service routes.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_owned_service_routes()
    {
        $serviceCategory = ServiceCategory::factory()->create(); // Create service category for testing

        // Attempt to create
        $serviceData = [
            'category_id' => $serviceCategory->id,
            'name' => 'Layanan Unauth',
            'description' => 'Deskripsi',
            'price' => 10000,
        ];
        $response = $this->postJson('/api/technician/owned-services', $serviceData);
        $response->assertUnauthorized();

        // Attempt to list
        $response = $this->getJson('/api/technician/owned-services');
        $response->assertUnauthorized();

        // Attempt to view specific
        $technician = User::factory()->create(['role' => 'teknisi']);
        $serviceOfTech = Service::factory()->for($technician, 'user')->create();
        $response = $this->getJson('/api/technician/owned-services/' . $serviceOfTech->id);
        $response->assertUnauthorized();

        // Attempt to update
        $response = $this->putJson('/api/technician/owned-services/' . $serviceOfTech->id, ['name' => 'Updated']);
        $response->assertUnauthorized();

        // Attempt to delete
        $response = $this->deleteJson('/api/technician/owned-services/' . $serviceOfTech->id);
        $response->assertUnauthorized();
    }

    /**
     * Test unauthenticated user cannot access customer technician routes.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_customer_technician_routes()
    {
        $response = $this->getJson('/api/customer/technicians');
        $response->assertUnauthorized();
    }
}
