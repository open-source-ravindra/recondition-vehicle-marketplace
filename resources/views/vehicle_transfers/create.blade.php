@extends('layouts.app')

@section('title', 'नयाँ वाहन स्थानान्तरण / New Vehicle Transfer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-contract"></i>
                        वाहन स्थानान्तरण फारम / Vehicle Transfer Form
                    </h4>
                    <p class="mb-0">
                        <strong>बाबा रिकन्डिसन हाउस / Baba Recondition House</strong><br>
                        PAN: 611607245 | ठेगाना: धनगढी-८, च्याम्सार रोड, कैलाली / Address: Dhangadhi-8, Chyamsar Road, Kailali
                    </p>
                </div>

                <div class="card-body">
                    <form action="{{ route('vehicle-transfers.store') }}" method="POST" id="transferForm">
                        @csrf

                        <!-- Section 1: Vehicle Purchaser's Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-info text-white p-2">
                                <i class="fas fa-user"></i>
                                वाहन किन्ने व्यक्तिको विवरण / Vehicle Purchaser's Details
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buyer_name" class="required">
                                            नाम / Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_name" id="buyer_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="buyer_dob" class="required">
                                            जन्म मिति / Date of Birth <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="buyer_dob" id="buyer_dob"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="buyer_citizenship" class="required">
                                            नागरिकता नं. / Citizenship No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_citizenship" id="buyer_citizenship"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buyer_father_name" class="required">
                                            बुबाको नाम / Father's Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_father_name" id="buyer_father_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buyer_grandfather_name" class="required">
                                            हजुरबुबाको नाम / Grandfather's Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_grandfather_name" id="buyer_grandfather_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="buyer_phone" class="required">
                                            फोन नं. / Phone No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_phone" id="buyer_phone"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="buyer_ward_no" class="required">
                                            वडा नं. / Ward No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="buyer_ward_no" id="buyer_ward_no"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="buyer_municipality_type" class="required">
                                            नगरपालिका प्रकार / Municipality Type <span class="text-danger">*</span>
                                        </label>
                                        <select name="buyer_municipality_type" id="buyer_municipality_type"
                                            class="form-control" required>
                                            <option value="">छान्नुहोस् / Select</option>
                                            <option value="metropolitan_city">महानगरपालिका / Metropolitan City</option>
                                            <option value="sub_metropolitan_city">उप-महानगरपालिका / Sub-Metropolitan City</option>
                                            <option value="municipality">नगरपालिका / Municipality</option>
                                            <option value="rural_municipality">गाउँपालिका / Rural Municipality</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_address" class="required">
                                            ठेगाना / Address <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="buyer_address" id="buyer_address"
                                            class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Spouse Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-secondary text-white p-2">
                                <i class="fas fa-user-friends"></i>
                                श्रीमती/श्रीमानको विवरण / Spouse's Details
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spouse_name">
                                            नाम / Name
                                        </label>
                                        <input type="text" name="spouse_name" id="spouse_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spouse_citizenship">
                                            नागरिकता नं. / Citizenship No.
                                        </label>
                                        <input type="text" name="spouse_citizenship" id="spouse_citizenship"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spouse_father_name">
                                            बुबाको नाम / Father's Name
                                        </label>
                                        <input type="text" name="spouse_father_name" id="spouse_father_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spouse_grandfather_name">
                                            हजुरबुबाको नाम / Grandfather's Name
                                        </label>
                                        <input type="text" name="spouse_grandfather_name" id="spouse_grandfather_name"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_phone">
                                            फोन नं. / Phone No.
                                        </label>
                                        <input type="text" name="spouse_phone" id="spouse_phone"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_ward_no">
                                            वडा नं. / Ward No.
                                        </label>
                                        <input type="text" name="spouse_ward_no" id="spouse_ward_no"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spouse_municipality_type">
                                            नगरपालिका प्रकार / Municipality Type
                                        </label>
                                        <select name="spouse_municipality_type" id="spouse_municipality_type"
                                            class="form-control">
                                            <option value="">छान्नुहोस् / Select</option>
                                            <option value="metropolitan_city">महानगरपालिका</option>
                                            <option value="sub_metropolitan_city">उप-महानगरपालिका</option>
                                            <option value="municipality">नगरपालिका</option>
                                            <option value="rural_municipality">गाउँपालिका</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="spouse_address">
                                            ठेगाना / Address
                                        </label>
                                        <textarea name="spouse_address" id="spouse_address"
                                            class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Vehicle Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-success text-white p-2">
                                <i class="fas fa-motorcycle"></i>
                                वाहनको विवरण / Vehicle Details
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vehicle_id" class="required">
                                            वाहन छान्नुहोस् / Select Vehicle <span class="text-danger">*</span>
                                        </label>
                                        <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                                            <option value="">वाहन छान्नुहोस् / Select Vehicle</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}"
                                                data-price="{{ $vehicle->selling_price }}"
                                                data-name="{{ $vehicle->name }}"
                                                data-cc="{{ $vehicle->cc }}">
                                                {{ $vehicle->name }} ({{ $vehicle->cc }}cc) -
                                                रु {{ number_format($vehicle->selling_price) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vehicle_name">
                                            वाहनको नाम / Vehicle Name
                                        </label>
                                        <input type="text" id="vehicle_name" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vehicle_cc">
                                            वाहन सि.सि. / Vehicle C.C.
                                        </label>
                                        <input type="text" id="vehicle_cc" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="purchase_price" class="required">
                                            क्रय मूल्य / Purchase Price (रु) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="purchase_price" id="purchase_price"
                                            class="form-control" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox"
                                                name="expenses_borne_by_buyer" id="expenses_borne_by_buyer" checked>
                                            <label class="form-check-label" for="expenses_borne_by_buyer">
                                                <small class="text-muted">
                                                    दर्ता/स्थानान्तरण गर्दा लाग्ने सबै खर्च किन्नेले आफैं वहन गर्नेछ । /
                                                    All expenses incurred during registration/transfer shall be borne by the purchaser themselves.
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Vehicle Seller's Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-warning text-dark p-2">
                                <i class="fas fa-user-tie"></i>
                                वाहन बेच्ने व्यक्तिको विवरण / Vehicle Seller's Details
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seller_name" class="required">
                                            नाम / Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_name" id="seller_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seller_citizenship" class="required">
                                            नागरिकता नं. / Citizenship No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_citizenship" id="seller_citizenship"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seller_father_name" class="required">
                                            बुबाको नाम / Father's Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_father_name" id="seller_father_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seller_grandfather_name" class="required">
                                            हजुरबुबाको नाम / Grandfather's Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_grandfather_name" id="seller_grandfather_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="seller_phone" class="required">
                                            फोन नं. / Phone No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_phone" id="seller_phone"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="seller_ward_no" class="required">
                                            वडा नं. / Ward No. <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="seller_ward_no" id="seller_ward_no"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="seller_municipality_type" class="required">
                                            नगरपालिका प्रकार / Municipality Type <span class="text-danger">*</span>
                                        </label>
                                        <select name="seller_municipality_type" id="seller_municipality_type"
                                            class="form-control" required>
                                            <option value="">छान्नुहोस् / Select</option>
                                            <option value="metropolitan_city">महानगरपालिका</option>
                                            <option value="sub_metropolitan_city">उप-महानगरपालिका</option>
                                            <option value="municipality">नगरपालिका</option>
                                            <option value="rural_municipality">गाउँपालिका</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="seller_address" class="required">
                                            ठेगाना / Address <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="seller_address" id="seller_address"
                                            class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Transfer Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-info text-white p-2">
                                <i class="fas fa-exchange-alt"></i>
                                स्थानान्तरण विवरण / Transfer Details
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="registered_name" class="required">
                                            दर्ता भएको वाहनको नाम / Name of Registered Vehicle <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="registered_name" id="registered_name"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transferred_by" class="required">
                                            दर्ता स्थानान्तरण गर्ने व्यक्ति/फर्म / Person/Firm Who Transferred Registration <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="transferred_by" id="transferred_by"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transfer_date" class="required">
                                            क्रय मिति / Purchase Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="transfer_date" id="transfer_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="notes">
                                            नोटहरू / Notes
                                        </label>
                                        <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Payment Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-success text-white p-2">
                                <i class="fas fa-money-bill-wave"></i>
                                भुक्तानी विवरण / Payment Details
                            </h5>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="total_price" class="required">
                                            कुल बिक्री मूल्य / Total Sale Price (रु) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="total_price" id="total_price"
                                            class="form-control" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="amount_paid" class="required">
                                            तिरेको रकम / Amount Paid (रु) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="amount_paid" id="amount_paid"
                                            class="form-control" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            प्राप्त रकम / Amount Received (रु)
                                        </label>
                                        <input type="text" id="amount_received_display"
                                            class="form-control" readonly value="0">
                                        <input type="hidden" name="amount_received" id="amount_received">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            बाँकी रकम (तिर्नु पर्ने) / Remaining to Pay (रु)
                                        </label>
                                        <input type="text" id="remaining_to_pay"
                                            class="form-control bg-warning" readonly value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_method" class="required">
                                            भुक्तानी विधि / Payment Method <span class="text-danger">*</span>
                                        </label>
                                        <select name="payment_method" id="payment_method" class="form-control" required>
                                            <option value="">छान्नुहोस् / Select</option>
                                            <option value="cash">नगद / Cash</option>
                                            <option value="cheque">चेक / Cheque</option>
                                            <option value="bank_transfer">बैंक हस्तान्तरण / Bank Transfer</option>
                                            <option value="online">अनलाइन / Online</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_date" class="required">
                                            भुक्तानी मिति / Payment Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="payment_date" id="payment_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="payment_notes">
                                            भुक्तानी नोट / Payment Notes
                                        </label>
                                        <textarea name="payment_notes" id="payment_notes"
                                            class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 7: Witness Details -->
                        <div class="form-section mb-4">
                            <h5 class="section-title bg-secondary text-white p-2">
                                <i class="fas fa-user-check"></i>
                                साक्षीको विवरण / Witness Details
                                <small class="float-end">(वाहन किनबेचको समयमा उपस्थित भएको व्यक्ति) / (Person present during vehicle purchase/sale)</small>
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="witness_name">
                                            नाम / Name
                                        </label>
                                        <input type="text" name="witness_name" id="witness_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="witness_citizenship">
                                            नागरिकता नं. / Citizenship No.
                                        </label>
                                        <input type="text" name="witness_citizenship" id="witness_citizenship"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="witness_father_name">
                                            बुबाको नाम / Father's Name
                                        </label>
                                        <input type="text" name="witness_father_name" id="witness_father_name"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="witness_grandfather_name">
                                            हजुरबुबाको नाम / Grandfather's Name
                                        </label>
                                        <input type="text" name="witness_grandfather_name" id="witness_grandfather_name"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="witness_phone">
                                            फोन नं. / Phone No.
                                        </label>
                                        <input type="text" name="witness_phone" id="witness_phone"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="witness_ward_no">
                                            वडा नं. / Ward No.
                                        </label>
                                        <input type="text" name="witness_ward_no" id="witness_ward_no"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="witness_municipality_type">
                                            नगरपालिका प्रकार / Municipality Type
                                        </label>
                                        <select name="witness_municipality_type" id="witness_municipality_type"
                                            class="form-control">
                                            <option value="">छान्नुहोस् / Select</option>
                                            <option value="metropolitan_city">महानगरपालिका</option>
                                            <option value="sub_metropolitan_city">उप-महानगरपालिका</option>
                                            <option value="municipality">नगरपालिका</option>
                                            <option value="rural_municipality">गाउँपालिका</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="witness_address">
                                            ठेगाना / Address
                                        </label>
                                        <textarea name="witness_address" id="witness_address"
                                            class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vehicle-transfers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> पछाडी जानुहोस् / Go Back
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> फारम सेभ गर्नुहोस् / Save Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-fill vehicle details when vehicle is selected
        $('#vehicle_id').change(function() {
            var selected = $(this).find(':selected');
            var price = selected.data('price');
            var name = selected.data('name');
            var cc = selected.data('cc');

            $('#vehicle_name').val(name);
            $('#vehicle_cc').val(cc);
            $('#purchase_price').val(price);
            $('#total_price').val(price);
            $('#registered_name').val(name);
        });

        // Calculate remaining amount
        function calculateRemaining() {
            var total = parseFloat($('#total_price').val()) || 0;
            var paid = parseFloat($('#amount_paid').val()) || 0;
            var remaining = total - paid;

            $('#amount_received').val(paid);
            $('#amount_received_display').val(paid.toFixed(2));
            $('#remaining_to_pay').val(remaining.toFixed(2));

            // Color code based on payment status
            if (remaining <= 0) {
                $('#remaining_to_pay').removeClass('bg-warning bg-danger').addClass('bg-success text-white');
            } else if (remaining > 0 && remaining < total) {
                $('#remaining_to_pay').removeClass('bg-success bg-danger').addClass('bg-warning');
            } else {
                $('#remaining_to_pay').removeClass('bg-success bg-warning').addClass('bg-danger text-white');
            }
        }

        // Calculate on input change
        $('#total_price, #amount_paid').on('input', calculateRemaining);

        // Set default dates
        var today = new Date().toISOString().split('T')[0];
        $('#transfer_date').val(today);
        $('#payment_date').val(today);

        // Form validation
        $('#transferForm').submit(function(e) {
            var total = parseFloat($('#total_price').val()) || 0;
            var paid = parseFloat($('#amount_paid').val()) || 0;

            if (paid > total) {
                e.preventDefault();
                alert('तिरेको रकम कुल मूल्यभन्दा बढी हुन सक्दैन / Paid amount cannot be greater than total price');
                $('#amount_paid').focus();
            }
        });
    });
</script>
@endsection

<style>
    .form-section {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f8f9fa;
    }

    .section-title {
        border-radius: 3px;
        margin: -15px -15px 15px -15px;
    }

    .required label {
        font-weight: 600;
    }

    input:read-only {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
</style>