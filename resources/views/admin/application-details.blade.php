@extends('layout.admin')

@section('title-block')
    Application Details - Admin
@endsection

@push('styles')
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.applications') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Applications
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Application Details</h1>
        </div>

    <div class="application-details-container">
        <!-- Application Status -->
        <div class="status-section">
            <div class="status-badge status-{{ $application->status }}">
                {{ ucfirst($application->status) }}
            </div>
            <div class="status-actions">
                <button class="btn btn-success status-btn" data-status="approved" data-id="{{ $application->id }}">
                    Approve
                </button>
                <button class="btn btn-warning status-btn" data-status="in_review" data-id="{{ $application->id }}">
                    Review
                </button>
                <button class="btn btn-danger status-btn" data-status="rejected" data-id="{{ $application->id }}">
                    Reject
                </button>
            </div>
        </div>

        <!-- Vehicle Information -->
        @if($application->car)
        <div class="detail-section">
            <h2>Vehicle Information</h2>
            <div class="vehicle-info">
                <div class="vehicle-image">
                    @if($application->car->images && $application->car->images->count() > 0)
                        <img src="{{ asset('storage/' . $application->car->images->first()->image_path) }}" 
                             alt="{{ $application->car->year }} {{ $application->car->brand->name ?? 'N/A' }} {{ $application->car->carModel->name ?? 'N/A' }}" 
                             onerror="this.src='{{ asset('img/car.jpeg') }}'">
                    @elseif($application->car->image)
                        <img src="{{ asset('storage/' . $application->car->image) }}" 
                             alt="{{ $application->car->year }} {{ $application->car->brand->name ?? 'N/A' }} {{ $application->car->carModel->name ?? 'N/A' }}" 
                             onerror="this.src='{{ asset('img/car.jpeg') }}'">
                    @else
                        <img src="{{ asset('img/car.jpeg') }}" 
                             alt="{{ $application->car->year }} {{ $application->car->brand->name ?? 'N/A' }} {{ $application->car->carModel->name ?? 'N/A' }}">
                    @endif
                </div>
                <div class="vehicle-details">
                    <h3>{{ $application->car->year }} {{ $application->car->brand->name ?? 'N/A' }} {{ $application->car->carModel->name ?? 'N/A' }}</h3>
                    <div class="vehicle-specs">
                        <p><strong>Stock #:</strong> {{ str_pad($application->car->id, 4, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Price:</strong> ${{ number_format($application->car->price) }}</p>
                        <p><strong>Year:</strong> {{ $application->car->year }}</p>
                        <p><strong>Make:</strong> {{ $application->car->brand->name ?? 'N/A' }}</p>
                        <p><strong>Model:</strong> {{ $application->car->carModel->name ?? 'N/A' }}</p>
                        <p><strong>Body Type:</strong> {{ $application->car->bodyType->name ?? 'N/A' }}</p>
                        <p><strong>Color:</strong> {{ $application->car->color->name ?? 'N/A' }}</p>
                        <p><strong>Transmission:</strong> {{ $application->car->transmission->name ?? 'N/A' }}</p>
                        <p><strong>Mileage:</strong> {{ $application->car->mileage ? number_format($application->car->mileage) : 'N/A' }} miles</p>
                        <p><strong>VIN:</strong> {{ $application->car->vin ?? 'N/A' }}</p>
                    </div>
                    <a href="{{ route('detalis', $application->car->id) }}" target="_blank" class="btn btn-primary">
                        <span class="material-symbols-outlined">visibility</span>
                        View Car Details
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Personal Information -->
        <div class="detail-section">
            <h2>Personal Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Buyer Type:</label>
                    <span>{{ ucfirst($application->buyer_type) }}</span>
                </div>
                <div class="info-item">
                    <label>Full Name:</label>
                    <span>{{ $application->full_name }}</span>
                </div>
                <div class="info-item">
                    <label>Email:</label>
                    <span>{{ $application->email }}</span>
                </div>
                <div class="info-item">
                    <label>Cell Phone:</label>
                    <span>{{ $application->cell_phone }}</span>
                </div>
                @if($application->home_phone)
                <div class="info-item">
                    <label>Home Phone:</label>
                    <span>{{ $application->home_phone }}</span>
                </div>
                @endif
                <div class="info-item">
                    <label>Date of Birth:</label>
                    <span>{{ $application->date_of_birth->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <label>SSN:</label>
                    <span>{{ $application->formatted_ssn }}</span>
                </div>
                @if($application->driver_license)
                <div class="info-item">
                    <label>Driver License:</label>
                    <span>{{ $application->driver_license }}</span>
                </div>
                @endif
                @if($application->driver_license_state)
                <div class="info-item">
                    <label>License State:</label>
                    <span>{{ $application->driver_license_state }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Address Information -->
        <div class="detail-section">
            <h2>Address Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Street Address:</label>
                    <span>{{ $application->street_address }}</span>
                </div>
                <div class="info-item">
                    <label>City:</label>
                    <span>{{ $application->city }}</span>
                </div>
                <div class="info-item">
                    <label>State:</label>
                    <span>{{ $application->state }}</span>
                </div>
                <div class="info-item">
                    <label>ZIP Code:</label>
                    <span>{{ $application->zip_code }}</span>
                </div>
                <div class="info-item">
                    <label>Housing Type:</label>
                    <span>{{ ucfirst(str_replace('-', ' ', $application->housing_type)) }}</span>
                </div>
                <div class="info-item">
                    <label>Monthly Rent:</label>
                    <span>${{ number_format($application->monthly_rent, 2) }}</span>
                </div>
                <div class="info-item">
                    <label>Time at Address:</label>
                    <span>{{ $application->years_at_address }} years, {{ $application->months_at_address ?? 0 }} months</span>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="detail-section">
            <h2>Employment Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Employer Name:</label>
                    <span>{{ $application->employer_name }}</span>
                </div>
                <div class="info-item">
                    <label>Job Title:</label>
                    <span>{{ $application->job_title }}</span>
                </div>
                <div class="info-item">
                    <label>Employer Phone:</label>
                    <span>{{ $application->employer_phone }}</span>
                </div>
                <div class="info-item">
                    <label>Monthly Income:</label>
                    <span>${{ number_format($application->monthly_income, 2) }}</span>
                </div>
                <div class="info-item">
                    <label>Time at Job:</label>
                    <span>{{ $application->years_at_job }} years, {{ $application->months_at_job ?? 0 }} months</span>
                </div>
            </div>
        </div>

        <!-- Vehicle Application Details -->
        <div class="detail-section">
            <h2>Vehicle Application Details</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Stock Number:</label>
                    <span>{{ $application->stock_number ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Vehicle Year:</label>
                    <span>{{ $application->vehicle_year ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Vehicle Make:</label>
                    <span>{{ $application->vehicle_make ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Vehicle Model:</label>
                    <span>{{ $application->vehicle_model ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Vehicle Price:</label>
                    <span>{{ $application->vehicle_price ? '$' . number_format($application->vehicle_price, 2) : 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Down Payment:</label>
                    <span>{{ $application->down_payment ? '$' . number_format($application->down_payment, 2) : 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Exterior Color:</label>
                    <span>{{ $application->exterior_color ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Interior Color:</label>
                    <span>{{ $application->interior_color ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Trade-In Information -->
        @if($application->has_trade_in)
        <div class="detail-section">
            <h2>Trade-In Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Trade VIN:</label>
                    <span>{{ $application->trade_vin ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Trade Mileage:</label>
                    <span>{{ $application->trade_mileage ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Trade Year:</label>
                    <span>{{ $application->trade_year ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Trade Make:</label>
                    <span>{{ $application->trade_make ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <label>Trade Model:</label>
                    <span>{{ $application->trade_model ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Application Meta -->
        <div class="detail-section">
            <h2>Application Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Submitted:</label>
                    <span>{{ $application->created_at->format('M d, Y H:i:s') }}</span>
                </div>
                <div class="info-item">
                    <label>Last Updated:</label>
                    <span>{{ $application->updated_at->format('M d, Y H:i:s') }}</span>
                </div>
                <div class="info-item">
                    <label>Terms Accepted:</label>
                    <span>{{ $application->accepts_terms ? 'Yes' : 'No' }}</span>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="detail-section">
            <h2>Notes</h2>
            <div class="notes-section">
                <textarea id="notes" placeholder="Add notes about this application..." rows="4">{{ $application->notes }}</textarea>
                <button class="btn btn-primary" onclick="saveNotes({{ $application->id }})">
                    <span class="material-symbols-outlined">save</span>
                    Save Notes
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.application-details-container {
    max-width: 1200px;
    margin: 0 auto;
}

.status-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background-color: #2a2a2a;
    border-radius: 8px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
}

.status-pending { background-color: #ffc107; color: #000; }
.status-approved { background-color: #28a745; color: #fff; }
.status-rejected { background-color: #dc3545; color: #fff; }
.status-in_review { background-color: #17a2b8; color: #fff; }

.status-actions {
    display: flex;
    gap: 10px;
}

.detail-section {
    background-color: #2a2a2a;
    margin-bottom: 20px;
    padding: 25px;
    border-radius: 8px;
}

.detail-section h2 {
    color: #ffff00;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ffff00;
    display: inline-block;
}

.vehicle-info {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 30px;
    align-items: start;
}

.vehicle-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #ffff00;
}

.vehicle-details h3 {
    color: #ffffff;
    font-size: 24px;
    margin-bottom: 20px;
}

.vehicle-specs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.vehicle-specs p {
    margin: 0;
    padding: 8px 0;
    border-bottom: 1px solid #444;
}

.vehicle-specs strong {
    color: #ffff00;
    font-weight: 600;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item label {
    color: #ffff00;
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 14px;
}

.info-item span {
    color: #ffffff;
    font-size: 16px;
    padding: 8px 0;
    border-bottom: 1px solid #444;
}

.notes-section {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notes-section textarea {
    width: 100%;
    padding: 15px;
    border: 1px solid #444;
    border-radius: 5px;
    background-color: #333;
    color: #ffffff;
    font-family: inherit;
    resize: vertical;
}

.notes-section textarea:focus {
    outline: none;
    border-color: #ffff00;
}

@media (max-width: 768px) {
    .vehicle-info {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .vehicle-specs {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .status-section {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .status-actions {
        justify-content: center;
    }
}
</style>

<script>
function saveNotes(applicationId) {
    const notes = document.getElementById('notes').value;
    
    fetch(`/admin/applications/${applicationId}/notes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Notes saved successfully!');
        } else {
            alert('Error saving notes: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving notes');
    });
}

// Status update functionality
document.querySelectorAll('.status-btn').forEach(button => {
    button.addEventListener('click', function() {
        const status = this.dataset.status;
        const applicationId = this.dataset.id;
        
        if (confirm(`Are you sure you want to mark this application as ${status}?`)) {
            fetch(`/admin/applications/${applicationId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });
        }
    });
});
</script>
@endsection
