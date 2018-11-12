<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailVerificationTest extends TestCase {
    use RefreshDatabase;

    protected $verificationVerifyRouteName = 'verification.verify';

    protected function successfulVerificationRoute() {
        return route('home');
    }

    protected function verificationNoticeRoute() {
        return route('verification.notice');
    }

    protected function validVerificationVerifyRoute($id) {
        return URL::signedRoute($this->verificationVerifyRouteName, ['id' => $id]);
    }

    protected function invalidVerificationVerifyRoute($id) {
        return route($this->verificationVerifyRouteName, ['id' => $id]) . '?signature=invalid-signature';
    }

    protected function verificationResendRoute() {
        return route('verification.resend');
    }

    protected function loginRoute() {
        return route('login');
    }

    /** @test */
    function guest_cannot_see_the_verification_notice() {
        $response = $this->get($this->verificationNoticeRoute());

        $response->assertRedirect($this->loginRoute());
    }

    /** @test */
    function user_sees_the_verification_notice_when_not_verified() {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get($this->verificationNoticeRoute());

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify');
    }

    /** @test */
    function verified_user_is_redirected_home_when_visiting_verification_notice_route() {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get($this->verificationNoticeRoute());

        $response->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    function guest_cannot_see_the_verification_verify_route() {
        factory(User::class)->create([
            'id' => 1,
            'email_verified_at' => null,
        ]);

        $response = $this->get($this->validVerificationVerifyRoute(1));

        $response->assertRedirect($this->loginRoute());
    }

    /** @test */
    function user_cannot_verify_others() {
        $user = factory(User::class)->create([
            'id' => 1,
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get($this->validVerificationVerifyRoute(2));

        $response->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    function user_is_redirected_to_correct_route_when_already_verified() {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get($this->validVerificationVerifyRoute($user->id));

        $response->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    function forbidden_is_returned_when_signature_is_invalid_in_verification_verfy_route() {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get($this->invalidVerificationVerifyRoute($user->id));

        $response->assertStatus(403);
    }

    /** @test */
    function user_can_verify_themselves() {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get($this->validVerificationVerifyRoute($user->id));

        $response->assertRedirect($this->successfulVerificationRoute());
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test */
    function guest_cannot_resend_a_verification_email() {
        $response = $this->get($this->verificationResendRoute());

        $response->assertRedirect($this->loginRoute());
    }

    /** @test */
    function user_is_redirected_to_correct_route_if_already_verified() {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get($this->verificationResendRoute());

        $response->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    function user_can_resend_a_verification_email() {
        Notification::fake();
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->from($this->verificationNoticeRoute())
            ->get($this->verificationResendRoute());

        Notification::assertSentTo($user, VerifyEmail::class);
        $response->assertRedirect($this->verificationNoticeRoute());
    }
}
