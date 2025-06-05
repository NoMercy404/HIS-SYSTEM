<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visit;
use App\Models\Patients;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class VisitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_view_is_rendered_with_patients_and_doctors()
{
    $doctor = User::factory()->create(['role' => 'lekarz', 'last_name' => 'Kowalski']);
    $patient = \App\Models\Patients::factory()->create(['last_name' => 'Nowak']);

    $response = $this->actingAs($doctor)->get(route('visits.create'));

    $response->assertStatus(200);
    $response->assertViewIs('visits.create');
    $response->assertViewHasAll(['patients', 'doctors']);
    $response->assertSee($doctor->last_name);
    $response->assertSee($patient->last_name);
}

    public function test_visit_can_be_stored_successfully()
    {
        $doctor = User::factory()->create(['role' => 'lekarz']);
        $patient = Patients::factory()->create();

        $response = $this->actingAs($doctor)->post(route('visits.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'visit_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'visit_room' => '101A',
            'visit_note' => 'Kontrola po zabiegu',
        ]);

        $response->assertRedirect(route('visits.index'));
        $response->assertSessionHas('success', 'Wizyta została dodana.');

        $this->assertDatabaseHas('visits', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'visit_room' => '101A',
            'visit_note' => 'Kontrola po zabiegu',
        ]);
    }

    public function test_edit_view_is_displayed_for_existing_visit()
    {
        $doctor = User::factory()->create(['role' => 'lekarz']);
        $patient = Patients::factory()->create();

        $visit = Visit::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ]);

        $this->actingAs($doctor)
            ->get(route('visits.edit', $visit->id))
            ->assertStatus(200)
            ->assertViewIs('visits.edit')
            ->assertViewHasAll(['visit', 'doctors', 'patients']);
    }

    public function test_visit_can_be_updated()
    {
        $doctor = User::factory()->create(['role' => 'lekarz']);
        $patient = Patients::factory()->create();

        $visit = Visit::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ]);

        $newData = [
            'visit_date' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'visit_room' => '123B',
            'visit_note' => 'Zmieniona uwaga',
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ];

        $this->actingAs($doctor)
            ->put(route('visits.update', $visit->id), $newData)
            ->assertRedirect(route('visits.index'))
            ->assertSessionHas('success', 'Wizyta została zaktualizowana.');

        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'visit_room' => '123B',
            'visit_note' => 'Zmieniona uwaga',
        ]);
    }

    public function test_visit_update_fails_with_past_date()
    {
        $doctor = User::factory()->create(['role' => 'lekarz']);
        $patient = Patients::factory()->create();

        $visit = Visit::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ]);

        $invalidData = [
            'visit_date' => now()->subDays(1)->format('Y-m-d H:i:s'), // przeszłość
            'visit_room' => '100',
            'visit_note' => null,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ];

        $response = $this->actingAs($doctor)
            ->from(route('visits.edit', $visit->id))
            ->put(route('visits.update', $visit->id), $invalidData);

        $response->assertRedirect(route('visits.edit', $visit->id));
        $response->assertSessionHasErrors('visit_date');

        $this->assertDatabaseMissing('visits', [
            'id' => $visit->id,
            'visit_date' => $invalidData['visit_date'],
        ]);
    }
    public function test_visit_can_be_deleted()
    {
        // Przygotowanie: lekarz, pacjent i wizyta
        $doctor = User::factory()->create(['role' => 'lekarz']);
        $patient = Patients::factory()->create();

        $visit = Visit::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
        ]);

        // Użytkownik musi być zalogowany (np. lekarz)
        $this->actingAs($doctor);

        // Wysyłamy żądanie DELETE
        $response = $this->delete(route('visits.destroy', $visit->id));

        // Sprawdzamy przekierowanie
        $response->assertRedirect(route('visits.index'));
        $response->assertSessionHas('success', 'Wizyta została anulowana.');

        // Sprawdzamy, że wizyty nie ma już w bazie
        $this->assertDatabaseMissing('visits', [
            'id' => $visit->id,
        ]);
    }

    public function test_visit_can_be_rescheduled()
    {
        // Utworzenie pacjenta i lekarza
        $patient = Patients::factory()->create();
        $doctor = User::factory()->create(['role' => 'lekarz']);

        // Tworzymy wizytę
        $visit = Visit::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'visit_date' => now()->addDays(3),
        ]);

        // Ustawiamy nową datę (w przyszłości)
        $newDate = Carbon::now()->addDays(10)->format('Y-m-d H:i:s');

        // Wysyłamy żądanie jako zalogowany użytkownik (lekarz)
        $this->actingAs($doctor);

        $response = $this->put(route('visits.reschedule', $visit->id), [
            'visit_date' => $newDate,
        ]);

        // Oczekujemy przekierowania i sukcesu
        $response->assertRedirect(route('visits.index'));
        $response->assertSessionHas('success', 'Termin wizyty został zmieniony.');

        // Sprawdzamy, czy data została zmieniona w bazie
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'visit_date' => $newDate,
        ]);
    }


}
