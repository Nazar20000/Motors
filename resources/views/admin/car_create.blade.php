@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@extends('layout.app')

@section('title-block')
    Добавить автомобиль
@endsection

@section('content')
<div class="admin-content">
    <h1>Добавить автомобиль</h1>
    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        <label>Марка:
            <input type="text" name="brand" value="{{ old('brand') }}" required>
        </label>
        <label>Модель:
            <input type="text" name="model" value="{{ old('model') }}" required>
        </label>
        <label>Год:
            <input type="number" name="year" value="{{ old('year') }}" required>
        </label>
        <label>Цена:
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
        </label>
        <label>Описание:
            <textarea name="description">{{ old('description') }}</textarea>
        </label>
        <label class="file-label">
            <span>Фотографии (можно выбрать несколько):</span>
            <input type="file" name="images[]" multiple accept="image/*" style="display:none;" id="images-input-create">
        </label>
        <div id="preview-create" style="display:flex;gap:10px;flex-wrap:wrap;"></div>
        <label><input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }}> Опубликовать</label>
        <button type="submit">Сохранить</button>
    </form>
    @push('scripts')
    <script>
        const inputCreate = document.getElementById('images-input-create');
        const previewCreate = document.getElementById('preview-create');
        let filesCreate = [];
        if(inputCreate) {
            inputCreate.addEventListener('change', function() {
                // Добавляем новые файлы к массиву
                for (let file of this.files) {
                    if(file.type.startsWith('image/')) {
                        filesCreate.push(file);
                    }
                }
                renderPreviewsCreate();
                updateInputFilesCreate();
            });
            // Клик по label открывает input
            inputCreate.previousElementSibling.addEventListener('click', function() {
                inputCreate.click();
            });
        }
        function renderPreviewsCreate() {
            previewCreate.innerHTML = '';
            filesCreate.forEach((file, idx) => {
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
                        filesCreate.splice(idx, 1);
                        renderPreviewsCreate();
                        updateInputFilesCreate();
                    };
                    wrapper.appendChild(img);
                    wrapper.appendChild(del);
                    previewCreate.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }
        function updateInputFilesCreate() {
            // Обновляем input type=file через DataTransfer
            const dt = new DataTransfer();
            filesCreate.forEach(f => dt.items.add(f));
            inputCreate.files = dt.files;
        }
    </script>
    @endpush
    <br>
    <a href="{{ route('admin.cars') }}">Назад к списку</a>
</div>
@endsection 