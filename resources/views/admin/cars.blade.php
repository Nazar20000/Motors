@extends('layout.admin')

@section('title-block')
    Cars - Admin Panel
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
            <h1>Cars</h1>
        </div>
        
        <p>Total cars: {{ $cars->total() }}</p>
        
        @if($cars->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->brand->name ?? 'N/A' }}</td>
                        <td>{{ $car->carModel->name ?? 'N/A' }}</td>
                        <td>{{ $car->year }}</td>
                        <td>${{ number_format($car->price, 2) }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-edit">Edit</a>
                            <button onclick="deleteCar({{ $car->id }})" class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No cars found.</p>
        @endif
    </div>
</div>

@push('scripts')
<script>
function deleteCar(carId) {
    if (confirm('Are you sure you want to delete this car? This action cannot be undone.')) {
        // Здесь можно добавить AJAX запрос для удаления
        console.log('Deleting car with ID:', carId);
        // window.location.href = '/admin/cars/' + carId + '/delete';
    }
}
</script>
@endpush
@endsection 
