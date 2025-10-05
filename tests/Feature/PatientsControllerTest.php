<?php

namespace Tests\Feature;

use App\Models\Patients;
use App\Models\Hospitalisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_patients_index()
    {
        Patients::factory()->count(3)->create();

        $response = $this->get(route('patients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('patients');
        $response->assertViewHas('patients');
    }

    /** @test */
    public function it_filters_patients_by_search()
    {
        Patients::factory()->create(['last_name' => 'Kowalski']);
        Patients::factory()->create(['last_name' => 'Nowak']);

        $response = $this->get(route('patients.index', ['search' => 'Kowalski']));

        $response->assertSee('Kowalski');
        $response->assertDontSee('Nowak');
    }

    /** @test */
    public function it_stores_a_patient_and_creates_hospitalisation_if_on_ward()
    {
        $data = [
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'PESEL' => '12345678901',
            'DateOfBirth' => '1990-01-01',
            'phoneNumber' => '123456789',
            'adress' => 'ul. Przykładowa 1',
            'is_on_ward' => true,
        ];

        $response = $this->post(route('patients.store'), $data);

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', [
            'first_name' => 'Jan',
            'is_on_ward' => 1,
        ]);
        $this->assertDatabaseCount('hospitalisations', 1);
    }

    /** @test */
    public function it_updates_a_patient_and_creates_or_discharge_hospitalisation()
    {
        $patient = Patients::factory()->create(['is_on_ward' => false]);

        $data = [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'PESEL' => $patient->PESEL,
            'DateOfBirth' => $patient->DateOfBirth->format('Y-m-d'),
            'is_on_ward' => true,
        ];

        // Przyjęcie pacjenta
        $response = $this->put(route('patients.update', $patient), $data);

        $response->assertRedirect(route('patients.index'));

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'first_name' => 'Anna',
            'is_on_ward' => true,
        ]);

        $this->assertDatabaseCount('hospitalisations', 1);
        $this->assertDatabaseHas('hospitalisations', [
            'patient_id' => $patient->id,
            'discharge_date' => null,
        ]);

        // Wypisanie pacjenta
        $response = $this->put(route('patients.update', $patient), array_merge($data, ['is_on_ward' => false]));

        $response->assertRedirect(route('patients.index'));

        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'is_on_ward' => false,
        ]);

        $this->assertDatabaseHas('hospitalisations', [
            'patient_id' => $patient->id,
        ]);

        $this->assertDatabaseMissing('hospitalisations', [
            'patient_id' => $patient->id,
            'discharge_date' => null,
        ]);
    }



    /** @test */
    public function it_deletes_a_patient()
    {
        $patient = Patients::factory()->create();

        $response = $this->delete(route('patients.destroy', $patient));

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }

    /** @test */
    public function it_shows_patient_history()
    {
        $patient = Patients::factory()->create();

        $response = $this->get(route('patients.history', $patient->id));

        $response->assertStatus(200);
        $response->assertViewIs('patients.history');
        $response->assertViewHas('patient');
    }
}
