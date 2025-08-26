@extends('layout.admin')

@section('title-block')
    Edit Car - Admin Panel
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.cars') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Cars
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Edit Car</h1>
        </div>
        
        @if($errors->any())
            <div style="color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin-bottom: 20px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        @if(session('error'))
            <div style="color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h3>Basic Information</h3>
                
                <label>Brand:
                    <select name="brand_id" id="brand-select" required>
                        <option value="">Select brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                
                <label>Model:
                    <select name="car_model_id" id="model-select" required>
                        <option value="">Select model</option>
                        @foreach($models as $model)
                            <option value="{{ $model->id }}" data-brand="{{ $model->brand_id }}" {{ old('car_model_id', $car->car_model_id) == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                
                <label>Year:
                    <input type="number" name="year" value="{{ old('year', $car->year) }}" min="1900" max="2030" required>
                </label>
                
                <label>Price ($):
                    <input type="number" step="0.01" name="price" value="{{ old('price', $car->price) }}" required>
                </label>
            </div>

            <div class="form-section">
                <h3>Technical Specifications</h3>
                
                <label>Mileage (km):
                    <input type="number" name="mileage" value="{{ old('mileage', $car->mileage) }}" min="0">
                </label>
                
                <label>VIN Number:
                    <input type="text" name="vin" value="{{ old('vin', $car->vin) }}" maxlength="17" placeholder="17 characters">
                </label>
                
                <label>Engine Size:
                    <input type="text" name="engine_size" value="{{ old('engine_size', $car->engine_size) }}" placeholder="e.g., 2.0L">
                </label>
                
                <label>Horsepower (hp):
                    <input type="number" name="horsepower" value="{{ old('horsepower', $car->horsepower) }}" min="0">
                </label>
                
                <label>Fuel Type:
                    <select name="fuel_type">
                        <option value="">Select fuel type</option>
                        <option value="Gasoline" {{ old('fuel_type', $car->fuel_type) == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                        <option value="Diesel" {{ old('fuel_type', $car->fuel_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybrid" {{ old('fuel_type', $car->fuel_type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Electric" {{ old('fuel_type', $car->fuel_type) == 'Electric' ? 'selected' : '' }}>Electric</option>
                    </select>
                </label>
                
                <label>Drivetrain:
                    <select name="drivetrain">
                        <option value="">Select drivetrain</option>
                        <option value="FWD" {{ old('drivetrain', $car->drivetrain) == 'FWD' ? 'selected' : '' }}>Front-Wheel Drive (FWD)</option>
                        <option value="RWD" {{ old('drivetrain', $car->drivetrain) == 'RWD' ? 'selected' : '' }}>Rear-Wheel Drive (RWD)</option>
                        <option value="AWD" {{ old('drivetrain', $car->drivetrain) == 'AWD' ? 'selected' : '' }}>All-Wheel Drive (AWD)</option>
                        <option value="4WD" {{ old('drivetrain', $car->drivetrain) == '4WD' ? 'selected' : '' }}>Four-Wheel Drive (4WD)</option>
                    </select>
                </label>
                
                <label>Doors:
                    <select name="doors">
                        <option value="">Select number of doors</option>
                        <option value="2" {{ old('doors', $car->doors) == '2' ? 'selected' : '' }}>2 Doors</option>
                        <option value="3" {{ old('doors', $car->doors) == '3' ? 'selected' : '' }}>3 Doors</option>
                        <option value="4" {{ old('doors', $car->doors) == '4' ? 'selected' : '' }}>4 Doors</option>
                        <option value="5" {{ old('doors', $car->doors) == '5' ? 'selected' : '' }}>5 Doors</option>
                    </select>
                </label>
                
                <label>Interior Color:
                    <input type="text" name="interior_color" value="{{ old('interior_color', $car->interior_color) }}" placeholder="e.g., Black, Beige, Gray">
                </label>
                
                <label>CARFAX Report URL:
                    <input type="url" name="carfax_url" value="{{ old('carfax_url', $car->carfax_url) }}" placeholder="https://vin-info.online/storage/reports/carfax/...">
                    <small style="color: #ccc; font-size: 12px; margin-top: 5px; display: block;">Optional: Link to CARFAX report for this vehicle</small>
                </label>
            </div>

            <div class="form-section">
                <h3>Appearance</h3>
                
                <label>Color:
                    <select name="color_id">
                        <option value="">Select color</option>
                        @foreach(\App\Models\Color::where('active', true)->get() as $color)
                            <option value="{{ $color->id }}" {{ old('color_id', $car->color_id) == $color->id ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                
                <label>Body Type:
                    <select name="body_type_id">
                        <option value="">Select body type</option>
                        @foreach(\App\Models\BodyType::where('active', true)->get() as $bodyType)
                            <option value="{{ $bodyType->id }}" {{ old('body_type_id', $car->body_type_id) == $bodyType->id ? 'selected' : '' }}>
                                {{ $bodyType->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                
                <label>Transmission:
                    <select name="transmission_id">
                        <option value="">Select transmission</option>
                        @foreach(\App\Models\Transmission::where('active', true)->get() as $transmission)
                            <option value="{{ $transmission->id }}" {{ old('transmission_id', $car->transmission_id) == $transmission->id ? 'selected' : '' }}>
                                {{ $transmission->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-section">
                <h3>Description</h3>
                
                <label>Description:
                    <textarea name="description" rows="5" placeholder="Detailed car description...">{{ old('description', $car->description) }}</textarea>
                </label>
            </div>

            <div class="form-section">
                <h3>Car Equipment</h3>
                
                <div class="equipment-categories">
                    <div class="equipment-category">
                        <h4>General Equipment</h4>
                        <div class="equipment-items">
                            @php
                                $equipmentNames = $car->equipment->pluck('name')->toArray();
                            @endphp
                            <label><input type="checkbox" name="equipment[]" value="AIR CONDITIONING" {{ in_array('AIR CONDITIONING', $equipmentNames) ? 'checked' : '' }}> Air Conditioning</label>
                            <label><input type="checkbox" name="equipment[]" value="POWER DOOR LOCKS" {{ in_array('POWER DOOR LOCKS', $equipmentNames) ? 'checked' : '' }}> Power Door Locks</label>
                            <label><input type="checkbox" name="equipment[]" value="AM/FM STEREO" {{ in_array('AM/FM STEREO', $equipmentNames) ? 'checked' : '' }}> Audio System</label>
                            <label><input type="checkbox" name="equipment[]" value="GLASS ROOF" {{ in_array('GLASS ROOF', $equipmentNames) ? 'checked' : '' }}> Glass Roof</label>
                            <label><input type="checkbox" name="equipment[]" value="PUSH BUTTON START" {{ in_array('PUSH BUTTON START', $equipmentNames) ? 'checked' : '' }}> Push Button Start</label>
                            <label><input type="checkbox" name="equipment[]" value="DYNAMIC CRUISE CONTROL" {{ in_array('DYNAMIC CRUISE CONTROL', $equipmentNames) ? 'checked' : '' }}> Adaptive Cruise Control</label>
                        </div>
                    </div>

                    <div class="equipment-category">
                        <h4>Safety</h4>
                        <div class="equipment-items">
                            <label><input type="checkbox" name="equipment[]" value="BACKUP CAMERA" {{ in_array('BACKUP CAMERA', $equipmentNames) ? 'checked' : '' }}> Backup Camera</label>
                            <label><input type="checkbox" name="equipment[]" value="ABS (4-WHEEL)" {{ in_array('ABS (4-WHEEL)', $equipmentNames) ? 'checked' : '' }}> ABS</label>
                            <label><input type="checkbox" name="equipment[]" value="ALARM SYSTEM" {{ in_array('ALARM SYSTEM', $equipmentNames) ? 'checked' : '' }}> Alarm System</label>
                            <label><input type="checkbox" name="equipment[]" value="LANE KEEP ASSIST" {{ in_array('LANE KEEP ASSIST', $equipmentNames) ? 'checked' : '' }}> Lane Keep Assist</label>
                            <label><input type="checkbox" name="equipment[]" value="DAYTIME RUNNING LIGHTS" {{ in_array('DAYTIME RUNNING LIGHTS', $equipmentNames) ? 'checked' : '' }}> Daytime Running Lights</label>
                        </div>
                    </div>

                    <div class="equipment-category">
                        <h4>Comfort</h4>
                        <div class="equipment-items">
                            <label><input type="checkbox" name="equipment[]" value="HEATED & VENTILATED SEATS" {{ in_array('HEATED & VENTILATED SEATS', $equipmentNames) ? 'checked' : '' }}> Heated & Ventilated Seats</label>
                            <label><input type="checkbox" name="equipment[]" value="POWER WINDOWS" {{ in_array('POWER WINDOWS', $equipmentNames) ? 'checked' : '' }}> Power Windows</label>
                            <label><input type="checkbox" name="equipment[]" value="DUAL POWER SEATS" {{ in_array('DUAL POWER SEATS', $equipmentNames) ? 'checked' : '' }}> Dual Power Seats</label>
                            <label><input type="checkbox" name="equipment[]" value="LEATHER" {{ in_array('LEATHER', $equipmentNames) ? 'checked' : '' }}> Leather Interior</label>
                            <label><input type="checkbox" name="equipment[]" value="POWER STEERING" {{ in_array('POWER STEERING', $equipmentNames) ? 'checked' : '' }}> Power Steering</label>
                        </div>
                    </div>

                    <div class="equipment-category">
                        <h4>Technology</h4>
                        <div class="equipment-items">
                            <label><input type="checkbox" name="equipment[]" value="LED HEADLAMPS" {{ in_array('LED HEADLAMPS', $equipmentNames) ? 'checked' : '' }}> LED Headlamps</label>
                            <label><input type="checkbox" name="equipment[]" value="LEXUS ENFORM" {{ in_array('LEXUS ENFORM', $equipmentNames) ? 'checked' : '' }}> Multimedia System</label>
                            <label><input type="checkbox" name="equipment[]" value="BLUETOOTH WIRELESS" {{ in_array('BLUETOOTH WIRELESS', $equipmentNames) ? 'checked' : '' }}> Bluetooth</label>
                            <label><input type="checkbox" name="equipment[]" value="PREMIUM WHEELS 19" {{ in_array('PREMIUM WHEELS 19', $equipmentNames) ? 'checked' : '' }}> Premium 19" Wheels</label>
                            <label><input type="checkbox" name="equipment[]" value="PREMIUM SOUND" {{ in_array('PREMIUM SOUND', $equipmentNames) ? 'checked' : '' }}> Premium Sound</label>
                            <label><input type="checkbox" name="equipment[]" value="NAVIGATION SYSTEM" {{ in_array('NAVIGATION SYSTEM', $equipmentNames) ? 'checked' : '' }}> Navigation System</label>
                        </div>
                    </div>
                </div>

                <div class="custom-equipment">
                    <h4>Additional Equipment</h4>
                    <div id="custom-equipment-list">
                        <div class="custom-equipment-item">
                            <input type="text" name="custom_equipment[]" placeholder="Equipment name" class="equipment-input">
                            <select name="custom_equipment_category[]" class="equipment-category-select">
                                <option value="general">General</option>
                                <option value="safety">Safety</option>
                                <option value="comfort">Comfort</option>
                                <option value="technology">Technology</option>
                            </select>
                            <button type="button" onclick="removeEquipment(this)" class="remove-equipment">Remove</button>
                        </div>
                    </div>
                    <button type="button" onclick="addEquipment()" class="add-equipment">+ Add Equipment</button>
                </div>
            </div>

            <div class="form-section">
                <h3>Photos</h3>
                
                <div class="file-upload-container">
                    <label class="file-upload-label" for="images-input-create">
                        <div class="file-upload-content">
                            <span class="material-symbols-outlined">cloud_upload</span>
                            <span class="upload-text">Click to select photos</span>
                            <span class="upload-hint">or drag and drop files here</span>
                            <small class="upload-info">Supported formats: JPG, PNG, GIF. Maximum size: 10MB per file</small>
                        </div>
                        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif" id="images-input-create" class="file-input">
                    </label>
                    
                    <div class="upload-status" id="upload-status-create" style="display: none;">
                        <div class="status-message">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span id="status-text-create">Files selected successfully</span>
                        </div>
                    </div>
                    
                    <div id="preview-create" class="image-preview-container"></div>
                    
                    <div class="upload-error" id="upload-error-create" style="display: none;">
                        <span class="material-symbols-outlined">error</span>
                        <span id="error-text-create"></span>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Publication</h3>
                
                <label>
                    <input type="checkbox" name="published" value="1" {{ old('published', $car->published) ? 'checked' : '' }}> 
                    Publish car
                </label>
                
                <label>Status:
                    <select name="status">
                        <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status', $car->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="reserved" {{ old('status', $car->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="hidden" {{ old('status', $car->status) == 'hidden' ? 'selected' : '' }}>Hidden</option>
                    </select>
                </label>
            </div>
            
            <button type="submit">Save Car</button>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/admin-forms.js') }}"></script>
    <script>
        function addEquipment() {
            const container = document.getElementById('custom-equipment-list');
            const newItem = document.createElement('div');
            newItem.className = 'custom-equipment-item';
            newItem.innerHTML = `
                <input type="text" name="custom_equipment[]" placeholder="Equipment name" class="equipment-input">
                <select name="custom_equipment_category[]" class="equipment-category-select">
                    <option value="general">General</option>
                    <option value="safety">Safety</option>
                    <option value="comfort">Comfort</option>
                    <option value="technology">Technology</option>
                </select>
                <button type="button" onclick="removeEquipment(this)" class="remove-equipment">Remove</button>
            `;
            container.appendChild(newItem);
        }

        function removeEquipment(button) {
            button.parentElement.remove();
        }
    </script>
@endpush

<style>
.form-section {
    background: #2a2a2a;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #444;
}

.form-section h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #ffffff;
    border-bottom: 2px solid #ffff00;
    padding-bottom: 5px;
}

.admin-form label {
    display: block;
    margin-bottom: 15px;
    font-weight: 600;
    color: #ffffff;
}

.admin-form input[type="text"],
.admin-form input[type="number"],
.admin-form input[type="email"],
.admin-form select,
.admin-form textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #555;
    border-radius: 4px;
    font-size: 14px;
    background: #333;
    color: #ffffff;
}

.admin-form button[type="submit"] {
    background: #ffff00;
    color: #000000;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
}

.admin-form button[type="submit"]:hover {
    background: #ffd700;
}

/* Equipment Styles */
.equipment-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.equipment-category {
    background: #2a2a2a;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #444;
}

.equipment-category h4 {
    margin: 0 0 10px 0;
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
}

.equipment-items {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.equipment-items label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: normal;
    margin: 0;
    cursor: pointer;
    color: #ffffff;
}

.equipment-items input[type="checkbox"] {
    width: auto;
    margin: 0;
    accent-color: #ffff00;
}

.custom-equipment {
    margin-top: 20px;
    padding: 15px;
    background: #333;
    border-radius: 8px;
    border: 1px solid #444;
}

.custom-equipment h4 {
    margin: 0 0 15px 0;
    color: #ffffff;
}

.custom-equipment-item {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.equipment-input {
    flex: 2;
    padding: 8px 12px;
    border: 1px solid #555;
    border-radius: 4px;
    font-size: 14px;
    background: #333;
    color: #ffffff;
}

.equipment-category-select {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #555;
    border-radius: 4px;
    font-size: 14px;
    background: #333;
    color: #ffffff;
}

.remove-equipment {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.remove-equipment:hover {
    background: #c82333;
}

.add-equipment {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
}

.add-equipment:hover {
    background: #218838;
}
</style>
@endsection 
