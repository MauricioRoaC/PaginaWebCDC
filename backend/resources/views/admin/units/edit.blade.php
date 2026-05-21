@extends('layouts.admin')

@section('content')

<div class="unit-form-page">

    <!-- HEADER -->

    <div class="form-page-header">

        <div class="d-flex align-items-start gap-3">

            <a href="{{ route('admin.units.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
            </a>

            <div>

                <h1 class="form-page-title">
                    Editar unidad
                </h1>

                <p class="form-page-subtitle">
                    Actualiza la información de la unidad.
                </p>

            </div>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="row g-4">

        <!-- FORM -->

        <div class="col-xl-8">

            <form method="POST"
                  action="{{ route('admin.units.update', $unit) }}"
                  class="unit-form-card">

                @csrf
                @method('PUT')

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-buildings'></i>
                        Nombre de la unidad
                    </label>

                    <input type="text"
                           name="name"
                           class="modern-input"
                           value="{{ $unit->name }}"
                           required>

                </div>

                <div class="form-footer">

                    <button class="modern-btn">

                        <i class='bx bx-save'></i>
                        Actualizar unidad

                    </button>

                    <a href="{{ route('admin.units.index') }}"
                       class="cancel-btn">

                        <i class='bx bx-x'></i>
                        Cancelar

                    </a>

                </div>

            </form>

        </div>

        <!-- INFO -->

        <div class="col-xl-4">

            <div class="unit-info-panel">

                <h5>
                    Información
                </h5>

                <p>
                    Mantén nombres claros y cortos para facilitar la organización del sistema.
                </p>

                <div class="example-list">

                    <span>Ejemplos:</span>

                    <ul>
                        <li>FELCC</li>
                        <li>FELCN</li>
                        <li>DIPROVE</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection