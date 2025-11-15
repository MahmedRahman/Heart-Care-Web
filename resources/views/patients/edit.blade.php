@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Edit Patient</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <a href="{{ route('patients.index') }}" class="mdc-button mdc-button--outlined">
            Back to List
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('patients.update', $patient) }}" method="POST" class="form" id="patient-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Profile Image</h3>
            @if($patient->profile_image)
                <div class="current-image">
                    <label class="form-label">Current Image</label>
                    <img src="{{ Storage::url($patient->profile_image) }}" alt="{{ $patient->full_name }}" class="current-image-preview">
                </div>
            @endif
            <div class="form-group">
                <label for="profile_image" class="form-label">Change Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="form-file" accept="image/*">
                <p class="form-hint">Upload a new profile image (JPEG, PNG, JPG, GIF - Max: 2MB). Leave empty to keep current image.</p>
                @error('profile_image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <div id="image-preview" class="image-preview" style="display: none;">
                    <img id="preview-img" src="" alt="Preview">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Personal Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name', $patient->first_name) }}" required>
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name <span class="required">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name', $patient->last_name) }}" required>
                    @error('last_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-input" value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}">
                    @error('date_of_birth')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select select2-single">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" id="age" name="age" class="form-input" value="{{ old('age', $patient->age) }}" min="0" max="150">
                    @error('age')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="race" class="form-label">Race</label>
                    <select id="race" name="race" class="form-select select2-single">
                        <option value="">Select Race</option>
                        <option value="african" {{ old('race', $patient->race) == 'african' ? 'selected' : '' }}>African</option>
                        <option value="asian" {{ old('race', $patient->race) == 'asian' ? 'selected' : '' }}>Asian</option>
                        <option value="caucasian" {{ old('race', $patient->race) == 'caucasian' ? 'selected' : '' }}>Caucasian</option>
                        <option value="hispanic" {{ old('race', $patient->race) == 'hispanic' ? 'selected' : '' }}>Hispanic</option>
                        <option value="native_american" {{ old('race', $patient->race) == 'native_american' ? 'selected' : '' }}>Native American</option>
                        <option value="pacific_islander" {{ old('race', $patient->race) == 'pacific_islander' ? 'selected' : '' }}>Pacific Islander</option>
                        <option value="other" {{ old('race', $patient->race) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('race')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="marital_state" class="form-label">Marital State</label>
                    <select id="marital_state" name="marital_state" class="form-select select2-single">
                        <option value="">Select Marital State</option>
                        <option value="single" {{ old('marital_state', $patient->marital_state) == 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ old('marital_state', $patient->marital_state) == 'married' ? 'selected' : '' }}>Married</option>
                        <option value="divorced" {{ old('marital_state', $patient->marital_state) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="widowed" {{ old('marital_state', $patient->marital_state) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="separated" {{ old('marital_state', $patient->marital_state) == 'separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                    @error('marital_state')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="language" class="form-label">Language</label>
                    <select id="language" name="language" class="form-select select2-single">
                        <option value="">Select Language</option>
                        <option value="english" {{ old('language', $patient->language) == 'english' ? 'selected' : '' }}>English</option>
                        <option value="arabic" {{ old('language', $patient->language) == 'arabic' ? 'selected' : '' }}>Arabic</option>
                        <option value="spanish" {{ old('language', $patient->language) == 'spanish' ? 'selected' : '' }}>Spanish</option>
                        <option value="french" {{ old('language', $patient->language) == 'french' ? 'selected' : '' }}>French</option>
                        <option value="german" {{ old('language', $patient->language) == 'german' ? 'selected' : '' }}>German</option>
                        <option value="chinese" {{ old('language', $patient->language) == 'chinese' ? 'selected' : '' }}>Chinese</option>
                        <option value="other" {{ old('language', $patient->language) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('language')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Contact Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="mobile_number" class="form-label">Mobile Number <span class="required">*</span></label>
                    <input type="text" id="mobile_number" name="mobile_number" class="form-input" value="{{ old('mobile_number', $patient->mobile_number) }}" required>
                    @error('mobile_number')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $patient->email) }}" required>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Address Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="country" class="form-label">Country</label>
                    <select id="country" name="country" class="form-select select2-single">
                        <option value="">Select Country</option>
                        <option value="United States" {{ old('country', $patient->country) == 'United States' ? 'selected' : '' }}>United States</option>
                        <option value="United Kingdom" {{ old('country', $patient->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="Canada" {{ old('country', $patient->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                        <option value="Egypt" {{ old('country', $patient->country) == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                        <option value="Saudi Arabia" {{ old('country', $patient->country) == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                        <option value="UAE" {{ old('country', $patient->country) == 'UAE' ? 'selected' : '' }}>UAE</option>
                        <option value="Other" {{ old('country', $patient->country) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('country')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">City</label>
                    <select id="city" name="city" class="form-select select2-single">
                        <option value="">Select City</option>
                        @php
                            $selectedCountry = old('country', $patient->country);
                            if ($selectedCountry) {
                                $citiesJson = file_get_contents(public_path('json/countries-cities.json'));
                                $citiesData = json_decode($citiesJson, true);
                                $cities = $citiesData[$selectedCountry] ?? [];
                                foreach($cities as $city) {
                                    $selected = old('city', $patient->city) == $city ? 'selected' : '';
                                    echo "<option value=\"{$city}\" {$selected}>{$city}</option>";
                                }
                            }
                        @endphp
                    </select>
                    @error('city')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="address_area" class="form-label">Address Area</label>
                    <input type="text" id="address_area" name="address_area" class="form-input" value="{{ old('address_area', $patient->address_area) }}">
                    @error('address_area')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address_street" class="form-label">Address Street</label>
                    <input type="text" id="address_street" name="address_street" class="form-input" value="{{ old('address_street', $patient->address_street) }}">
                    @error('address_street')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Physical Measurements</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" class="form-input" value="{{ old('weight', $patient->weight) }}" step="0.01" min="0" max="500">
                    @error('weight')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" id="height" name="height" class="form-input" value="{{ old('height', $patient->height) }}" step="0.01" min="0" max="300">
                    @error('height')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bsa" class="form-label">BSA (Body Surface Area)</label>
                    <input type="number" id="bsa" name="bsa" class="form-input" value="{{ old('bsa', $patient->bsa) }}" step="0.01" min="0">
                    @error('bsa')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bmi" class="form-label">BMI (Body Mass Index)</label>
                    <input type="number" id="bmi" name="bmi" class="form-input" value="{{ old('bmi', $patient->bmi) }}" step="0.01" min="0" max="100">
                    @error('bmi')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Health Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="primary_diagnosis" class="form-label">Primary Diagnosis</label>
                    <select id="primary_diagnosis" name="primary_diagnosis" class="form-select select2-single">
                        <option value="">Select Primary Diagnosis</option>
                        @foreach($primaryDiagnoses as $diagnosis)
                            <option value="{{ $diagnosis->name }}" {{ old('primary_diagnosis', $patient->primary_diagnosis) == $diagnosis->name ? 'selected' : '' }}>{{ $diagnosis->name }}</option>
                        @endforeach
                    </select>
                    <p class="form-hint"><a href="{{ route('diagnoses.create') }}" target="_blank">Add new diagnosis</a></p>
                    @error('primary_diagnosis')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="secondary_diagnosis" class="form-label">Secondary Diagnosis</label>
                    <select id="secondary_diagnosis" name="secondary_diagnosis[]" class="form-select select2-multiple" multiple>
                        @php
                            $secondaryDiagnosis = old('secondary_diagnosis', $patient->secondary_diagnosis ?? []);
                            if (!is_array($secondaryDiagnosis)) {
                                $secondaryDiagnosis = [];
                            }
                        @endphp
                        @foreach($secondaryDiagnoses as $diagnosis)
                            <option value="{{ $diagnosis->name }}" {{ in_array($diagnosis->name, $secondaryDiagnosis) ? 'selected' : '' }}>{{ $diagnosis->name }}</option>
                        @endforeach
                    </select>
                    <p class="form-hint"><a href="{{ route('diagnoses.create') }}" target="_blank" tabindex="-1">Add new diagnosis</a></p>
                    @error('secondary_diagnosis')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tertiary_diagnosis" class="form-label">Tertiary Diagnosis</label>
                    <select id="tertiary_diagnosis" name="tertiary_diagnosis[]" class="form-select select2-multiple" multiple>
                        @php
                            $tertiaryDiagnosis = old('tertiary_diagnosis', $patient->tertiary_diagnosis ?? []);
                            if (!is_array($tertiaryDiagnosis)) {
                                $tertiaryDiagnosis = [];
                            }
                        @endphp
                        @foreach($tertiaryDiagnoses as $diagnosis)
                            <option value="{{ $diagnosis->name }}" {{ in_array($diagnosis->name, $tertiaryDiagnosis) ? 'selected' : '' }}>{{ $diagnosis->name }}</option>
                        @endforeach
                    </select>
                    <p class="form-hint"><a href="{{ route('diagnoses.create') }}" target="_blank" tabindex="-1">Add new diagnosis</a></p>
                    @error('tertiary_diagnosis')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Hospital Information</h3>
            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="hospital_id" class="form-label">Hospital ID <span class="required">*</span></label>
                    <input type="text" id="hospital_id" name="hospital_id" class="form-input" value="{{ old('hospital_id', $patient->hospital_id) }}" required>
                    @error('hospital_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="clinic_name" class="form-label">Clinic Name</label>
                    <input type="text" id="clinic_name" name="clinic_name" class="form-input" value="{{ old('clinic_name', $patient->clinic_name) }}">
                    @error('clinic_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="physician_team_name" class="form-label">Physician/Team Name</label>
                    <select id="physician_team_name" name="physician_team_name" class="form-select select2-single">
                        <option value="">Select Physician/Team</option>
                        <option value="Dr. John Smith" {{ old('physician_team_name', $patient->physician_team_name) == 'Dr. John Smith' ? 'selected' : '' }}>Dr. John Smith</option>
                        <option value="Dr. Sarah Johnson" {{ old('physician_team_name', $patient->physician_team_name) == 'Dr. Sarah Johnson' ? 'selected' : '' }}>Dr. Sarah Johnson</option>
                        <option value="Dr. Michael Brown" {{ old('physician_team_name', $patient->physician_team_name) == 'Dr. Michael Brown' ? 'selected' : '' }}>Dr. Michael Brown</option>
                        <option value="Cardiology Team A" {{ old('physician_team_name', $patient->physician_team_name) == 'Cardiology Team A' ? 'selected' : '' }}>Cardiology Team A</option>
                        <option value="Cardiology Team B" {{ old('physician_team_name', $patient->physician_team_name) == 'Cardiology Team B' ? 'selected' : '' }}>Cardiology Team B</option>
                        <option value="Other" {{ old('physician_team_name', $patient->physician_team_name) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('physician_team_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nurse_name" class="form-label">Nurse Name</label>
                    <select id="nurse_name" name="nurse_name" class="form-select select2-single">
                        <option value="">Select Nurse</option>
                        <option value="Nurse Emily Davis" {{ old('nurse_name', $patient->nurse_name) == 'Nurse Emily Davis' ? 'selected' : '' }}>Nurse Emily Davis</option>
                        <option value="Nurse Robert Wilson" {{ old('nurse_name', $patient->nurse_name) == 'Nurse Robert Wilson' ? 'selected' : '' }}>Nurse Robert Wilson</option>
                        <option value="Nurse Lisa Anderson" {{ old('nurse_name', $patient->nurse_name) == 'Nurse Lisa Anderson' ? 'selected' : '' }}>Nurse Lisa Anderson</option>
                        <option value="Nurse James Taylor" {{ old('nurse_name', $patient->nurse_name) == 'Nurse James Taylor' ? 'selected' : '' }}>Nurse James Taylor</option>
                        <option value="Other" {{ old('nurse_name', $patient->nurse_name) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('nurse_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Security</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">Password <span class="form-hint">(Leave blank to keep current password)</span></label>
                    <input type="password" id="password" name="password" class="form-input">
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Next of Kin</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="next_of_kin" class="form-label">Next of Kin</label>
                    <input type="text" id="next_of_kin" name="next_of_kin" class="form-input" value="{{ old('next_of_kin', $patient->next_of_kin) }}">
                    @error('next_of_kin')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="next_of_kin_phone" class="form-label">Next of Kin Phone</label>
                    <input type="tel" id="next_of_kin_phone" name="next_of_kin_phone" class="form-input" value="{{ old('next_of_kin_phone', $patient->next_of_kin_phone) }}">
                    @error('next_of_kin_phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="next_of_kin_email" class="form-label">Next of Kin Email</label>
                    <input type="email" id="next_of_kin_email" name="next_of_kin_email" class="form-input" value="{{ old('next_of_kin_email', $patient->next_of_kin_email) }}">
                    @error('next_of_kin_email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.show', $patient) }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">Update Patient</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .page-header {
        margin-bottom: 32px;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 15px;
        color: var(--md-sys-color-on-surface-variant);
    }

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        max-width: 1000px;
        margin: 0 auto;
    }

    .form {
        width: 100%;
    }

    .form-section {
        margin-bottom: 36px;
        padding: 28px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 16px;
        border: 1px solid var(--md-sys-color-outline);
    }

    .form-section:last-of-type {
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-primary);
        display: inline-block;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 10px;
    }

    .required {
        color: #C62828;
    }

    .form-input, .form-select, .form-file {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        font-size: 15px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.3s ease;
    }

    .form-select {
        cursor: pointer;
    }

    .form-file {
        padding: 12px;
        cursor: pointer;
    }

    .form-input:focus, .form-select:focus, .form-file:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        margin-top: 6px;
        font-weight: 400;
    }

    .form-error {
        display: block;
        font-size: 13px;
        color: #C62828;
        margin-top: 8px;
        font-weight: 500;
    }

    .current-image {
        margin-bottom: 20px;
    }

    .current-image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        border: 2px solid var(--md-sys-color-outline);
        object-fit: contain;
        margin-top: 12px;
    }

    .image-preview {
        margin-top: 16px;
        padding: 16px;
        background: var(--md-sys-color-surface);
        border-radius: 12px;
        border: 2px solid var(--md-sys-color-outline);
    }

    .image-preview img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        object-fit: contain;
    }

    .chips-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
        border-radius: 16px;
        font-size: 13px;
        font-weight: 500;
    }

    .chip-remove {
        background: none;
        border: none;
        color: var(--md-sys-color-on-primary-container);
        cursor: pointer;
        padding: 0;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s ease;
    }

    .chip-remove:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid var(--md-sys-color-outline);
    }

    .mdc-button--outlined {
        background-color: #1C1B1F;
        border: 2px solid #1C1B1F;
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .mdc-button--outlined:hover {
        background-color: #313033;
        border-color: #313033;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .card {
            padding: 24px;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Image preview
    document.getElementById('profile_image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-preview').style.display = 'none';
        }
    });

    // Auto-calculate BMI when weight or height changes
    document.getElementById('weight')?.addEventListener('input', calculateBMI);
    document.getElementById('height')?.addEventListener('input', calculateBMI);

    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight')?.value);
        const height = parseFloat(document.getElementById('height')?.value);
        const bmiInput = document.getElementById('bmi');

        if (weight && height && height > 0) {
            // Convert height from cm to meters
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);
            if (bmiInput) {
                bmiInput.value = bmi.toFixed(2);
            }
        }
    }

    // Auto-calculate age from date of birth
    document.getElementById('date_of_birth')?.addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        const ageInput = document.getElementById('age');
        if (ageInput && age >= 0) {
            ageInput.value = age;
        }
    });

    // Countries and Cities data
    let countriesCitiesData = {};

    // Load countries and cities from JSON
    async function loadCountriesCities() {
        try {
            const response = await fetch('/json/countries-cities.json');
            countriesCitiesData = await response.json();
        } catch (error) {
            console.error('Error loading countries-cities.json:', error);
        }
    }

    // Update cities based on selected country
    function updateCities(selectedCountry) {
        const citySelect = $('#city');
        const currentCity = citySelect.val();
        
        // Clear existing options
        citySelect.empty();
        citySelect.append('<option value="">Select City</option>');
        
        if (selectedCountry && countriesCitiesData[selectedCountry]) {
            const cities = countriesCitiesData[selectedCountry];
            cities.forEach(city => {
                citySelect.append(`<option value="${city}">${city}</option>`);
            });
            
            // Restore previously selected city if it exists in the new list
            if (currentCity && cities.includes(currentCity)) {
                citySelect.val(currentCity).trigger('change');
            }
        }
        
        // Trigger Select2 update
        citySelect.trigger('change');
    }

    // Initialize Select2
    document.addEventListener('DOMContentLoaded', async function() {
        // Load countries and cities data
        await loadCountriesCities();

        // Initialize Select2 for single select dropdowns
        $('.select2-single').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: function() {
                return $(this).data('placeholder') || 'Select an option';
            },
            allowClear: true
        });

        // Initialize Select2 for multiple select dropdowns
        $('.select2-multiple').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: function() {
                return $(this).data('placeholder') || 'Select options';
            },
            closeOnSelect: false,
            tags: false
        });

        // Handle country change to update cities
        $('#country').on('change', function() {
            const selectedCountry = $(this).val();
            updateCities(selectedCountry);
        });

        // Initialize cities if country is already selected (for edit mode or form errors)
        const selectedCountry = $('#country').val();
        if (selectedCountry) {
            updateCities(selectedCountry);
        }
    });
</script>
@endpush
