<?php

namespace Tests\Feature;

use App\Models\Note;
use Database\Factories\NoteFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_Create_notes()
    {
        $this->withoutExceptionHandling();
        $note=Note::factory()->create();

        $response = $this->postJson('/api/notes',$note->toArray());

        $response->assertStatus(201)
            ->assertJson(["message"=>"Note Saved"]);
        $this->assertDatabaseHas('notes',[
            'name'=>$note["name"]
        ]);
    }
    public function test_a_user_can_not_reate_notes_when_content_is_null()
    {
        $this->withoutExceptionHandling();

        $note=Note::factory()->create(['content'=>'']);

        $response = $this->postJson('/api/notes',$note->toArray())
            ->assertJsonValidationErrorFor('content')
            ->assertStatus(422);
    }
    public function test_a_user_can_not_reate_notes_when_name_is_null()
    {
        $this->withoutExceptionHandling();

        $note=Note::factory()->create(['name'=>'']);

        $response = $this->postJson('/api/notes',$note->toArray())
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);
    }
    public function test_a_user_can_not_reate_notes_when_email_is_null()
    {
        $this->withoutExceptionHandling();

        $note=Note::factory()->create(['email'=>'']);

        $response = $this->postJson('/api/notes',$note->toArray())
            ->assertJsonValidationErrorFor('email')
            ->assertStatus(422);
    }

    public function test_a_user_can_list_all_notes(){
        $this->withoutExceptionHandling();
        $note1=Note::factory()->create();
        $note2=Note::factory()->create();

        $this->get('/api/notes')
            ->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'name'=>$note1["name"],
                'email'=>$note1['email'],
                'tel'=>$note1["tel"]
            ]);
    }

    public function test_a_user_can_get_one_note(){
        $this->withoutExceptionHandling();
        $note1=Note::factory()->create();

        $this->get("/api/notes/".$note1["id"])
            ->assertStatus(200)
            ->assertJsonFragment($note1->toArray());

    }

    public function test_a_user_will_return_empty_when_note_does_not_exist(){
        $this->withoutExceptionHandling();
        $note1=Note::factory()->create();
        $this->get("/api/notes/12")
            ->assertStatus(200)
            ->assertJsonMissing([])
            ->assertExactJson([]);
    }

    public function test_a_user_can_update_note(){
        $this->withoutExceptionHandling();
        $note=Note::factory()->create();
        $this->assertSame($note["name"], "fofe");
        $note["name"]="ainix";
        $this->put(uri: '/api/notes/'.$note['id'],data: $note->toArray())
            ->assertStatus(200)
            ->assertJson(["message"=>"updated ok"]);
        $updatedNote=Note::find($note['id']);
        $this->assertSame($updatedNote["name"],"ainix");

    }

    public function test_a_user_can_not_update_note_when_content_is_null(){
        $this->withoutExceptionHandling();
        $note=Note::factory()->create();
        $this->assertSame($note["name"], "fofe");
        $note["name"]="ainix";
        $note["content"]="";
        $this->put(uri: '/api/notes/'.$note['id'],data: $note->toArray())
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('content');
    }
    public function test_a_user_can_not_update_note_when_name_is_null(){
        $this->withoutExceptionHandling();
        $note=Note::factory()->create();
        $this->assertSame($note["name"], "fofe");
        $note["name"]="";
        $note["content"]="fdfdf";
        $this->put(uri: '/api/notes/'.$note['id'],data: $note->toArray())
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name');
    }


}
