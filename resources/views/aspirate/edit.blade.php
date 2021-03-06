@extends('layouts.app')
@section('title') Edit : Aspirate Report @endsection

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Listings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('aspirate.create') }}">Aspirate Create</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="">
                        <h4 class="text-capitalize fw-bold">
                            Edit Aspirate Reports
                        </h4>
                    </div>
                    <hr>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('aspirate.update',$aspirate->id) }}" id="aspirateUpdateForm" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                    </form>
                    <div class="row g-5">
                        <div class="col-12 col-lg-6 right-divider">

                            <div class="mb-3">
                                <label class="form-label">Photos</label>
                                <div class="rounded p-2 d-flex overflow-scroll">
                                    <form action="{{ route('aspirate_photos.store') }}" method="post" class="d-none" id="photoUploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="aspirate_id" value="{{ $aspirate->id }}">
                                        <div class="mb-3">
                                            <input type="file" name="aspirate_photos[]" id="inputPhotos" class="@error('aspirate_photos') is-invalid @enderror" multiple accept="image/jpeg,image/png">
                                            @error('aspirate_photos')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                            @error('aspirate_photos.*')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button class="btn btn-primary">Upload</button>
                                    </form>

                                    <div class="border border-2 rounded border-primary uploader-ui me-1 d-flex justify-content-center align-items-center px-4" id="photoUploadUi">
                                        <i class="fa-regular fa-images text-primary fa-2x fa-fw"></i>
                                    </div>

                                    @forelse($aspirate->aspiratePhotos as $photo)
                                        <div class="position-relative">
                                            <form action="{{ route('aspirate_photos.destroy',$photo->id) }}" class="position-absolute bottom-0 start-0" id="delForm{{ $photo->id }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="img-delete-btn rounded shadow-sm" onclick="return askConfirm({{ $photo->id }})">
                                                    <i class="fa-regular fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            <a class="venobox" data-gall="img" href="{{ asset('storage/aspirate_photos/'.$photo->name) }}">
                                                <img src="{{ asset('storage/aspirate_thumbnails/'.$photo->name) }}" height="100" class="rounded me-1" alt="image alt"/>
                                            </a>
                                        </div>
                                    @empty
                                        <p class="mb-0 fw-bold ms-3" style="margin-top: 35px;">No Photo</p>
                                    @endforelse

                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="sc_date">Date of Procedure</label>
                                <div class="">
                                    <input type="date" class="form-control @error('sc_date') is-invalid @enderror" id="sc_date" form="aspirateUpdateForm" placeholder="dd/MM/YYYY" name="sc_date" value="{{ old('sc_date',$aspirate->sc_date) }}">
                                    @error('sc_date')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Name Of Institute</label>
                                <select class="form-select @error('hospital') is-invalid @enderror" form="aspirateUpdateForm" name="hospital" aria-label="Default select example">
                                    <option selected>Select Hospital</option>
                                    @forelse(\App\Models\Hospital::all() as $hospital)
                                        <option value="{{ $hospital->id }}" {{ $hospital->id == old('hospital',$aspirate->hospital_id) ? 'selected':'' }}>{{ $hospital->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('hospital')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Laboratory Accession Number</label>
                                <div class="form-floating">
                                    <input type="number" name="lab_access" form="aspirateUpdateForm" class="form-control @error('lab_access') is-invalid @enderror" id="lab_access" placeholder="lab_access" value="{{ old('lab_access',$aspirate->lab_access) }}">
                                    <label for="lab_access">Enter....</label>
                                    @error('lab_access')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="">Patient's Name</label>
                                <div class="form-floating">
                                    <input type="text" name="patient_name" form="aspirateUpdateForm" class="form-control @error('patient_name') is-invalid @enderror" id="patient_name" placeholder="patient_name" value="{{ old('patient_name',$aspirate->patient_name) }}">
                                    <label for="patient_name">Enter Patient's Name</label>
                                    @error('patient_name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Age</label>
                                        <div class="form-floating">
                                            <input type="number" name="age" form="aspirateUpdateForm" class="form-control @error('age') is-invalid @enderror" id="age" placeholder="age" value="{{ old('age',$aspirate->age) }}">
                                            <label for="age">Enter Age</label>
                                            @error('age')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Age Type</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" {{ old('age_type',$aspirate->age_type) == 'D' ? 'checked':'' }} type="radio" form="aspirateUpdateForm" name="age_type" id="d" value="D">
                                            <label class="form-check-label" for="d">Day</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" {{ old('age_type',$aspirate->age_type) == 'M' ? 'checked':'' }} type="radio" form="aspirateUpdateForm" name="age_type" id="m" value="M">
                                            <label class="form-check-label" for="m">Month</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" {{ old('age_type',$aspirate->age_type) == 'Yr' ? 'checked':'' }} type="radio" form="aspirateUpdateForm" name="age_type" id="yr" value="Yr">
                                            <label class="form-check-label" for="yr">Year</label>
                                        </div>
                                        <br>
                                        @error('age_type')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="">Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" {{ old('gender',$aspirate->gender) == 'Male' ? 'checked':'' }} type="radio" form="aspirateUpdateForm" name="gender" id="genderM" value="Male">
                                    <label class="form-check-label" for="genderM">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" {{ old('gender',$aspirate->gender) == 'Female' ? 'checked':'' }} type="radio" form="aspirateUpdateForm" name="gender" id="genderF" value="Female">
                                    <label class="form-check-label" for="genderF">Female</label>
                                </div>
                                <br>
                                @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Specimen Type</label>
                                        <div class="form-floating">
                                            <input type="text" name="specimen_type" form="aspirateUpdateForm" class="form-control @error('specimen_type') is-invalid @enderror" id="specimen_type" placeholder="specimen_type" value="{{ old('specimen_type',$aspirate->specimen_type) }}">
                                            <label for="specimen_type">Enter Specimen Type</label>
                                            @error('specimen_type')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Price</label>
                                        <div class="form-floating">
                                            <input type="number" name="price" form="aspirateUpdateForm" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="price" value="{{ old('price',$aspirate->price) }}">
                                            <label for="price">Enter Price</label>
                                            @error('price')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contact_detail" class="form-label">Contact Details</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('contact_detail') is-invalid @enderror" name="contact_detail" id="contact_detail" placeholder="Enter Contact Details" style="height: 130px">{{ old('contact_detail',$aspirate->contact_detail) }}</textarea>
                                    <label for="floatingTextarea2">Enter Contact Details</label>
                                    @error('contact_detail')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="">Physician</label>
                                <div class="form-floating">
                                    <input type="text" name="physician_name" form="aspirateUpdateForm" class="form-control @error('physician_name') is-invalid @enderror" id="physician_name" placeholder="physician_name" value="{{ old('physician_name',$aspirate->physician_name) }}">
                                    <label for="physician_name">Enter Responsible Physician</label>
                                    @error('physician_name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="">Doctors</label>
                                <div class="form-floating">
                                    <input type="text" name="doctor" form="aspirateUpdateForm" class="form-control @error('doctor') is-invalid @enderror" id="doctor" placeholder="doctor" value="{{ old('doctor',$aspirate->doctor) }}">
                                    <label for="doctor">Enter Requesting Doctors</label>
                                    @error('doctor')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="clinical_history" class="form-label">Clinical History</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('clinical_history') is-invalid @enderror" name="clinical_history" id="clinical_history" placeholder="Enter clinical history" style="height: 130px">{{ old('clinical_history',$aspirate->clinical_history) }}</textarea>
                                    <label for="floatingTextarea2">Enter Clinical History</label>
                                    @error('clinical_history')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="bmexamination" class="form-label">Bone Marrow Examination</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('bmexamination') is-invalid @enderror" name="bmexamination" id="bmexamination" placeholder="Enter Indication for Bone Marrow Examination" style="height: 130px">{{ old('bmexamination',$aspirate->bmexamination) }}</textarea>
                                    <label for="floatingTextarea2">Enter Indication for Bone Marrow Examination</label>
                                    @error('bmexamination')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="">Procedure Perform</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" form="aspirateUpdateForm" {{ old('pro_perform',$aspirate->pro_perform) == 'Aspirate' ? 'checked':'' }} type="radio" name="pro_perform" id="pro_perform_A" value="Aspirate">
                                    <label class="form-check-label" for="pro_perform_A">Aspirate</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" form="aspirateUpdateForm" {{ old('pro_perform',$aspirate->pro_perform) == 'Trephine' ? 'checked':'' }} type="radio" name="pro_perform" id="pro_perform_T" value="Trephine">
                                    <label class="form-check-label" for="pro_perform_T">Trephine</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" form="aspirateUpdateForm" {{ old('pro_perform',$aspirate->pro_perform) == 'Aspirate_Trephine' ? 'checked':'' }} type="radio" name="pro_perform" id="pro_perform_AT" value="Aspirate_Trephine">
                                    <label class="form-check-label" for="pro_perform_AT">Aspirate / Trephine</label>
                                </div>
                                <br>
                                @error('pro_perform')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="anatomic_site_aspirate" class="form-label">Anatomic site of aspirate/biopsy</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('anatomic_site_aspirate') is-invalid @enderror" name="anatomic_site_aspirate" id="anatomic_site_aspirate" placeholder="Enter Anatomic site of aspirate/biopsy" style="height: 130px">{{ old('anatomic_site_aspirate',$aspirate->anatomic_site_aspirate) }}</textarea>
                                    <label for="floatingTextarea2">Enter Anatomic site of aspirate/biopsy</label>
                                    @error('anatomic_site_aspirate')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="ease_diff_aspirate" class="form-label">Ease/difficulty of aspiration</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('ease_diff_aspirate') is-invalid @enderror" name="ease_diff_aspirate" id="ease_diff_aspirate" placeholder="Enter Ease/difficulty of aspiration" style="height: 130px">{{ old('ease_diff_aspirate',$aspirate->ease_diff_aspirate) }}</textarea>
                                    <label for="floatingTextarea2">Enter Ease/difficulty of aspiration</label>
                                    @error('ease_diff_aspirate')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="blood_count" class="form-label">Blood Count</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('blood_count') is-invalid @enderror" name="blood_count" id="blood_count" placeholder="Enter Blood Count" style="height: 130px">{{ old('blood_count',$aspirate->blood_count) }}</textarea>
                                    <label for="floatingTextarea2">Enter Blood Count</label>
                                    @error('blood_count')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="blood_smear" class="form-label">Blood Smear</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('blood_smear') is-invalid @enderror" name="blood_smear" id="blood_smear" placeholder="Enter Blood smear description and diagnostic conclusion" style="height: 130px">{{ old('blood_smear',$aspirate->blood_smear) }}</textarea>
                                    <label for="floatingTextarea2">Enter Blood smear description and diagnostic conclusion</label>
                                    @error('blood_smear')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="cellular_particles" class="form-label">Cellularity of particles and cell trails</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('cellular_particles') is-invalid @enderror" name="cellular_particles" id="cellular_particles" placeholder="Enter Cellularity of particles and cell trails" style="height: 130px">{{ old('cellular_particles',$aspirate->cellular_particles) }}</textarea>
                                    <label for="floatingTextarea2">Enter Cellularity of particles and cell trails</label>
                                    @error('cellular_particles')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="nucleated_differential" class="form-label">Nucleated differential cell count</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('nucleated_differential') is-invalid @enderror" name="nucleated_differential" id="nucleated_differential" placeholder="Enter Nucleated differential cell count" style="height: 130px">{{ old('nucleated_differential',$aspirate->nucleated_differential) }}</textarea>
                                    <label for="floatingTextarea2">Enter Nucleated differential cell count</label>
                                    @error('nucleated_differential')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="total_cell_count" class="form-label">Total number of cells counted</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('total_cell_count') is-invalid @enderror" name="total_cell_count" id="total_cell_count" placeholder="Enter Total number of cells counted" style="height: 130px">{{ old('total_cell_count',$aspirate->total_cell_count) }}</textarea>
                                    <label for="floatingTextarea2">Enter Total number of cells counted</label>
                                    @error('total_cell_count')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="myeloid" class="form-label">Myeloid:erythroid ratio</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('myeloid') is-invalid @enderror" name="myeloid" id="myeloid" placeholder="Enter Myeloid:erythroid ratio" style="height: 130px">{{ old('myeloid',$aspirate->myeloid) }}</textarea>
                                    <label for="floatingTextarea2">Enter Myeloid:erythroid ratio</label>
                                    @error('myeloid')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="erythropoiesis" class="form-label">Erythropoiesis</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('erythropoiesis') is-invalid @enderror" name="erythropoiesis" id="erythropoiesis" placeholder="Enter Erythropoiesis" style="height: 130px">{{ old('erythropoiesis',$aspirate->erythropoiesis) }}</textarea>
                                    <label for="floatingTextarea2">Enter Erythropoiesis</label>
                                    @error('erythropoiesis')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="myelopoiesis" class="form-label">Myelopoiesis</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('myelopoiesis') is-invalid @enderror" name="myelopoiesis" id="myelopoiesis" placeholder="Enter Myelopoiesis" style="height: 130px">{{ old('myelopoiesis',$aspirate->myelopoiesis) }}</textarea>
                                    <label for="floatingTextarea2">Enter Myelopoiesis</label>
                                    @error('myelopoiesis')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="megakaryocytes" class="form-label">Megakaryocytes</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('megakaryocytes') is-invalid @enderror" name="megakaryocytes" id="megakaryocytes" placeholder="Enter Megakaryocytes" style="height: 130px">{{ old('myelopoiesis',$aspirate->myelopoiesis) }}</textarea>
                                    <label for="floatingTextarea2">Enter Megakaryocytes</label>
                                    @error('megakaryocytes')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="lymphocytes" class="form-label">Lymphocytes</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('lymphocytes') is-invalid @enderror" name="lymphocytes" id="lymphocytes" placeholder="Enter Lymphocytes" style="height: 130px">{{ old('lymphocytes',$aspirate->lymphocytes) }}</textarea>
                                    <label for="floatingTextarea2">Enter Lymphocytes</label>
                                    @error('lymphocytes')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="plasma_cell" class="form-label">Plasma cells</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('plasma_cell') is-invalid @enderror" name="plasma_cell" id="plasma_cell" placeholder="Enter Plasma cells" style="height: 130px">{{ old('plasma_cell',$aspirate->plasma_cell) }}</textarea>
                                    <label for="floatingTextarea2">Enter Plasma cells</label>
                                    @error('plasma_cell')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="haemopoietic_cell" class="form-label">Haemopoietic Cells</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('haemopoietic_cell') is-invalid @enderror" name="haemopoietic_cell" id="haemopoietic_cell" placeholder="Enter Haemopoietic Cells" style="height: 130px">{{ old('haemopoietic_cell',$aspirate->haemopoietic_cell) }}</textarea>
                                    <label for="floatingTextarea2">Enter Haemopoietic Cells</label>
                                    @error('haemopoietic_cell')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="abnormal_cell" class="form-label">Abnormal Cells</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('abnormal_cell') is-invalid @enderror" name="abnormal_cell" id="abnormal_cell" placeholder="Enter Abnormal Cells" style="height: 130px">{{ old('abnormal_cell',$aspirate->abnormal_cell) }}</textarea>
                                    <label for="floatingTextarea2">Enter Abnormal Cells</label>
                                    @error('abnormal_cell')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="iron_stain" class="form-label">Iron Stain</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('iron_stain') is-invalid @enderror" name="iron_stain" id="iron_stain" placeholder="Enter Iron Stain" style="height: 130px">{{ old('iron_stain',$aspirate->iron_stain) }}</textarea>
                                    <label for="floatingTextarea2">Enter Iron Stain</label>
                                    @error('iron_stain')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="cytochemistry" class="form-label">Cytochemistry</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('cytochemistry') is-invalid @enderror" name="cytochemistry" id="cytochemistry" placeholder="Enter Cytochemistry" style="height: 130px">{{ old('cytochemistry',$aspirate->cytochemistry) }}</textarea>
                                    <label for="floatingTextarea2">Enter Cytochemistry</label>
                                    @error('cytochemistry')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="investigation" class="form-label">Other investigations</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('investigation') is-invalid @enderror" name="investigation" id="investigation" placeholder="Enter Other investigations" style="height: 130px">{{ old('investigation',$aspirate->investigation) }}</textarea>
                                    <label for="floatingTextarea2">Enter Other investigations</label>
                                    @error('investigation')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="flow_cytometry" class="form-label">Summary of flow cytometry findings</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('flow_cytometry') is-invalid @enderror" name="flow_cytometry" id="flow_cytometry" placeholder="Enter Summary of flow cytometry findings" style="height: 130px">{{ old('flow_cytometry',$aspirate->flow_cytometry) }}</textarea>
                                    <label for="floatingTextarea2">Enter Summary of flow cytometry findings</label>
                                    @error('flow_cytometry')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="conclusion" class="form-label">Conclusion</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('conclusion') is-invalid @enderror" name="conclusion" id="conclusion" placeholder="Enter Conclusion" style="height: 130px">{{ old('conclusion',$aspirate->conclusion) }}</textarea>
                                    <label for="floatingTextarea2">Enter Conclusion</label>
                                    @error('conclusion')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="classification" class="form-label">WHO classification</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('classification') is-invalid @enderror" name="classification" id="classification" placeholder="Enter WHO classification" style="height: 130px">{{ old('classification',$aspirate->classification) }}</textarea>
                                    <label for="floatingTextarea2">Enter WHO classification</label>
                                    @error('classification')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="disease_code" class="form-label">Disease Code</label>
                                <div class="form-floating">
                                    <textarea form="aspirateUpdateForm" class="form-control @error('disease_code') is-invalid @enderror" name="disease_code" id="disease_code" placeholder="Disease Code" style="height: 130px">{{ old('disease_code',$aspirate->disease_code) }}</textarea>
                                    <label for="floatingTextarea2">Enter Disease Code</label>
                                    @error('disease_code')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary text-uppercase text-white" form="aspirateUpdateForm"><i class="fa fa-save me-2"></i>Update</button>

                </div>
            </div>
        </div>
    </div>

@stop

@push('script')
    <script>

        let photoUploadForm = document.getElementById('photoUploadForm');
        let photoInput = document.getElementById('inputPhotos');
        let photoUploadUi = document.getElementById('photoUploadUi');

        photoUploadUi.addEventListener('click',function (){
            photoInput.click();
        })

        photoInput.addEventListener('change',function (){
            photoUploadForm.submit();
        })

    </script>
@endpush
