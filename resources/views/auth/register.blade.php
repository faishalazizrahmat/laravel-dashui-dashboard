@extends('layouts.auth')

@section('content')
<div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0 min-vh-100">
      <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <!-- Card -->
        <div class="card smooth-shadow-md">
          <!-- Card body -->
          <div class="card-body p-6">
            <div class="mb-4">
              <a href="">@include('layouts.partials.admin.logo')</a>
              <p class="mb-6">Please enter your user information.</p>
            </div>
            <!-- Form -->
            <!-- resources/views/auth/register.blade.php -->
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <!-- Full Name -->
              <div class="mb-3">
                  <label for="name" class="form-label">{{ __('Full Name') }}</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <!-- Place of Birth -->
              <div class="mb-3">
                <label for="place_of_birth" class="form-label">{{ __('Place of Birth') }}</label>
                <input id="place_of_birth" type="text" class="form-control @error('place_of_birth') is-invalid @enderror" name="place_of_birth" value="{{ old('place_of_birth') }}" autocomplete="place_of_birth">
                @error('place_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <!-- Date of Birth -->
              <div class="mb-3">
                <label for="date_of_birth" class="form-label">{{ __('Date of Birth') }}</label>
                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="date_of_birth">
                @error('date_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <!-- Username -->
              <div class="mb-3">
                  <label for="username" class="form-label">{{ __('Username') }}</label>
                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">
                  @error('username')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <!-- Email -->
              <div class="mb-3">
                  <label for="email" class="form-label">{{ __('Email') }}</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <!-- Password -->
              <div class="mb-3">
                  <label for="password" class="form-label">{{ __('Password') }}</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <!-- Role -->
              <div class="mb-3">
                <label for="role" class="form-label">{{ __('Role') }}</label>
                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                    <option value="" selected disabled>Select Role</option>
                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Doctor</option>
                    <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Patient</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <!-- Specialization for Doctor (Visible only if the doctor role is selected) -->
              <div id="doctorFields" style="display: none;">
                  <div class="mb-3">
                      <label for="specialization" class="form-label">{{ __('Specialization') }}</label>
                      <input id="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror" name="specialization" value="{{ old('specialization') }}">
                      @error('specialization')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>

                  <!-- PIN for Doctor -->
                  <div class="mb-3">
                      <label for="pin" class="form-label">{{ __('Registration PIN') }}</label>
                      <input id="pin" type="password" class="form-control @error('pin') is-invalid @enderror" name="pin">
                      @error('pin')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <!-- Pilihan Dokter -->
                <div class="mb-3" id="doctor-selection" style="display: none;">
                    <label for="doctor_id" class="form-label">{{ __('Choose your doctor: ') }}</label>
                    <select id="doctor_id" name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                        <option value="" selected disabled>-- Your Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


              <!-- Disease for Patient (Visible only if the patient role is selected) -->
              <div id="patientFields" style="display: none;">
                  <div class="mb-3">
                      <label for="disease" class="form-label">{{ __('Disease') }}</label>
                      <input id="disease" type="text" class="form-control @error('disease') is-invalid @enderror" name="disease" value="{{ old('disease') }}">
                      @error('disease')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <!-- Button -->
              <div class="d-grid">
                  <button type="submit" class="btn btn-primary">
                      {{ __('Register') }}
                  </button>
              </div>
              <div class="d-md-flex justify-content-between mt-4">
                <div class="mb-2 mb-md-0">
                  <a href="{{ route('login') }}" class="fs-5">Already a member? Login</a>
                </div>
                <div>
                  <a href="forget-password.html" class="text-inherit fs-5">Forgot your password?</a>
                </div>
              </div>
            </form>

            <script>
              document.getElementById('role').addEventListener('change', function() {
                  const role = this.value;
                  document.getElementById('doctorFields').style.display = role === '1' ? 'block' : 'none';
                  document.getElementById('patientFields').style.display = role === '0' ? 'block' : 'none';
                  var doctorSelection = document.getElementById('doctor-selection');
                  doctorSelection.style.display = (role === '0') ? 'block' : 'none';
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
