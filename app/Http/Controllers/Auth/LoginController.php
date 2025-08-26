<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function index(Request $request)
    {
        try {
            return view('auth.index');
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    protected function attemptApiLogin($username, $password)
    {
        $url = "https://service.undipa.ac.id/mhs.php?user=" . $username . "&pass=" . $password . "&api=071994";

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            $body = $response->getBody()->getContents();

            // Parse the API response - adjust according to actual API response format
            $data = json_decode($body, true);

            // dd();
            if (isset($data['data'][0]['stb']) && $data['data'][0]['stb'] === $username) {
                return ['success' => true, 'data' => $data];
            }

            return ['success' => false, 'error' => 'invalid'];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function findOrCreateUserFromApi($username, $apiData)
    {
        // Try to find existing user by username or email
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();
        // dd($username);

        if (!$user) {
            // Create new user from API data
            $user = new User();
            $user->username = $username;
            $user->email = $apiData['data'][0]['email'] ?? $username; // Adjust according to API data
            $user->password = Hash::make('password'); // Random password since we don't have it
            $user->name = $apiData['data'][0]['nmmhs'];
            $user->id_role = 3;
            $user->save();
        }

        return $user;
    }

    public function login(Request $request)
    {
        try {
            $login = request()->input('username');
            $password = $request->password;
            $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            if (Auth::attempt([$field => $login, 'password' => $password])) {
                Helper::menu();

                // Redirect based on user role
                $userRole = auth()->user()->id_role;
                // dd($userRole);
                switch ($userRole) {
                    case 1: // Super Admin
                    case 2: // Kaprodi
                        return redirect()->route('admin');
                    case 3: // Mahasiswa
                        return redirect()->route('dashboard');
                    default:
                        return redirect()->route('admin');
                }
            }

            $apiResponse = $this->attemptApiLogin($login, $password);
            // dd($sesi);

            if ($apiResponse['success']) {
                // API authentication succeeded - handle user login/creation
                $user = $this->findOrCreateUserFromApi($login, $apiResponse['data']);

                if ($user) {
                    Auth::login($user);
                    Helper::menu();
                    $this->storeApiDataInSession($apiResponse['data']);
                    return redirect()->route('dashboard');
                }
            }

            return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    protected function storeApiDataInSession($apiData)
    {
        $stb = $apiData['data'][0]['stb'] ?? '';
        $prodi = Helper::getProdiFromNim($stb);
        // dd($prodi);
        Session::put([
            'nama_mhs' => $apiData['data'][0]['nmmhs'] ?? 'Mahasiswa',
            'stb' => $stb,
            'email' => $apiData['data'][0]['email'] ?? '',
            'alamat' => $apiData['data'][0]['alm'] ?? '',
            'prodi' => $prodi,
            'prodi_kode' => substr($stb, 2, 1) ?? '',
            'mahasiswa_data' => $apiData['data'][0] ?? []
        ]);
    }

    public function logout(Request $request)
    {
        // $roles = auth()->user()->id_role;
        $this->guard()->logout();
        $request->session()->invalidate();
        // if ($roles == 3) {
        //     return $this->loggedOut($request) ?: redirect('/login');
        // } else {
        return $this->loggedOut($request) ?: redirect('/auth/login');
        // }
    }
}
