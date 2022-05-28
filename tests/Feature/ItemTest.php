<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Department;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_page_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/items');
        $response->assertOk();
    }

    public function test_can_create_new_item()
    {
        $this->actingAs($user = User::factory()->create());
        $department = Department::factory()->create();

        $response = $this->post('/items', [
            'name' => 'Bread',
            'department_id' => $department->id,
        ]);

        $response->assertRedirect('/items');    

        $this->assertDatabaseHas( 'items', [
            'name' => 'Bread',
            'department_id' => $department->id
        ] );
    
    }

    public function test_can_update_item()
    {
        $this->actingAs($user = User::factory()->create());
        $department = Department::factory()->hasItems()->create();

        $response = $this->put('/items/'.$department->items[0]->id, [
            'name' => 'Edited for testing',
            'department_id' => $department->id,
        ]);

        $response->assertRedirect('/items');    
    }

    public function test_can_delete_item()
    {
        $this->actingAs($user = User::factory()->create());
        $department = Department::factory()->hasItems()->create();

        $response = $this->delete('/items/'.$department->items[0]->id);
        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);   
    }
}
