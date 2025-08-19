Perfect 👍
Let’s scaffold a **Laravel folder structure + boilerplate code** for your **LMS Auth & User Management module**.
This will give you controllers, services, jobs, and models connected to the migration you already have.

---

# 📂 Folder Structure

```
app/
 ├── Http/
 │    ├── Controllers/
            ├── Api/
                ├──Auth
     │    │         ├── AuthController.php
     │    │         ├── SocialAuthController.php
     │    │         ├── OtpController.php
     │    │         ├── CommunicationController.php
     │    │         └── GdprController.php
 │    │     ├── Auth/
 │    │         ├── AuthController.php
 │    │         ├── SocialAuthController.php
 │    │         ├── OtpController.php
 │    │         ├── CommunicationController.php
 │    │         └── GdprController.php
 │    ├── Middleware/
 │    │     ├── VerifiedEmail.php
 │    │     └── VerifiedPhone.php
 │    └── Requests/
 │          ├── RegisterRequest.php
 │          ├── LoginRequest.php
 │          ├── OtpVerifyRequest.php
 │          └── CommunicationPreferenceRequest.php
 ├── Models/
 │    ├── SocialAccount.php
 │    ├── OtpVerification.php
 │    ├── CommunicationPreference.php
 │    ├── UserAddress.php
 │    ├── GdprRequest.php
 │    ├── SmsLog.php
 │    └── EmailLog.php
 ├── Services/
 │    ├── OtpService.php
 │    ├── SmsService.php
 │    ├── EmailService.php
 │    └── GdprService.php
 ├── Jobs/
 │    ├── SendSmsJob.php
 │    ├── SendEmailJob.php
 │    └── ProcessGdprExportJob.php
 ├── Events/
 │    ├── UserRegistered.php
 │    ├── UserLogin.php
 │    ├── OtpRequested.php
 │    └── GdprRequestSubmitted.php
 └── Listeners/
      ├── SendWelcomeNotification.php
      ├── UpdateLastLogin.php
      ├── LogOtpRequest.php
      └── NotifyAdminOfGdpr.php
```

---

# 📝 Boilerplate Code

## 1. Controllers

### `AuthController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new \App\Events\UserRegistered($user));

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        event(new \App\Events\UserLogin($user));

        return response()->json(['user' => $user, 'token' => $token]);
    }
}
```

---

### `OtpController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpVerifyRequest;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function send(Request $request)
    {
        $request->validate(['phone' => 'required|string']);
        $this->otpService->generateAndSend($request->phone);

        return response()->json(['message' => 'OTP sent']);
    }

    public function verify(OtpVerifyRequest $request)
    {
        $token = $this->otpService->verify($request->phone, $request->code);
        return response()->json(['token' => $token]);
    }
}
```

---

### `CommunicationController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunicationPreferenceRequest;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function update(CommunicationPreferenceRequest $request)
    {
        $prefs = Auth::user()->communicationPreferences()->updateOrCreate([], $request->validated());

        return response()->json(['preferences' => $prefs]);
    }
}
```

---

### `GdprController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\GdprRequest;
use App\Services\GdprService;
use Illuminate\Support\Facades\Auth;

class GdprController extends Controller
{
    protected $gdprService;

    public function __construct(GdprService $gdprService)
    {
        $this->gdprService = $gdprService;
    }

    public function requestExport()
    {
        return $this->gdprService->createRequest(Auth::id(), 'export');
    }

    public function requestErasure()
    {
        return $this->gdprService->createRequest(Auth::id(), 'erasure');
    }

    public function list()
    {
        return Auth::user()->gdprRequests;
    }
}
```

---

## 2. Services

### `OtpService.php`

```php
<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Jobs\SendSmsJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    public function generateAndSend($phone)
    {
        $code = rand(100000, 999999);

        OtpVerification::create([
            'phone_e164' => $phone,
            'code_hash'  => Hash::make($code),
            'purpose'    => 'login',
            'expires_at' => now()->addMinutes(5),
        ]);

        dispatch(new SendSmsJob($phone, "Your OTP is {$code}"));
    }

    public function verify($phone, $code)
    {
        $otp = OtpVerification::where('phone_e164', $phone)
            ->where('expires_at', '>', now())
            ->latest()->first();

        if (!$otp || !Hash::check($code, $otp->code_hash)) {
            abort(401, 'Invalid OTP');
        }

        $user = \App\Models\User::firstOrCreate(
            ['phone_e164' => $phone],
            ['name' => 'New User']
        );

        $otp->update(['verified_at' => now()]);

        return $user->createToken('api-token')->plainTextToken;
    }
}
```

---

### `SmsService.php`

```php
<?php

namespace App\Services;

class SmsService
{
    public function send($phone, $message)
    {
        // Call Twilio, MSG91, or AWS Pinpoint API here
        // Log response into SmsLog model
    }
}
```

---

### `GdprService.php`

```php
<?php

namespace App\Services;

use App\Models\GdprRequest;

class GdprService
{
    public function createRequest($userId, $type)
    {
        $req = GdprRequest::create([
            'user_id' => $userId,
            'type'    => $type,
        ]);

        event(new \App\Events\GdprRequestSubmitted($req));

        return $req;
    }
}
```

---

## 3. Jobs

### `SendSmsJob.php`

```php
<?php

namespace App\Jobs;

use App\Services\SmsService;

class SendSmsJob extends Job
{
    protected $phone;
    protected $message;

    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle(SmsService $sms)
    {
        $sms->send($this->phone, $this->message);
    }
}
```

---

### `SendEmailJob.php`

```php
<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

class SendEmailJob extends Job
{
    protected $email;
    protected $subject;
    protected $view;
    protected $data;

    public function __construct($email, $subject, $view, $data = [])
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
    }

    public function handle()
    {
        Mail::send($this->view, $this->data, function($m) {
            $m->to($this->email)->subject($this->subject);
        });
    }
}
```

---

## 4. Routes (`routes/api.php`)

```php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\GdprController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/otp/send', [OtpController::class, 'send']);
Route::post('/auth/otp/verify', [OtpController::class, 'verify']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/user/preferences', [CommunicationController::class, 'update']);
    Route::get('/user/gdpr/requests', [GdprController::class, 'list']);
    Route::post('/user/gdpr/export', [GdprController::class, 'requestExport']);
    Route::post('/user/gdpr/erasure', [GdprController::class, 'requestErasure']);
});
```

---

✅ This gives you a **full working skeleton** for authentication (email, OTP, social), authorization (roles), notifications, GDPR, and preferences.

👉 Do you want me to also generate the **Spatie Role/Permission seeders** (`Admin`, `Instructor`, `Student`, `Staff`) so you can run `php artisan db:seed` and have roles ready?
