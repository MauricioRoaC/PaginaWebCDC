@extends('layouts.admin')

@section('content')

<div class="news-create-page">

    <!-- HEADER -->
    <div class="news-create-header">
        <div class="d-flex align-items-start gap-3">
            <a href="{{ route('admin.news.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
            </a>
            <div>
                <h1 class="create-news-title">Editar noticia</h1>
                <p class="create-news-subtitle">Actualiza el contenido editorial y multimedia.</p>
            </div>
        </div>

        <!-- STATUS -->
        <div class="editor-status">
            <div class="status-dot"></div>
            <span>Edición activa</span>
        </div>
    </div>

    <!-- ERRORS -->
    @if($errors->any())
        <div class="modern-alert danger-alert">
            <div class="modern-alert-icon">
                <i class='bx bx-error-circle'></i>
            </div>
            <div>
                <h6>Ocurrió un error</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- FORM -->
    <form action="{{ route('admin.news.update', $news) }}"
          method="POST"
          enctype="multipart/form-data"
          id="newsForm">

        @csrf
        @method('PUT')

        <input type="hidden" name="main_image_index" id="mainImageIndex" value="0">

        <div class="row g-4">

            <!-- LEFT SIDE -->
            <div class="col-xl-8">
                <div class="news-editor-card">

                    <!-- TITLE -->
                    <div class="modern-group">
                        <label class="modern-label">
                            <i class='bx bx-text'></i> Título principal
                        </label>
                        <input type="text"
                               name="title"
                               class="modern-input"
                               value="{{ old('title', $news->title) }}"
                               placeholder="Título de la noticia..."
                               maxlength="255"
                               required>

                        <!-- SLUG -->
                        <div class="slug-preview">
                            <i class='bx bx-link'></i>
                            <span id="slugPreview">/noticias/{{ $news->slug }}</span>
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="modern-group mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="modern-label mb-0">
                                <i class='bx bx-align-left'></i> Descripción corta
                            </label>
                            <span class="character-counter">
                                <span id="descriptionCount">{{ strlen(old('description', $news->description)) }}</span>/500
                            </span>
                        </div>
                        <textarea name="description"
                                  id="descriptionInput"
                                  class="modern-textarea"
                                  rows="4"
                                  maxlength="500"
                                  required>{{ old('description', $news->description) }}</textarea>
                    </div>

                    <!-- BODY -->
                    <div class="modern-group mt-4">
                        <label class="modern-label">
                            <i class='bx bx-news'></i> Contenido completo
                        </label>

                        <!-- QUILL EDITOR -->
                        <div id="editor">
                            {!! old('body', $news->body) !!}
                        </div>

                        <!-- REAL TEXTAREA -->
                        <textarea name="body" id="bodyInput" hidden>{{ old('body', $news->body) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-xl-4">

                <!-- PUBLISH CARD -->
                <div class="side-card">
                    <div class="side-card-header">
                        <h5>Configuración</h5>
                    </div>

                    <!-- STATUS -->
                    <div class="modern-group">
                        <label class="modern-label">
                            <i class='bx bx-check-circle'></i> Estado
                        </label>
                        <select name="status" class="modern-input modern-select" required>
                            <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Guardar borrador</option>
                            <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Publicar ahora</option>
                            <option value="scheduled" {{ old('status', $news->status) === 'scheduled' ? 'selected' : '' }}>Programar publicación</option>
                        </select>
                    </div>

                    <!-- SCHEDULE -->
                    <div class="modern-group mt-4" id="scheduleGroup" style="{{ old('status', $news->status) === 'scheduled' ? '' : 'display:none;' }}">
                        <label class="modern-label">
                            <i class='bx bx-calendar'></i> Fecha programada
                        </label>
                        <input type="datetime-local"
                               name="scheduled_at"
                               class="modern-input"
                               value="{{ old('scheduled_at', $news->scheduled_at ? \Carbon\Carbon::parse($news->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <!-- CURRENT IMAGES -->
                <div class="side-card mt-4">
                    <div class="side-card-header">
                        <h5>Imágenes actuales</h5>
                    </div>

                    @if($news->images && $news->images->count())
                        <div class="current-images-grid">
                            @foreach($news->images as $img)
                                <div class="current-image-item">
                                    <img src="{{ asset('storage/'.$img->path) }}" alt="">
                                    <div class="current-image-overlay">
                                        @if($img->is_main)
                                            <span class="main-badge active-main">
                                                <i class='bx bxs-star'></i> Portada
                                            </span>
                                        @endif
                                        <button type="button" class="remove-image">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="replace-warning">
                            <i class='bx bx-info-circle'></i>
                            <span>Si subes nuevas imágenes, reemplazarán las actuales.</span>
                        </div>
                    @else
                        <div class="empty-gallery">
                            <i class='bx bx-image'></i>
                            <p>Esta noticia no tiene imágenes.</p>
                        </div>
                    @endif
                </div>

                <!-- NEW IMAGES (REPLACE) -->
                <div class="side-card mt-4">
                    <div class="side-card-header">
                        <h5>Reemplazar imágenes</h5>
                    </div>

                    <!-- DROPZONE -->
                    <label class="upload-area" id="dropZone" for="imageInput">
                        <input type="file" name="images[]" id="imageInput" multiple hidden>
                        <div class="upload-icon">
                            <i class='bx bx-cloud-upload'></i>
                        </div>
                        <h6>Arrastra imágenes aquí</h6>
                        <p>o haz clic para seleccionar</p>
                        <div class="drag-status">Esperando imágenes...</div>
                    </label>

                    <!-- COUNTER -->
                    <div class="gallery-top mt-3">
                        <span class="gallery-counter">
                            <i class='bx bx-image'></i>
                            <span id="imageCount">0</span>/10 imágenes
                        </span>
                    </div>

                    <!-- PREVIEW -->
                    <div id="imagePreview" class="image-preview-grid"></div>
                </div>

            </div>
        </div>

        <!-- FOOTER -->
        <div class="editor-footer">
            <a href="{{ route('admin.news.index') }}" class="cancel-btn">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="modern-btn">
                <i class='bx bx-save'></i> Actualizar noticia
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Quill === 'undefined') {
        console.error('Quill no cargó');
        return;
    }

    // Inicialización del editor Quill
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Escribe el contenido de la noticia...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Enlace de inputs y formulario
    const form = document.getElementById('newsForm');
    const bodyInput = document.getElementById('bodyInput');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imageCount = document.getElementById('imageCount');
    const descriptionInput = document.getElementById('descriptionInput');
    const descriptionCount = document.getElementById('descriptionCount');
    
    let selectedFiles = [];
    let currentMainImage = 0;

    // Contador de caracteres para la descripción
    if(descriptionInput) {
        descriptionInput.addEventListener('input', function() {
            descriptionCount.textContent = this.value.length;
        });
        descriptionCount.textContent = descriptionInput.value.length;
    }

    // DRAG & DROP EVENTOS
    const dropZone = document.getElementById('dropZone');
    const dragStatus = document.querySelector('.drag-status');

    dropZone.addEventListener('dragover', function(e){
        e.preventDefault();
        dropZone.classList.add('dragging');
        dragStatus.innerHTML = 'Suelta las imágenes aquí';
    });

    dropZone.addEventListener('dragleave', function(){
        dropZone.classList.remove('dragging');
        dragStatus.innerHTML = 'Esperando imágenes...';
    });

    dropZone.addEventListener('drop', function(e){
        e.preventDefault();
        dropZone.classList.remove('dragging');
        dragStatus.innerHTML = 'Imágenes agregadas';

        const files = [...e.dataTransfer.files];
        files.forEach(file => {
            if(selectedFiles.length >= 10) return;
            if(file.type.startsWith('image/')){
                selectedFiles.push(file);
            }
        });
        renderImages();
    });

    // Cambio del input de tipo file clásico
    imageInput.addEventListener('change', function(e){
        const files = [...e.target.files];
        files.forEach(file => {
            if(selectedFiles.length >= 10) return;
            selectedFiles.push(file);
        });
        renderImages();
    });

    // Función para renderizar miniaturas y sincronizar archivos con el input real (API DataTransfer)
    function renderImages(){
        imagePreview.innerHTML = '';
        imageCount.textContent = selectedFiles.length;

        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e){
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}">
                    <div class="preview-overlay">
                        ${index === currentMainImage
                            ? `<button type="button" class="main-badge active-main" data-main="${index}">
                                <i class='bx bxs-star'></i> Portada
                               </button>`
                            : `<button type="button" class="main-badge" data-main="${index}">
                                <i class='bx bx-star'></i> Elegir portada
                               </button>`
                        }
                        <button type="button" class="remove-image" data-index="${index}">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                `;
                imagePreview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }

    // Eliminar imágenes de la lista de subida
    document.addEventListener('click', function(e){
        const btn = e.target.closest('.remove-image[data-index]');
        if(!btn) return;

        const index = Number(btn.dataset.index);
        selectedFiles.splice(index, 1);
        
        if (currentMainImage >= selectedFiles.length && selectedFiles.length > 0) {
            currentMainImage = selectedFiles.length - 1;
        } else if(selectedFiles.length === 0) {
            currentMainImage = 0;
        }
        document.getElementById('mainImageIndex').value = currentMainImage;

        renderImages();
    });

    // Asignar imagen de Portada
    document.addEventListener('click', function(e){
        const btn = e.target.closest('[data-main]');
        if(!btn) return;

        currentMainImage = Number(btn.dataset.main);
        document.getElementById('mainImageIndex').value = currentMainImage;
        renderImages();
    });

    // Traspasar el contenido de Quill al Textarea oculto antes del envío limpiando saltos vacíos
    form.addEventListener('submit', function(e) {
        let content = quill.root.innerHTML;
        if (content === '<p><br></p>') {
            content = '';
        }
        bodyInput.value = content;
    });

    // INTERRUPTOR DE ESTADO / FECHA PROGRAMADA
    const statusSelect = document.querySelector('[name="status"]');
    const scheduleGroup = document.getElementById('scheduleGroup');

    function toggleSchedule(){
        if(statusSelect.value === 'scheduled'){
            scheduleGroup.style.display = 'block';
        } else {
            scheduleGroup.style.display = 'none';
        }
    }

    statusSelect.addEventListener('change', toggleSchedule);
    toggleSchedule();

    // AUTO SLUG
    const titleInput = document.querySelector('[name="title"]');
    const slugPreview = document.getElementById('slugPreview');

    function generateSlug(text){
        return text
            .toLowerCase()
            .trim()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    function updateSlug(){
        const slug = generateSlug(titleInput.value);
        slugPreview.textContent = '/noticias/' + slug;
    }

    titleInput.addEventListener('input', updateSlug);
});
</script>
@endpush