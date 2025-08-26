@extends('layout.admin')

@section('title-block')
    Applications - Admin Panel
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.index') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Admin Panel
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Applications</h1>
            <div class="admin-stats">
                <div class="stat-card">
                    <span class="stat-number">{{ $applications->total() }}</span>
                    <span class="stat-label">Total Applications</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $applications->where('status', 'pending')->count() }}</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $applications->where('status', 'approved')->count() }}</span>
                    <span class="stat-label">Approved</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $applications->where('status', 'rejected')->count() }}</span>
                    <span class="stat-label">Rejected</span>
                </div>
            </div>
        </div>

        <div class="applications-container">
            <div class="applications-header">
                <div class="search-filters">
                    <input type="text" id="searchInput" placeholder="Search applications..." class="search-input">
                    <select id="statusFilter" class="status-filter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="in_review">In Review</option>
                    </select>
                </div>
            </div>

            <div class="applications-list">
                @forelse($applications as $application)
                <div class="application-card" data-status="{{ $application->status }}">
                    <div class="application-header">
                        <div class="application-info">
                            <h3>{{ $application->full_name }}</h3>
                            <p class="application-email">{{ $application->email }}</p>
                            <p class="application-phone">{{ $application->cell_phone }}</p>
                        </div>
                        <div class="application-status">
                            <span class="status-badge status-{{ $application->status }}">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="application-details">
                        <div class="detail-row">
                            <span class="detail-label">Buyer Type:</span>
                            <span class="detail-value">{{ ucfirst($application->buyer_type) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date of Birth:</span>
                            <span class="detail-value">{{ $application->date_of_birth->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Monthly Income:</span>
                            <span class="detail-value">${{ number_format($application->monthly_income, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Employer:</span>
                            <span class="detail-value">{{ $application->employer_name }}</span>
                        </div>
                        @if($application->car)
                        <div class="detail-row">
                            <span class="detail-label">Vehicle:</span>
                            <span class="detail-value">
                                <a href="{{ route('detalis', $application->car->id) }}" target="_blank" class="vehicle-link">
                                    {{ $application->car->year }} {{ $application->car->brand->name ?? 'N/A' }} {{ $application->car->carModel->name ?? 'N/A' }}
                                </a>
                                <br><small>Stock #{{ str_pad($application->car->id, 4, '0', STR_PAD_LEFT) }} | ${{ number_format($application->car->price) }}</small>
                            </span>
                        </div>
                        @elseif($application->vehicle_make)
                        <div class="detail-row">
                            <span class="detail-label">Vehicle:</span>
                            <span class="detail-value">{{ $application->vehicle_year }} {{ $application->vehicle_make }} {{ $application->vehicle_model }}</span>
                        </div>
                        @endif
                        <div class="detail-row">
                            <span class="detail-label">Submitted:</span>
                            <span class="detail-value">{{ $application->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="application-actions">
                        <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-primary">
                            View Details
                        </a>
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
                </div>
                @empty
                <div class="no-applications">
                    <div class="no-applications-content">
                        <span class="material-symbols-outlined">description</span>
                        <h3>No Applications Found</h3>
                        <p>There are no applications to display at the moment.</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if($applications->hasPages())
            <div class="pagination-container">
                {{ $applications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.admin-page {
    margin-top: 80px;
    padding: 20px;
    background-color: #1a1a1a;
    min-height: calc(100vh - 80px);
}

.admin-header {
    margin-bottom: 30px;
}

.admin-header h1 {
    color: #ffffff;
    font-size: 28px;
    margin-bottom: 20px;
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #444;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: 700;
    color: #ffff00;
    margin-bottom: 5px;
}

.stat-label {
    color: #cccccc;
    font-size: 14px;
}

.applications-container {
    background: #2a2a2a;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #444;
}

.applications-header {
    margin-bottom: 20px;
}

.search-filters {
    display: flex;
    gap: 15px;
    align-items: center;
}

.search-input, .status-filter {
    padding: 10px 15px;
    border: 1px solid #555;
    border-radius: 5px;
    background: #333;
    color: #ffffff;
    font-size: 14px;
}

.search-input {
    flex: 1;
    max-width: 300px;
}

.status-filter {
    min-width: 150px;
}

.applications-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.application-card {
    background: #333;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #555;
    transition: all 0.3s ease;
}

.application-card:hover {
    border-color: #ffff00;
    transform: translateY(-2px);
}

.application-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.application-info h3 {
    color: #ffffff;
    font-size: 18px;
    margin-bottom: 5px;
}

.application-email, .application-phone {
    color: #cccccc;
    font-size: 14px;
    margin: 2px 0;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #ffc107;
    color: #000;
}

.status-approved {
    background: #28a745;
    color: #fff;
}

.status-rejected {
    background: #dc3545;
    color: #fff;
}

.status-in_review {
    background: #17a2b8;
    color: #fff;
}

.application-details {
    margin-bottom: 15px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.detail-label {
    color: #cccccc;
    font-weight: 500;
}

.detail-value {
    color: #ffffff;
}

.application-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-warning {
    background: #ffc107;
    color: #000;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.status-actions {
    display: flex;
    gap: 8px;
}

.status-btn {
    padding: 6px 12px;
    font-size: 12px;
}

.no-applications {
    text-align: center;
    padding: 60px 20px;
}

.no-applications-content {
    color: #cccccc;
}

.no-applications-content .material-symbols-outlined {
    font-size: 48px;
    color: #666;
    margin-bottom: 15px;
}

.no-applications h3 {
    color: #ffffff;
    margin-bottom: 10px;
}

.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination-container .pagination {
    display: flex;
    gap: 5px;
}

.pagination-container .page-link {
    padding: 8px 12px;
    background: #333;
    color: #ffffff;
    border: 1px solid #555;
    border-radius: 5px;
    text-decoration: none;
}

.pagination-container .page-link:hover {
    background: #444;
}

.pagination-container .page-item.active .page-link {
    background: #ffff00;
    color: #000;
    border-color: #ffff00;
}

@media (max-width: 768px) {
    .admin-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .application-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .application-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .status-actions {
        justify-content: center;
    }
    
    .search-filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-input {
        max-width: none;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const applicationCards = document.querySelectorAll('.application-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        applicationCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Status filter
    const statusFilter = document.getElementById('statusFilter');
    
    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        
        applicationCards.forEach(card => {
            const cardStatus = card.dataset.status;
            if (!selectedStatus || cardStatus === selectedStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Status update buttons
    const statusBtns = document.querySelectorAll('.status-btn');
    
    statusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const applicationId = this.dataset.id;
            const newStatus = this.dataset.status;
            
            if (confirm(`Are you sure you want to mark this application as ${newStatus}?`)) {
                updateApplicationStatus(applicationId, newStatus);
            }
        });
    });
    
    function updateApplicationStatus(applicationId, status) {
        fetch(`/admin/applications/${applicationId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the status badge
                const card = document.querySelector(`[data-id="${applicationId}"]`).closest('.application-card');
                const statusBadge = card.querySelector('.status-badge');
                statusBadge.className = `status-badge status-${status}`;
                statusBadge.textContent = status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                card.dataset.status = status;
                
                // Show success message
                showNotification('Application status updated successfully!', 'success');
            } else {
                showNotification('Failed to update application status.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while updating the status.', 'error');
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
            background-color: ${type === 'success' ? '#28a745' : '#dc3545'};
        `;
        
        document.body.appendChild(notification);
        
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.remove();
        });
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }
});
</script>
@endpush

@endsection 