@extends('layout.admin')

@section('title-block')
    Users - Admin Panel
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
        <h1>Users</h1>
        
        <div class="admin-header">
            <p>Manage user accounts and permissions</p>
        </div>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Admin</td>
                    <td>admin@example.com</td>
                    <td><span class="status-badge status-admin">Administrator</span></td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td class="actions">
                        <a href="#" class="btn btn-edit">Edit</a>
                        <button onclick="deleteUser(1)" class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td><span class="status-badge status-user">User</span></td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td class="actions">
                        <a href="#" class="btn btn-edit">Edit</a>
                        <button onclick="deleteUser(2)" class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td><span class="status-badge status-user">User</span></td>
                    <td><span class="status-badge status-inactive">Inactive</span></td>
                    <td class="actions">
                        <a href="#" class="btn btn-edit">Edit</a>
                        <button onclick="deleteUser(3)" class="btn btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="admin-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        // Здесь можно добавить AJAX запрос для удаления
        console.log('Deleting user with ID:', userId);
        // window.location.href = '/admin/users/' + userId + '/delete';
    }
}
</script>
@endpush
@endsection 
