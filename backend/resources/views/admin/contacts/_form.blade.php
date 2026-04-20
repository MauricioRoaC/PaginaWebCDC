<div class="mb-3">
    <label class="form-label">Nombre del contacto / unidad</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $contact->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Categoría</label>
    <select name="contact_category_id" class="form-select">
        <option value="">Sin categoría</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @selected(old('contact_category_id', $contact->contact_category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <small class="text-muted">Si no existe, créala en "Categorías de contacto".</small>
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" rows="3"
              class="form-control">{{ old('description', $contact->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Número de contacto</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $contact->phone ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">URL de Google Maps</label>
    <input type="text" name="map_url" class="form-control"
           value="{{ old('map_url', $contact->map_url ?? '') }}">
    <small class="text-muted">Pega aquí el enlace de Google Maps (se abrirá al hacer clic en el marcador).</small>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Latitud</label>
        <input type="text" name="lat" class="form-control"
               value="{{ old('lat', $contact->lat ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Longitud</label>
        <input type="text" name="lng" class="form-control"
               value="{{ old('lng', $contact->lng ?? '') }}">
    </div>
</div>
<small class="text-muted d-block mb-3">
    Puedes copiar latitud/longitud desde Google Maps (clic derecho → "¿Qué hay aquí?").
</small>

<div class="mb-3">
    <label class="form-label">Logo / Imagen (opcional)</label>
    <input type="file" name="logo" class="form-control">
    @if(!empty($contact->logo_path))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$contact->logo_path) }}" alt="" style="max-height: 60px;">
        </div>
    @endif
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible"
           value="1" {{ old('is_visible', $contact->is_visible ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_visible">Visible en la página pública</label>
</div>
