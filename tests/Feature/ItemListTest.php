<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ItemList;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_page_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->create());
        $response = $this->get('/lists');
        $response->assertOk();
    }

    public function test_can_create_new_item_list()
    {
        $this->actingAs($user = User::factory()->create());
        $item = Item::factory()->create();

        $response = $this->post('/lists', [
            'quantity' => 2,
            'item_id' => $item->id,
        ]);

        $response->assertExactJson(['success' => true]);
    }


    public function test_can_update_item_list()
    {
        $this->actingAs($user = User::factory()->create());
        $item = Item::factory()->create();
        $itemList = ItemList::factory()->create();
        
        $response = $this->put('/lists/'.$itemList->id, [
            'quantity' => 200,
            'purchased' => true,
        ]);

        $response->assertExactJson(['success' => true]);
    }

}
