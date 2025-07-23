@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@extends('layout.app')

@section('title-block')
    Редактировать автомобиль
@endsection

@section('content')
<div class="admin-content">
    <h1>Редактировать автомобиль</h1>
    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')
        <label>Марка:
            <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" required>
        </label>
        <label>Модель:
            <input type="text" name="model" value="{{ old('model', $car->model) }}" required>
        </label>
        <label>Год:
            <input type="number" name="year" value="{{ old('year', $car->year) }}" required>
        </label>
        <label>Цена:
            <input type="number" step="0.01" name="price" value="{{ old('price', $car->price) }}" required>
        </label>
        <label>Описание:
            <textarea name="description">{{ old('description', $car->description) }}</textarea>
        </label>
        <label class="file-label">
            <span>Добавить новые фото:</span>
            <input type="file" name="images[]" multiple accept="image/*" style="display:none;" id="images-input-edit">
        </label>
        <div id="preview-edit" style="display:flex;gap:10px;flex-wrap:wrap;"></div>
        <div>Текущие фото:<br>
            @if($car->image)
                <img src="{{ asset('storage/' . $car->image) }}" alt="Главное фото" width="120"> (главное)<br>
            @endif
            @foreach($car->images as $img)
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Фото" width="100">
            @endforeach
        </div><br>
        <label><input type="checkbox" name="published" value="1" {{ old('published', $car->published) ? 'checked' : '' }}> Опубликовать</label>
        <button type="submit">Сохранить</button>
    </form>
    @push('scripts')
    <script>
        const inputEdit = document.getElementById('images-input-edit');
        const previewEdit = document.getElementById('preview-edit');
        let filesEdit = [];
        if(inputEdit) {
            inputEdit.addEventListener('change', function() {
                for (let file of this.files) {
                    if(file.type.startsWith('image/')) {
                        filesEdit.push(file);
                    }
                }
                renderPreviewsEdit();
                updateInputFilesEdit();
            });
            // Клик по label открывает input
            inputEdit.previousElementSibling.addEventListener('click', function() {
                inputEdit.click();
            });
        }
        function renderPreviewsEdit() {
            previewEdit.innerHTML = '';
            filesEdit.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '80px';
                    img.style.borderRadius = '6px';
                    img.style.boxShadow = '0 1px 4px rgba(0,0,0,0.08)';
                    img.style.marginRight = '4px';
                    // Кнопка удаления
                    const del = document.createElement('span');
                    del.textContent = '×';
                    del.style.position = 'absolute';
                    del.style.top = '0';
                    del.style.right = '2px';
                    del.style.background = '#fff';
                    del.style.color = '#d00';
                    del.style.fontWeight = 'bold';
                    del.style.cursor = 'pointer';
                    del.style.fontSize = '20px';
                    del.style.borderRadius = '50%';
                    del.style.padding = '0 6px';
                    del.onclick = () => {
                        filesEdit.splice(idx, 1);
                        renderPreviewsEdit();
                        updateInputFilesEdit();
                    };
                    wrapper.appendChild(img);
                    wrapper.appendChild(del);
                    previewEdit.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }
        function updateInputFilesEdit() {
            const dt = new DataTransfer();
            filesEdit.forEach(f => dt.items.add(f));
            inputEdit.files = dt.files;
        }
    </script>
    @endpush
    <br>
    <a href="{{ route('admin.cars') }}">Назад к списку</a>
</div>
@endsection 