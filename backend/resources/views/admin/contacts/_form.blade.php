{{-- ========================================
    BASIC INFO
======================================== --}}

<div class="contact-form-card">

    <div class="contact-section-title">

        <i class='bx bx-buildings'></i>

        <span>
            Información institucional
        </span>

    </div>

    <!-- NAME -->

    <div class="contact-group">

        <label>
            Nombre de la unidad o contacto
        </label>

        <input type="text"
               name="name"

               id="contactName"

               class="contact-input"

               placeholder="Ej: Patrulla Caminera"

               value="{{ old('name', $contact->name ?? '') }}"

               required>

    </div>

    <!-- CATEGORY -->

    <div class="contact-group">

        <label>
            Categoría
        </label>

        <select name="contact_category_id"
                class="contact-input">

            <option value="">
                Sin categoría
            </option>

            @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    @selected(old('contact_category_id', $contact->contact_category_id ?? '') == $category->id)>

                    {{ $category->name }}

                </option>

            @endforeach

        </select>

        <small class="contact-help-text">

            Puedes crear nuevas categorías
            desde el apartado correspondiente.

        </small>

    </div>

    <!-- DESCRIPTION -->

    <div class="contact-group">

        <label>
            Descripción
        </label>

        <textarea name="description"
                  id="contactDescription"

                  class="contact-textarea"

                  placeholder="Describe brevemente la función de esta unidad o contacto...">{{ old('description', $contact->description ?? '') }}</textarea>

    </div>

</div>

{{-- ========================================
    CONTACT INFO
======================================== --}}

<div class="contact-form-card">

    <div class="contact-section-title">

        <i class='bx bx-phone'></i>

        <span>
            Información de contacto
        </span>

    </div>

    <!-- PHONE -->

    <div class="contact-group">

        <label>
            Número de contacto
        </label>

        <input type="text"
               name="phone"

               id="contactPhone"

               class="contact-input"

               placeholder="+591 4441234"

               value="{{ old('phone', $contact->phone ?? '') }}">

    </div>

    <!-- MAP -->

    <div class="contact-group">

        <label>
            URL de Google Maps
        </label>

        <input type="text"
               name="map_url"

               class="contact-input"

               placeholder="https://maps.google.com/..."

               value="{{ old('map_url', $contact->map_url ?? '') }}">

        <small class="contact-help-text">

            Se abrirá automáticamente desde
            el frontend público.

        </small>

    </div>

    <!-- LAT LNG -->

    <div class="contact-coordinates-grid">

        <div class="contact-group">

            <label>
                Latitud
            </label>

            <input type="text"
                   name="lat"

                   class="contact-input"

                   placeholder="-17.393"

                   value="{{ old('lat', $contact->lat ?? '') }}">

        </div>

        <div class="contact-group">

            <label>
                Longitud
            </label>

            <input type="text"
                   name="lng"

                   class="contact-input"

                   placeholder="-66.157"

                   value="{{ old('lng', $contact->lng ?? '') }}">

        </div>

    </div>

</div>

{{-- ========================================
    LOGO
======================================== --}}

<div class="contact-form-card">

    <div class="contact-section-title">

        <i class='bx bx-image'></i>

        <span>
            Imagen institucional
        </span>

    </div>

    <label class="contact-upload-box">

        <input type="file"
               name="logo"

               id="contactLogo"

               hidden>

        <div class="contact-upload-icon">

            <i class='bx bx-cloud-upload'></i>

        </div>

        <h4>
            Arrastra una imagen aquí
        </h4>

        <p>
            JPG, PNG • Máximo 5MB
        </p>

    </label>

    {{-- EXISTING IMAGE --}}

    @if(!empty($contact->logo_path))

        <div class="contact-existing-logo">

            <img src="{{ asset('storage/'.$contact->logo_path) }}"
                 alt="Logo actual"

                 class="contact-existing-image">

        </div>

    @endif

    <div id="contactPreview"></div>

</div>