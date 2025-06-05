<?php

namespace Tests\Feature;
use App\Models\Hospitalisation;
use App\Models\Research;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_all_researches()
    {
        $hospitalisation = Hospitalisation::factory()->create();
        $research = Research::factory()->create([
            'status' => 'Zakończone',
            'research_type' => 'laboratoryjne',
        ]);

        $response = $this->get(route('research.index'));

        $response->assertStatus(200);
        $response->assertViewIs('research.research');
        $response->assertViewHas('researches', function ($researches) use ($research) {
            return $researches->contains($research);
        });
    }
    /** @test */
    public function it_displays_the_research_creation_form()
    {
        // Tworzymy hospitalizację z pacjentem
        $hospitalisation = \App\Models\Hospitalisation::factory()->create();

        $response = $this->get(route('research.create'));

        $response->assertStatus(200);
        $response->assertViewIs('research.create');
        $response->assertViewHas('hospitalisations', function ($hospitalisations) use ($hospitalisation) {
            return $hospitalisations->contains($hospitalisation);
        });
    }

    /** @test */
    public function it_stores_a_new_research_record()
    {
        // Tworzymy hospitalizację
        $hospitalisation = \App\Models\Hospitalisation::factory()->create();

        // Dane formularza
        $formData = [
            'hospital_id' => $hospitalisation->id,
            'research_type' => 'laboratoryjne',
            'note' => 'Notatka testowa',
        ];

        // Wysłanie żądania POST
        $response = $this->post(route('research.store'), $formData);

        // Sprawdzenie przekierowania
        $response->assertRedirect(route('research.index'));
        $response->assertSessionHas('success', 'Badanie zostało dodane.');

        // Sprawdzenie, czy rekord istnieje w bazie danych
        $this->assertDatabaseHas('research', [
            'hospital_id' => $hospitalisation->id,
            'research_type' => 'laboratoryjne',
            'note' => 'Notatka testowa',
            'status' => 'W toku',
            'result' => '',
            'date_of_research' => \Carbon\Carbon::now()->toDateString(),
        ]);
    }

    /** @test */
    public function it_displays_the_edit_form_for_a_given_research()
    {
        // Przygotowanie: hospitalizacja + badanie
        $hospitalisation = \App\Models\Hospitalisation::factory()->create();
        $research = \App\Models\Research::factory()->create([
            'hospital_id' => $hospitalisation->id,
        ]);

        // Wywołanie widoku
        $response = $this->get(route('research.edit', $research->id));

        // Sprawdzenie poprawności odpowiedzi i widoku
        $response->assertStatus(200);
        $response->assertViewIs('research.edit');
        $response->assertViewHasAll([
            'research',
            'hospitalisations',
        ]);

        // Upewniamy się, że dane są widoczne
        $response->assertSee($research->note);
    }
    /** @test */
    public function it_updates_the_research_successfully()
    {
        // Przygotowanie: hospitalizacja i powiązane badanie
        $hospitalisation = \App\Models\Hospitalisation::factory()->create();
        $research = \App\Models\Research::factory()->create([
            'hospital_id' => $hospitalisation->id,
            'research_type' => 'radiologiczne',
            'note' => 'Stara notatka',
        ]);

        // Nowa hospitalizacja do zmiany (opcjonalna)
        $newHospitalisation = \App\Models\Hospitalisation::factory()->create();

        // Dane aktualizacyjne
        $updatedData = [
            'hospital_id' => $newHospitalisation->id,
            'research_type' => 'laboratoryjne',
            'note' => 'Zmieniona notatka',
        ];

        // Wysłanie PATCH/PUT żądania
        $response = $this->put(route('research.update', $research->id), $updatedData);

        // Oczekiwane przekierowanie z komunikatem
        $response->assertRedirect(route('research.index'));
        $response->assertSessionHas('success', 'Badanie zostało zaktualizowane.');

        // Sprawdzenie danych w bazie
        $this->assertDatabaseHas('research', [
            'id' => $research->id,
            'hospital_id' => $newHospitalisation->id,
            'research_type' => 'laboratoryjne',
            'note' => 'Zmieniona notatka',
        ]);
    }
    /** @test */
    public function it_deletes_the_research()
    {
        $research = \App\Models\Research::factory()->create();

        $response = $this->delete(route('research.destroy', $research->id));

        $response->assertRedirect(route('research.index'));
        $response->assertSessionHas('success', 'Badanie zostało usunięte.');
        $this->assertDatabaseMissing('research', ['id' => $research->id]);
    }
    /** @test */
    public function it_shows_the_complete_form()
    {
        $research = \App\Models\Research::factory()->create();

        $response = $this->get(route('research.complete.form', $research->id));

        $response->assertStatus(200);
        $response->assertViewIs('research.complete');
        $response->assertViewHas('research', function ($viewResearch) use ($research) {
            return $viewResearch->id === $research->id;
        });
    }
    /** @test */
    public function it_marks_the_research_as_completed_with_result()
    {
        $research = \App\Models\Research::factory()->create([
            'status' => 'W toku',
            'result' => '',
        ]);

        $data = [
            'result' => 'Wynik badania pozytywny',
        ];

        $response = $this->post(route('research.complete', $research->id), $data);

        $response->assertRedirect(route('research.index'));
        $response->assertSessionHas('success', 'Badanie zostało zakończone.');

        $this->assertDatabaseHas('research', [
            'id' => $research->id,
            'result' => 'Wynik badania pozytywny',
            'status' => 'Zakończone',
        ]);
    }
    /** @test */
    public function it_marks_the_research_as_canceled()
    {
        $research = \App\Models\Research::factory()->create([
            'status' => 'W toku',
        ]);

        $response = $this->patch(route('research.cancel', $research->id));

        $response->assertRedirect(route('research.index'));
        $response->assertSessionHas('success', 'Badanie zostało anulowane.');

        $this->assertDatabaseHas('research', [
            'id' => $research->id,
            'status' => 'Anulowane',
        ]);
    }

}
