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
.table-responsive {
    overflow-x: auto;
}

.accordion-button {
    font-weight: bold;
}

.accordion-body {
    background-color: #f8f9fa; /* Light background for the accordion body */
}

.bg-light {
    background-color: #f0f8ff; /* Light background for instructions */
}
.accordion-background{
    background: #3991de !important;
}

.alert {
    border-radius: 5px; /* Rounded corners for alerts */
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

                <form action="{{ route('crud.generator.store') }}" method="POST">
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
                                    <td><input type="text" class="form-control field-name-input" name="fields[0][name]" placeholder="Field name" required></td>
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

                    <div class="accordion mt-4 mb-3" id="accordionExample">
                        <div class="accordion-item border-0">
                            <h1 class="accordion-header" id="headingOne">
                                <button class="accordion-button bg-primary text-white accordion-background" type="button" id="guideline-modal-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    View Configuration
                                </button>
                            </h1>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="bg-light p-3 rounded mb-3">
                                        <h6><strong>📝 Field Selection Guidelines</strong></h6>
                                        <p>
                                            Configure fields for:
                                        </p>
                                        <ul>
                                            <li><strong>Create:</strong> 
                                                <span class="text-muted">If selected, this field will appear in the form when creating a new record.</span>
                                            </li>
                                            <li><strong>Edit:</strong> 
                                                <span class="text-muted">If selected, this field will be available when editing existing records.</span>
                                            </li>
                                            <li><strong>List:</strong> 
                                                <span class="text-muted">If selected, this field will appear in the list view (table display) of the records.</span>
                                            </li>
                                        </ul>
                                    </div>
                    
                                    <div class="alert alert-info mt-3">
                                        <h6><strong>🔍 Example:</strong></h6>
                                        <p>
                                            For a field like <code>name</code>, select options to include it in creation, editing, and listing.
                                        </p>
                                    </div>
                    
                                    <div class="alert alert-warning mt-3">
                                        <h6><strong>⚠️ Important:</strong></h6>
                                        <p>Choose only necessary fields to avoid clutter.</p>
                                    </div>
                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="field-selection-table">
                                            <thead>
                                                <tr>
                                                    <th>Field Name</th>
                                                    <th>Select All</th>
                                                    <th>Create</th>
                                                    <th>Edit</th>
                                                    <th>List</th>
                                                    <th>Input Type</th>
                                                    <th>Validation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Rows will be added here dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="reset" class="btn text-white" style="background: #294a74">Reset</button> <!-- Reset Button -->
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
                <td><input type="text" class="form-control field-name-input" name="fields[${fieldIndex}][name]" placeholder="Field name" required></td>
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
            viewFrom();
        });

        container.lastElementChild.querySelectorAll('select[name*="[type]"]').forEach(selectElement => {
            toggleDataTypes(selectElement);
            viewFrom();
        });
        
        const newFieldNameInput = container.lastElementChild.querySelector('.field-name-input');
        newFieldNameInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/\s+/g, '_');
            viewFrom();
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

    document.querySelectorAll('.field-name-input').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/\s+/g, '_');
        });
    });


    document.querySelectorAll('select[name*="[type]"]').forEach(selectElement => {
        selectElement.addEventListener('change', function() {
            toggleDataTypes(selectElement);
            viewFrom();
        });
        toggleDataTypes(selectElement);
        viewFrom();
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

        const relationshipRows = document.querySelectorAll('#relationship-container .relationship-row');
        relationshipRows.forEach(function (row) {
            const relationshipType = row.querySelector('select[name^="relationships"][name$="[type]"]').value;
            const relatedModel = row.querySelector('select[name^="relationships"][name$="[related_model]"]').value;
            const foreignKey = row.querySelector('input[name^="relationships"][name$="[foreign_key]"]').value;

            relationships.push({ relationshipType, relatedModel, foreignKey });
        });

        let migrationContent = `<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::create('${modelName.toLowerCase()}${modelName ? 's' : ''}', function (Blueprint $table) {\n            $table->id();\n`;

            fields.forEach(field => {
                let fieldLine = '';
                if (field.name) {
                    fieldLine += `            $table->${field.type}('${field.name}'${field.length ? `, ${field.length}` : ''})`;

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
                
                migrationContent += `${fieldLine}${field.name ? ';' : ''}\n`;
            });
            if (softDeleteEnabled) {
                migrationContent += `            $table->softDeletes();\n`;
            }

        migrationContent += `            $table->timestamps();\n        });\n    }\n\n    public function down(): void\n    {\n        Schema::dropIfExists('${modelName.toLowerCase()}${modelName ? 's' : ''}');\n    }\n};\n`;

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

        importStatements.forEach(importStatement => {
            modelContent += importStatement + '\n';
        });

        modelContent += `\nclass ${modelName} extends Model\n{\n    use HasFactory${softDeleteEnabled ? ', SoftDeletes' : ''};\n\n    protected $fillable = [\n`;

        const fillableFields = fields.map(field => `'${field.name}'`).join(',\n\t');
        modelContent += `        ${fillableFields}\n    ];\n\n`;

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
        });

        modelContent += `};\n`;

        const previewContent = `Migration:\n\n${migrationContent}\nModel:\n\n${modelContent}`;

        document.getElementById('preview-content').textContent = previewContent;
        $('#preview-modal').modal('show'); // Keeping this jQuery call as the modal might still be using Bootstrap's jQuery methods
    });

    document.getElementById('guideline-modal-button').addEventListener('click', function () {
        viewFrom();
    });

    function viewFrom() {
        const fieldContainer = document.querySelectorAll('#field-container .field-row');
        const tableBody = document.querySelector('#field-selection-table tbody');

        tableBody.innerHTML = '';

        fieldContainer.forEach(function (row) {
            const fieldName = row.querySelector('input[name^="fields"][name$="[name]"]').value;

            if (fieldName) {
                const tr = document.createElement('tr');
                const tdFieldName = document.createElement('td');
                tdFieldName.textContent = fieldName;
                tr.appendChild(tdFieldName);

                // Create the "Select All" checkbox
                const tdSelectAll = document.createElement('td');
                const selectAllCheckbox = document.createElement('input');
                selectAllCheckbox.type = 'checkbox';
                selectAllCheckbox.addEventListener('change', function() {
                    const checkboxes = tr.querySelectorAll('input[type="checkbox"].action-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                    manageInputTypeState(checkboxes, inputTypeSelect, checkboxValidation); // Manage input type and validation selection state
                });
                tdSelectAll.appendChild(selectAllCheckbox);
                tr.appendChild(tdSelectAll);

                // Create checkboxes for Create, Edit, List
                ['create', 'edit', 'list'].forEach(action => {
                    const td = document.createElement('td');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = `fieldNames[${fieldName}][${action}]`;
                    checkbox.classList.add('action-checkbox');
                    td.appendChild(checkbox);
                    tr.appendChild(td);

                    // Add event listener to enable/disable input type and validation based on checkbox states
                    checkbox.addEventListener('change', function() {
                        const checkboxes = tr.querySelectorAll('input[type="checkbox"].action-checkbox');
                        manageInputTypeState(checkboxes, inputTypeSelect, checkboxValidation);
                    });
                });

                // Create the HTML Input Type select dropdown
                const tdInputType = document.createElement('td');
                const inputTypeSelect = document.createElement('select');
                inputTypeSelect.classList.add('form-control');
                inputTypeSelect.name = `fieldNames[${fieldName}][input_type]`;

                // List of input types
                const inputTypes = ['text', 'number', 'date', 'email', 'password', 'checkbox', 'textarea'];
                inputTypes.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type;
                    option.textContent = type.charAt(0).toUpperCase() + type.slice(1);
                    inputTypeSelect.appendChild(option);
                });

                // Initially disable input type
                inputTypeSelect.disabled = true;
                tdInputType.appendChild(inputTypeSelect);
                tr.appendChild(tdInputType);

                // Create the Validation checkbox
                const tdValidation = document.createElement('td');
                const checkboxValidation = document.createElement('input');
                checkboxValidation.type = 'checkbox';
                checkboxValidation.name = `fieldNames[${fieldName}][validation]`;
                checkboxValidation.classList.add('action-checkbox');
                checkboxValidation.disabled = true;
                tdValidation.appendChild(checkboxValidation);
                tr.appendChild(tdValidation);

                // const tdValidationIcon = document.createElement('td');
                // const validationIcon = document.createElement('span');
                // validationIcon.classList.add('validation-icon');
                // validationIcon.innerHTML = '⚙️'; // Use an appropriate icon or emoji
                // tdValidationIcon.appendChild(validationIcon);
                // tr.appendChild(tdValidationIcon);

                tableBody.appendChild(tr);
            }
        });
    }

    // Manage input type and validation state based on checkbox selection
    function manageInputTypeState(checkboxes, inputTypeSelect, checkboxValidation) {
        const isCreateOrEditChecked = checkboxes[0].checked || checkboxes[1].checked; // Create or Edit checked
        const isListChecked = checkboxes[2].checked; // List checked

        // Enable input type and validation only if Create or Edit is checked, otherwise disable
        if (isCreateOrEditChecked) {
            inputTypeSelect.disabled = false;
            checkboxValidation.disabled = false;
        } else {
            inputTypeSelect.disabled = true;
            checkboxValidation.disabled = true;
        }

        // If only List is checked, disable input type and validation
        if (isListChecked && !isCreateOrEditChecked) {
            inputTypeSelect.disabled = true;
            checkboxValidation.disabled = true;
        }
    }
</script>
@endpush
