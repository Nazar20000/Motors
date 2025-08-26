@extends('layout.admin')

@section('title-block')
    Requests - Admin Panel
@endsection

@push('styles')
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
            <h1>Requests ({{ $requests->total() }})</h1>
            <p>Manage customer requests and inquiries</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="filters-section">
            <div class="filters">
                <select id="status-filter" onchange="filterRequests()" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="new">New</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                
                <select id="type-filter" onchange="filterRequests()" class="filter-select">
                    <option value="">All Types</option>
                    <option value="contact">General Questions</option>
                    <option value="test_drive">Test Drive</option>
                    <option value="quote">Price Request</option>
                    <option value="apply_online">Online Application</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Car</th>
                        <th>Date</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr class="request-row" data-status="{{ $request->status }}" data-type="{{ $request->type }}">
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>
                                <span class="badge badge-{{ $request->type }}">
                                    {{ $request->type_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $request->status }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($request->car)
                                    <a href="{{ route('detalis', $request->car->id) }}" target="_blank" class="car-link">
                                        {{ $request->car->full_name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                            <td class="actions">
                                <button onclick="viewRequest({{ $request->id }})" class="btn btn-primary">View</button>
                                <button onclick="updateStatus({{ $request->id }})" class="btn btn-warning">Status</button>
                                <button onclick="deleteRequest({{ $request->id }})" class="btn btn-delete">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-data">
                                <div class="no-data-content">
                                    <span class="material-symbols-outlined">inbox</span>
                                    <p>No requests yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $requests->links() }}
        </div>
    </div>
</div>

<!-- Modal for viewing request -->
<div id="requestModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="requestDetails"></div>
    </div>
</div>

@push('scripts')
<script>
function filterRequests() {
    const statusFilter = document.getElementById('status-filter').value;
    const typeFilter = document.getElementById('type-filter').value;
    const rows = document.querySelectorAll('.request-row');
    
    rows.forEach(row => {
        const status = row.dataset.status;
        const type = row.dataset.type;
        
        const statusMatch = !statusFilter || status === statusFilter;
        const typeMatch = !typeFilter || type === typeFilter;
        
        row.style.display = statusMatch && typeMatch ? '' : 'none';
    });
}

function viewRequest(id) {
    fetch(`/admin/requests/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('requestDetails').innerHTML = html;
            document.getElementById('requestModal').style.display = 'block';
        });
}

function updateStatus(id) {
    const status = prompt('Enter new status (new, in_progress, completed, cancelled):');
    if (status) {
        fetch(`/admin/requests/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function deleteRequest(id) {
    if (confirm('Are you sure you want to delete this request?')) {
        fetch(`/admin/requests/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(() => {
            location.reload();
        });
    }
}

// Close modal
document.querySelector('.close').onclick = function() {
    document.getElementById('requestModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('requestModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush
@endsection 
