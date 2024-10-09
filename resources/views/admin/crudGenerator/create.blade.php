@extends('layouts/layout')

@section('title', 'Admin Dashboard')

@section('page-style')
    @vite([])
@endsection

@section('page-script')
    @vite([])
@endsection

@section('content')
<style>
    /* Styles for the modal background and code preview */
modal-content {
    background-color: #1e1e1e; /* Dark background color */
    color: #f8f8f2; /* Light text color */
}

pre {
    background-color: #282a36; /* Background for the code */
    color: #f8f8f2; /* Text color for code */
    padding: 20px; /* Padding inside the pre element */
    border-radius: 5px; /* Rounded corners */
    overflow: auto; /* Allows scrolling for long code */
    white-space: pre-wrap; /* Preserve whitespace */
    font-family: 'Courier New', Courier, monospace; /* Monospace font for code */
}

</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Generate CURD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">CURD</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('crud.generator.model.generate') }}" method="POST">
                    @csrf
                    
                    <!-- Table Layout for Model Configuration -->
                    <div class="table-responsive mb-1">
                        <h5>Model Configuration</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><label for="model-name" class="form-label">Model Name</label></td>
                                    <td><input type="text" class="form-control" id="model-name" name="model_name" placeholder="Enter model name" required></td>
                                </tr>
                                <tr>
                                    <td><label for="create-route-checkbox" class="form-label">Auto-generate Routes</label></td>
                                    <td>
                                        <input type="checkbox" id="create-route-checkbox" name="create_route" value="1">
                                        <label class="form-check-label" for="create-route-checkbox">
                                            Enable automatic route generation for this model. This will automatically create routes for the model and make it accessible via the navigation menu.
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="softdelete-checkbox" class="form-label">Soft Deletes</label></td>
                                    <td>
                                        <input type="checkbox" id="softdelete-checkbox" name="softdelete" value="1">
                                        <label class="form-check-label" for="softdelete-checkbox">
                                            Enable soft deletes for this model, allowing the model records to be "deleted" without removing them from the database.
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Layout for Fields -->
                    <div class="table-responsive mb-1">
                        <h5>Migration Configuration</h5>
                        <table class="table table-bordered" id="fields-table">
                            <thead>
                                <tr>
                                    <th>Type of Method</th>
                                    <th>Field Name</th>
                                    <th>Length</th>
                                    <th>Nullable</th>
                                    <th>Unique</th>
                                    <th>Index</th>
                                    <th>Unsigned</th>
                                    <th>Default</th>
                                    <th>Comment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="field-container">
                                <tr class="field-row">
                                    <td>
                                        <select name="fields[0][type]" class="form-select" required>
                                            @foreach ([ 'bigInteger' => 'bigInteger()',
                                                        'binary' => 'binary()',
                                                        'boolean' => 'boolean()',
                                                        'char' => 'char()',
                                                        'dateTime' => 'dateTime()',
                                                        'date' => 'date()',
                                                        'decimal' => 'decimal()',
                                                        'double' => 'double()',
                                                        'float' => 'float()',
                                                        'integer' => 'integer()',
                                                        'ipAddress' => 'ipAddress()',
                                                        'json' => 'json()',
                                                        'longText' => 'longText()',
                                                        'macAddress' => 'macAddress()',
                                                        'mediumInteger' => 'mediumInteger()',
                                                        'mediumText' => 'mediumText()',
                                                        'smallInteger' => 'smallInteger()',
                                                        'string' => 'string()',
                                                        'text' => 'text()',
                                                        'time' => 'time()',
                                                        'tinyInteger' => 'tinyInteger()',
                                                        'tinyText' => 'tinyText()',
                                                        'unsignedBigInteger' => 'unsignedBigInteger()',
                                                        'unsignedInteger' => 'unsignedInteger()',
                                                        'unsignedMediumInteger' => 'unsignedMediumInteger()',
                                                        'unsignedSmallInteger' => 'unsignedSmallInteger()',
                                                        'unsignedTinyInteger' => 'unsignedTinyInteger()',
                                                        'uuid' => 'uuid()',
                                                        'year' => 'year()' ] as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="fields[0][name]" placeholder="Field name" required></td>
                                    <td><input type="number" class="form-control" name="fields[0][length]" placeholder="Length"></td>
                                    <td><input type="checkbox" name="fields[0][nullable]" value="nullable"></td>
                                    <td><input type="checkbox" name="fields[0][unique]" value="unique"></td>
                                    <td><input type="checkbox" name="fields[0][index]" value="index"></td>
                                    <td><input type="checkbox" name="fields[0][unsigned]" value="unsigned"></td>
                                    <td><input type="text" class="form-control" name="fields[0][default]" placeholder="Default value"></td>
                                    <td><input type="text" class="form-control" name="fields[0][comment]" placeholder="Comment"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-field">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>

                    <!-- Table Layout for Relationships -->
                    <div class="table-responsive mb-1">
                        <h5>Model Relationships</h5>
                        <table class="table table-bordered" id="relationships-table">
                            <thead>
                                <tr>
                                    <th>Relationship Type</th>
                                    <th>Related Model</th>
                                    <th>Foreign Key</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="relationship-container">
                                <tr class="relationship-row">
                                    <td>
                                        <select name="relationships[0][type]" class="form-select" required>
                                            @foreach (['hasOne', 'hasMany', 'belongsTo', 'belongsToMany'] as $relation)
                                                <option value="{{ $relation }}">{{ ucfirst($relation) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="relationships[0][related_model]" class="form-select related-model" required>
                                            @foreach ($modelNames as $modelName)
                                                <option value="{{ $modelName }}">{{ $modelName }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="relationships[0][foreign_key]" placeholder="Foreign Key" required></td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-relationship">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-secondary" id="add-relationship">Add Relationship</button>

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="reset" class="btn btn-secondary">Reset</button> <!-- Reset Button -->
                        <button type="button" class="btn btn-warning" id="preview-button">Preview</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>

                <div class="modal fade" id="preview-modal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel">Preview Generated CRUD</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre id="preview-content"></pre> <!-- Display preview content here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    let fieldIndex = 1;
    let relationshipIndex = 1;

    // Model names available for relationships
    const modelNames = @json($modelNames); // Use Laravel's json helper to pass PHP data to JS

    // Add new field row
    document.getElementById('add-field').addEventListener('click', function() {
        const container = document.getElementById('field-container');
        const row = `
            <tr class="field-row">
                <td>
                    <select name="fields[${fieldIndex}][type]" class="form-select" required>
                        @foreach ([ 'bigInteger' => 'bigInteger()',
                                    'binary' => 'binary()',
                                    'boolean' => 'boolean()',
                                    'char' => 'char()',
                                    'dateTime' => 'dateTime()',
                                    'date' => 'date()',
                                    'decimal' => 'decimal()',
                                    'double' => 'double()',
                                    'float' => 'float()',
                                    'integer' => 'integer()',
                                    'ipAddress' => 'ipAddress()',
                                    'json' => 'json()',
                                    'longText' => 'longText()',
                                    'macAddress' => 'macAddress()',
                                    'mediumInteger' => 'mediumInteger()',
                                    'mediumText' => 'mediumText()',
                                    'smallInteger' => 'smallInteger()',
                                    'string' => 'string()',
                                    'text' => 'text()',
                                    'time' => 'time()',
                                    'tinyInteger' => 'tinyInteger()',
                                    'tinyText' => 'tinyText()',
                                    'unsignedBigInteger' => 'unsignedBigInteger()',
                                    'unsignedInteger' => 'unsignedInteger()',
                                    'unsignedMediumInteger' => 'unsignedMediumInteger()',
                                    'unsignedSmallInteger' => 'unsignedSmallInteger()',
                                    'unsignedTinyInteger' => 'unsignedTinyInteger()',
                                    'uuid' => 'uuid()',
                                    'year' => 'year()' ] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" name="fields[${fieldIndex}][name]" placeholder="Field name" required></td>
                <td><input type="number" class="form-control" name="fields[${fieldIndex}][length]" placeholder="Length"></td>
                <td><input type="checkbox" name="fields[${fieldIndex}][nullable]" value="nullable"></td>
                <td><input type="checkbox" name="fields[${fieldIndex}][unique]" value="unique"></td>
                <td><input type="checkbox" name="fields[${fieldIndex}][index]" value="index"></td>
                <td><input type="checkbox" name="fields[${fieldIndex}][unsigned]" value="unsigned"></td>
                <td><input type="text" class="form-control" name="fields[${fieldIndex}][default]" placeholder="Default value"></td>
                <td><input type="text" class="form-control" name="fields[${fieldIndex}][comment]" placeholder="Comment"></td>
                <td>
                    <button type="button" class="btn btn-danger remove-field">Remove</button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', row);
        const selectElement = container.lastElementChild.querySelector('select[name*="[type]"]');
        selectElement.addEventListener('change', function() {
            toggleDataTypes(selectElement);
        });
        fieldIndex++;
    });

    function toggleDataTypes(selectElement) {
        const fieldRowElement = selectElement.closest('.field-row');

        if (fieldRowElement) {
            const nullableCheckbox = fieldRowElement.querySelector('input[name*="[nullable]"]');
            const uniqueCheckbox = fieldRowElement.querySelector('input[name*="[unique]"]');
            const indexCheckbox = fieldRowElement.querySelector('input[name*="[index]"]');
            const unsignedCheckbox = fieldRowElement.querySelector('input[name*="[unsigned]"]');
            const lengthInput = fieldRowElement.querySelector('input[name*="[length]"]');
            const defaultInput = fieldRowElement.querySelector('input[name*="[default]"]');
            const commentInput = fieldRowElement.querySelector('input[name*="[comment]"]');

            const allowedUnsignedTypes = ['integer', 'tinyInteger', 'mediumInteger', 'bigInteger', 'smallInteger', 'unsignedBigInteger', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'float', 'double', 'decimal'];
            const noLengthRequiredTypes = ['integer', 'tinyInteger', 'mediumInteger', 'bigInteger', 'smallInteger', 'unsignedBigInteger', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'binary', 'boolean', 'text', 'date', 'dateTime', 'time', 'json', 'uuid', 'foreignId', 'mediumText', 'longText', 'year'];
            const noDefualtRequiredTypes = ['text', 'mediumText', 'longText', 'tinyText', 'binary', 'json'];
            const defualtNumberTypeInput = ['integer', 'bigInteger', 'mediumInteger', 'mediumInteger', 'smallInteger', 'tinyInteger', 'unsignedBigInteger', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger'];
            const noUniqueRequiredTypes = ['boolean', 'binary', 'text', 'mediumText', 'longText', 'tinyText', 'json'];
            const noIndexRequiredTypes = ['boolean', 'binary', 'text', 'mediumText', 'longText', 'tinyText', 'json'];
            const floatTypes = ['float', 'double', 'decimal'];

            // Reset all inputs before applying new settings
            if (nullableCheckbox) {
                nullableCheckbox.checked = false;
                nullableCheckbox.disabled = false;
            }
            if (unsignedCheckbox) {
                unsignedCheckbox.checked = false;
                unsignedCheckbox.disabled = false;
            }
            if (uniqueCheckbox) {
                uniqueCheckbox.checked = false;
                uniqueCheckbox.disabled = false;
            }
            if (indexCheckbox) {
                indexCheckbox.checked = false;
                indexCheckbox.disabled = false;
            }
            if (lengthInput) {
                lengthInput.value = '';
                lengthInput.disabled = false;
            }
            if (defaultInput) {
                defaultInput.value = '';
                defaultInput.type = 'text';
                defaultInput.placeholder = 'Default value';
            }
            if (commentInput) {
                commentInput.value = '';
                commentInput.type = 'text';
                commentInput.placeholder = 'Comment';
            }

            if (unsignedCheckbox) {
                unsignedCheckbox.disabled = !allowedUnsignedTypes.includes(selectElement.value);
                if (!unsignedCheckbox.disabled) {
                    unsignedCheckbox.checked = false;
                }
            }

            if (uniqueCheckbox) {
                uniqueCheckbox.disabled = noUniqueRequiredTypes.includes(selectElement.value);
            }

            if (indexCheckbox) {
                indexCheckbox.disabled = noIndexRequiredTypes.includes(selectElement.value);
            }

            if (lengthInput) {
                lengthInput.disabled = noLengthRequiredTypes.includes(selectElement.value);
                if (lengthInput.disabled) {
                    lengthInput.value = '';
                }
                if (floatTypes.includes(selectElement.value)) {
                    lengthInput.style.display = 'none';
                    lengthInput.type = 'text';
                    lengthInput.readOnly = true;
                    let precisionInput = fieldRowElement.querySelector('input[name="precision"]');
                    if (!precisionInput) {
                        precisionInput = document.createElement('input');
                        precisionInput.type = 'number';
                        precisionInput.name = 'precision';
                        precisionInput.placeholder = 'Precision (1-24)';
                        precisionInput.min = 1;
                        precisionInput.max = 24;
                        precisionInput.classList.add('form-control');
                        precisionInput.style.width = '48%';
                        precisionInput.style.display = 'inline-block';
                        precisionInput.style.marginRight = '5px';
                        lengthInput.insertAdjacentElement('afterend', precisionInput);
                    }

                    let scaleInput = fieldRowElement.querySelector('input[name="scale"]');
                    if (!scaleInput) {
                        scaleInput = document.createElement('input');
                        scaleInput.type = 'number';
                        scaleInput.name = 'scale';
                        scaleInput.placeholder = 'Scale (0-10)';
                        scaleInput.min = 0;
                        scaleInput.max = 10;
                        scaleInput.classList.add('form-control');
                        scaleInput.style.width = '49%';
                        scaleInput.style.display = 'inline-block';
                        precisionInput.insertAdjacentElement('afterend', scaleInput);
                    }
                    const updateLengthInput = function () {
                        const precisionValue = precisionInput.value;
                        const scaleValue = scaleInput.value;

                        if (precisionValue && scaleValue) {
                            lengthInput.value = `${precisionValue}, ${scaleValue}`;
                        } else {
                            lengthInput.value = '';
                        }
                    };

                    precisionInput.addEventListener('input', updateLengthInput);
                    scaleInput.addEventListener('input', updateLengthInput);
                    precisionInput.value = '';
                    scaleInput.value = '';
                } else {
                    let precisionInput = fieldRowElement.querySelector('input[name="precision"]');
                    let scaleInput = fieldRowElement.querySelector('input[name="scale"]');
                    if (precisionInput) {
                        precisionInput.remove();
                    }
                    if (scaleInput) {
                        scaleInput.remove();
                    }
                    lengthInput.style.display = 'block';
                    lengthInput.type = 'number';
                    lengthInput.readOnly = false;
                    lengthInput.placeholder = 'Length';
                    lengthInput.value = '';
                    lengthInput.min = 0;
                }
            }

            if (defaultInput) {
                if (selectElement.value === 'boolean') {
                    defaultInput.type = 'number';
                    defaultInput.placeholder = 'Enter 1 (True) or 0 (False)';
                    defaultInput.value = '';
                    defaultInput.min = 0;
                    defaultInput.max = 1;
                } else if (defualtNumberTypeInput.includes(selectElement.value)) {
                    defaultInput.type = 'number';
                    defaultInput.placeholder = 'Default value';
                    defaultInput.value = '';
                    defaultInput.min = 0;
                } else if (selectElement.value === 'date') {
                    defaultInput.type = 'date';
                    defaultInput.placeholder = 'Select a date';
                    defaultInput.value = '';
                    defaultInput.min = '';
                } else if (selectElement.value === 'dateTime') {
                    defaultInput.type = 'datetime-local';
                    defaultInput.placeholder = 'Select a date time';
                    defaultInput.value = '';
                    defaultInput.min = '';
                } else if (selectElement.value === 'time') {
                    defaultInput.type = 'time';
                    defaultInput.placeholder = 'Select a time';
                    defaultInput.value = '';
                    defaultInput.min = '';
                } else if (selectElement.value === 'year') {
                    defaultInput.type = 'number';
                    defaultInput.placeholder = 'Please Enter 4 digit year';
                    defaultInput.min = 1900;
                    defaultInput.max = 2100;
                    defaultInput.value = '';
                } else if (floatTypes.includes(selectElement.value)) {
                    defaultInput.type = 'number';
                    defaultInput.placeholder = 'Default value';
                    defaultInput.value = '';
                    defaultInput.min = 0;
                } else {
                    defaultInput.type = 'text';
                    defaultInput.placeholder = 'Default value';
                    defaultInput.value = '';
                    defaultInput.min = '';
                    defaultInput.max = '';
                }

                if (noDefualtRequiredTypes.includes(selectElement.value)) {
                    defaultInput.disabled = true;
                    defaultInput.value = '';
                } else {
                    defaultInput.disabled = false;
                }
            }
        }
    }


    document.querySelectorAll('select[name*="[type]"]').forEach(selectElement => {
        selectElement.addEventListener('change', function() {
            toggleDataTypes(selectElement);
        });
        toggleDataTypes(selectElement);
    });

    // Add new relationship row
    document.getElementById('add-relationship').addEventListener('click', function() {
        const container = document.getElementById('relationship-container');
        const row = `
            <tr class="relationship-row">
                <td>
                    <select name="relationships[${relationshipIndex}][type]" class="form-select" required>
                        @foreach (['hasOne', 'hasMany', 'belongsTo', 'belongsToMany'] as $relation)
                            <option value="{{ $relation }}">{{ ucfirst($relation) }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="relationships[${relationshipIndex}][related_model]" class="form-select related-model" required>
                        @foreach ($modelNames as $modelName)
                            <option value="{{ $modelName }}">{{ $modelName }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" name="relationships[${relationshipIndex}][foreign_key]" placeholder="Foreign Key" required></td>
                <td>
                    <button type="button" class="btn btn-danger remove-relationship">Remove</button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', row);
        relationshipIndex++;
    });

    // Event delegation for removing field rows
    document.getElementById('fields-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field')) {
            e.target.closest('.field-row').remove();
        }
    });

    // Event delegation for removing relationship rows
    document.getElementById('relationships-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-relationship')) {
            e.target.closest('.relationship-row').remove();
        }
    });

    document.getElementById('preview-button').addEventListener('click', function () {
        const modelName = document.getElementById('model-name').value;
        const softDeleteEnabled = document.getElementById('softdelete-checkbox').checked;
        const fields = [];
        const relationships = [];

        // Get fields data
        const fieldRows = document.querySelectorAll('#field-container .field-row');
        fieldRows.forEach(function (row) {
            const fieldName = row.querySelector('input[name^="fields"][name$="[name]"]').value;
            const fieldType = row.querySelector('select[name^="fields"][name$="[type]"]').value;
            const fieldLength = row.querySelector('input[name^="fields"][name$="[length]"]').value;
            const fieldNullable = row.querySelector('input[name^="fields"][name$="[nullable]"]').checked;
            const fieldUnique = row.querySelector('input[name^="fields"][name$="[unique]"]').checked;
            const fieldIndex = row.querySelector('input[name^="fields"][name$="[index]"]').checked;
            const fieldUnsigned = row.querySelector('input[name^="fields"][name$="[unsigned]"]').checked;
            const fieldDefault = row.querySelector('input[name^="fields"][name$="[default]"]').value;
            const fieldComment = row.querySelector('input[name^="fields"][name$="[comment]"]').value;

            fields.push({
                name: fieldName,
                type: fieldType,
                length: fieldLength,
                nullable: fieldNullable,
                unique: fieldUnique,
                index: fieldIndex,
                unsigned: fieldUnsigned,
                default: fieldDefault,
                comment: fieldComment
            });
        });

        // Get relationships data
        const relationshipRows = document.querySelectorAll('#relationship-container .relationship-row');
        relationshipRows.forEach(function (row) {
            const relationshipType = row.querySelector('select[name^="relationships"][name$="[type]"]').value;
            const relatedModel = row.querySelector('select[name^="relationships"][name$="[related_model]"]').value;
            const foreignKey = row.querySelector('input[name^="relationships"][name$="[foreign_key]"]').value;

            relationships.push({ relationshipType, relatedModel, foreignKey });
        });

        // Prepare migration content
        let migrationContent = `<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::create('${modelName.toLowerCase()}${modelName ? 's' : ''}', function (Blueprint $table) {\n            $table->id();\n`;

            fields.forEach(field => {
                let fieldLine = '';
                if (field.name) {
                    fieldLine += `            $table->${field.type}('${field.name}'${field.length ? `, ${field.length}` : ''})`;

                    // Add unsigned for integer types if specified
                    if (['integer', 'tinyInteger', 'mediumInteger', 'bigInteger', 'unsignedBigInteger', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'float', 'double', 'decimal'].includes(field.type) && field.unsigned) {
                        fieldLine += '->unsigned()';
                    }

                    if (field.nullable) fieldLine += '->nullable()';
                    if (field.default) {
                        if (field.type === 'boolean' || ['integer', 'tinyInteger', 'mediumInteger', 'bigInteger', 'smallInteger', 'unsignedBigInteger', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'float', 'double', 'decimal'].includes(field.type)) {
                            fieldLine += `->default(${field.default})`;
                        } else {
                            fieldLine += `->default('${field.default}')`;
                        }
                    } 
                    if (field.unique) fieldLine += '->unique()';
                    if (field.index) fieldLine += '->index()';
                    if (field.comment) fieldLine += `->comment('${field.comment}')`;
                }
                

                // Finalize the line
                migrationContent += `${fieldLine}${field.name ? ';' : ''}\n`;
            });
            if (softDeleteEnabled) {
                migrationContent += `            $table->softDeletes();\n`;
            }

        migrationContent += `            $table->timestamps();\n        });\n    }\n\n    public function down(): void\n    {\n        Schema::dropIfExists('${modelName.toLowerCase()}${modelName ? 's' : ''}');\n    }\n};\n`;

        // Prepare model content
        let modelContent = `<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;\nuse Illuminate\\Database\\Eloquent\\Model;\n`;
        let importStatements = new Set();
        if (softDeleteEnabled) {
            importStatements.add('use Illuminate\\Database\\Eloquent\\SoftDeletes;');
        }
        relationships.forEach(relationship => {
            if (relationship.relationshipType === 'belongsTo') {
                importStatements.add('use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;');
            } else if (relationship.relationshipType === 'hasMany') {
                importStatements.add('use Illuminate\\Database\\Eloquent\\Relations\\HasMany;');
            } else if (relationship.relationshipType === 'hasOne') {
                importStatements.add('use Illuminate\\Database\\Eloquent\\Relations\\HasOne;');
            } else if (relationship.relationshipType === 'belongsToMany') {
                importStatements.add('use Illuminate\\Database\\Eloquent\\Relations\\BelongsToMany;');
            }
        });

        // Join the import statements into a single string
        importStatements.forEach(importStatement => {
            modelContent += importStatement + '\n';
        });

        modelContent += `\nclass ${modelName} extends Model\n{\n    use HasFactory${softDeleteEnabled ? ', SoftDeletes' : ''};\n\n    protected $fillable = [\n`;

        const fillableFields = fields.map(field => `'${field.name}'`).join(',\n\t');
        modelContent += `        ${fillableFields}\n    ];\n\n`;

        // Add relationship methods to model content
        relationships.forEach(relationship => {
            const relatedModelLowerCase = relationship.relatedModel.toLowerCase();
            
            if (relationship.relationshipType === 'belongsTo') {
                modelContent += `    public function ${relatedModelLowerCase}(): BelongsTo\n    {\n        return $this->belongsTo(${relationship.relatedModel}::class, '${relationship.foreignKey}');\n    }\n\n`;
            } else if (relationship.relationshipType === 'hasMany') {
                modelContent += `    public function ${relatedModelLowerCase}s(): HasMany\n    {\n        return $this->hasMany(${relationship.relatedModel}::class, '${relationship.foreignKey}');\n    }\n\n`;
            } else if (relationship.relationshipType === 'hasOne') {
                modelContent += `    public function ${relatedModelLowerCase}(): HasOne\n    {\n        return $this->hasOne(${relationship.relatedModel}::class, '${relationship.foreignKey}');\n    }\n\n`;
            } else if (relationship.relationshipType === 'belongsToMany') {
                modelContent += `    public function ${relatedModelLowerCase}s(): BelongsToMany\n    {\n        return $this->belongsToMany(${relationship.relatedModel}::class);\n    }\n\n`;
            } 
            // Add more relationship types as needed
        });

        modelContent += `};\n`;

        // Combine migration and model content
        const previewContent = `Migration:\n\n${migrationContent}\nModel:\n\n${modelContent}`;

        // Show preview in modal
        document.getElementById('preview-content').textContent = previewContent;
        $('#preview-modal').modal('show'); // Keeping this jQuery call as the modal might still be using Bootstrap's jQuery methods
    });



    
</script>
@endpush
