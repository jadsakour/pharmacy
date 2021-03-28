<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\DrugInvoice;
use App\Models\DrugShape;
use App\Models\DrugCategory;
use App\Models\DrugsRepo;
use App\Models\Company;

// TODO: Add validation check to the passed parameters, but not all parameters because in some cases some of them could be null.

class DrugController extends Controller
{
    /**
     * Assign appropriate permissions.
     *
     * The required permissions are:
     * 'drug-list', 'drug-create', 'drug-update', 'drug-delete',
     * 'drug-repo-show', 'drug-repo-update', 'drug-repo-update-sell', 'drug-repo-update-order', 'drug-repo-update-prescription','drug-repo-delete'
     */
    public function __construct()
    {
        $this->middleware(
            'permission:drug-list|drug-repo-show',
            ['only' => ['index', 'search_drugs', 'get_drug_repo_by_id_for_sell', 'get_drug_repo_by_id_for_order', 'get_drug_by_id_for_prescription', 'calculate_prices']]
        );
        $this->middleware('permission:drug-list', ['only' => ['index']]);
        $this->middleware('permission:drug-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drug-update', ['only' => ['editDrug', 'update_drug']]);
        $this->middleware('permission:drug-delete', ['only' => ['destroy']]);

        $this->middleware('permission:drug-repo-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drug-repo-update-sell', ['only' => ['edit', 'update_drug_repo_from_sell_invoice']]);
        $this->middleware('permission:drug-repo-update-order', ['only' => ['edit', 'update_drugs_repo_from_incoming_invoice']]);
        $this->middleware('permission:drug-repo-update-prescription', ['only' => ['edit', 'update_drugs_repo_from_prescription_invoice']]);
    }

    /**
     * Helper method to get the drug using its bar code.
     *
     * @return Drug Object for the targeted drug
     */
    public function get_drug_details_by_barcode($barcode)
    {
        return Drug::where('local_barcode', $barcode)->get();
    }

    /**
     * Helper method to get the drug with its details from the repo.
     *
     * @return DrugsRepo Object details for the targeted drug
     */
    public function get_drug_details_by_id($drug_id)
    {
        return Drug::select('name_arabic', 'name_english')->where('id', $drug_id)->get()->repo();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shapes = DrugShape::all();
        $categories = DrugCategory::all();
        $companies = Company::all();

        // Return the appropriate view
        return view('drug.index')->with([
            'shapes' => $shapes,
            'categories' => $categories,
            'companies' => $companies
        ]);
    }

    /**
     * Helper method to filter drugs.
     */
    private function get_drugs_by_filter($shape_id, $category_id, $company_id)
    {
        $drugs = null;

        if ($shape_id != 0 && $category_id != 0 && $company_id != 0) {
            $drugs = Drug::where([
                ['shape_id', $shape_id],
                ['category_id', $category_id],
                ['company_id', $company_id],
            ]);
        }

        if ($shape_id != 0 && $category_id != 0 && $company_id == 0) {
            $drugs = Drug::where([
                ['shape_id', $shape_id],
                ['category_id', $category_id],
            ]);
        }

        if ($shape_id != 0 && $category_id == 0 && $company_id != 0) {
            $drugs = Drug::where([
                ['shape_id', $shape_id],
                ['company_id', $company_id],
            ]);
        }

        if ($shape_id == 0 && $category_id != 0 && $company_id != 0) {
            $drugs = Drug::where([
                ['category_id', $category_id],
                ['company_id', $company_id],
            ]);
        }

        if ($shape_id != 0 && $category_id == 0 && $company_id == 0) {
            $drugs = Drug::where([
                ['shape_id', $shape_id]
            ]);
        }

        if ($shape_id == 0 && $category_id != 0 && $company_id == 0) {
            $drugs = Drug::where([
                ['category_id', $category_id],
            ]);
        }

        if ($shape_id == 0 && $category_id == 0 && $company_id != 0) {
            $drugs = Drug::where([
                ['company_id', $company_id],
            ]);
        }

        if ($shape_id == 0 && $category_id == 0 && $company_id == 0) {
            $drugs = null;
        }

        return $drugs;
    }

    /**
     * Filter drugs.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $shape_id = $request->shape;
        $category_id = $request->category;
        $company_id = $request->company;

        $drugs = $this->get_drugs_by_filter($shape_id, $category_id, $company_id);

        if ($drugs == null) {
            return redirect()->route('drug.index');
        }

        return view('drug.filter')->withDrugs($drugs->get());
    }

    /**
     * Search for a certain drug through an AJAX request.
     */
    function search_drugs(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $search_by = $request->query("searchBy");
            $shape_id = $request->shape;
            $category_id = $request->category;
            $company_id = $request->company;
            $drugs = $this->get_drugs_by_filter($shape_id, $category_id, $company_id);
            if ($search_by == "search_name_arabic") {
                if ($drugs == null) {
                    $drugs = Drug::where('name_arabic', 'like', '%' . $search . '%')->get();
                } else {
                    $drugs = $drugs->where('name_arabic', 'like', '%' . $search . '%')->get();
                }
            }
            if ($search_by == "search_name_english") {
                if ($drugs == null) {
                    $drugs = Drug::where('name_english', 'like', '%' . $search . '%')->get();
                } else {
                    $drugs = $drugs->where('name_english', 'like', '%' . $search . '%')->get();
                }
            }
            if ($search_by == "search_composition") {
                if ($drugs == null) {
                    $drugs = Drug::where('chemical_composition', 'like', '%' . $search . '%')->get();
                } else {
                    $drugs = $drugs->where('chemical_composition', 'like', '%' . $search . '%')->get();
                }
            }
            if ($drugs == null) {
                return json_encode(null);
            }
            $response = array();
            foreach ($drugs as $drug) {
                $response[] = array(
                    "id" => $drug->id,
                    "text" => $drug->name_arabic . " / " . $drug->name_english
                );
            }
            return json_encode($response);
        }
    }

    /**
     * Search for a certain drug repo by its id through an AJAX request.
     */
    function get_drug_repo_by_id_for_sell(Request $request)
    {
        if ($request->ajax()) {
            $data = null;
            $output = '';
            $drug_id = $request->input('drug_id');
            $drug = null;
            if ($drug_id != '') {
                $drug = Drug::find($drug_id);
            } else {
                $output = '
                <tr>
                 <td align="center" colspan="5">لم يتم إيجاد أي نتيجة</td>
                </tr>
                ';
            }
            if ($drug->repo()->count() == 0) {
                $output = '
                <tr>
                 <td align="center" colspan="5">لا يوجد مخازن لهذا الدواء</td>
                </tr>
                ';
            } else {
                $output = '
            <tr>
                <td id="drug_id" style="display:none">' . $drug->id . '</td>
                <td>' . $drug->name_arabic . '</td>
                <td class="text-left">' . $drug->repo()->orderBy('exp_date', 'asc')->first()->exp_date . '</td>
                <td class="text-center"><input type="text" class="form-control" id="packages_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="units_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="modified_drug_unit_sell_price"></td>
                <td class="text-center"><input type="text" class="form-control" id="modified_drug_package_sell_price"></td>
            </tr>';
            }
            $data = array(
                'table_data'  => $output
            );

            return json_encode($data);
        }
    }

    /**
     * Search for a certain drug repo by its id through an AJAX request.
     */
    function get_drug_repo_by_id_for_order(Request $request)
    {
        if ($request->ajax()) {
            $data = null;
            $output = '';
            $drug_id = $request->input('drug_id');
            $drug = null;
            if ($drug_id != '') {
                $drug = Drug::find($drug_id);
            } else {
                $output = '
                <tr>
                 <td align="center" colspan="5">لم يتم إيجاد أي نتيجة</td>
                </tr>
                ';
            }
            if ($drug->repo()->count() == 0) {
                $output = '
            <tr>
                <td id="drug_id" style="display:none">' . $drug->id . '</td>
                <td>' . $drug->name_arabic . '</td>
                <td class="text-left"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"><input type="text" class="form-control" id="packages_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="units_number"></td>
            </tr>';
            } else {
                $output = '
            <tr>
                <td id="drug_id" style="display:none">' . $drug->id . '</td>
                <td>' . $drug->name_arabic . '</td>
                <td class="text-left">' . $drug->repo()->orderBy('exp_date', 'asc')->first()->exp_date . '</td>
                <td class="text-center">' . $drug->repo()->sum('packages_number') . '</td>
                <td class="text-center">' . $drug->repo()->sum('units_number') . '</td>
                <td class="text-center"><input type="text" class="form-control" id="packages_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="units_number"></td>
            </tr>';
            }
            $data = array(
                'table_data'  => $output
            );

            return json_encode($data);
        }
    }

    /**
     * Search for a certain drug repo by its id through an AJAX request.
     */
    function get_drug_by_id_for_prescription(Request $request)
    {
        if ($request->ajax()) {
            $data = null;
            $output = '';
            $drug_id = $request->input('drug_id');
            $drug = null;
            if ($drug_id != '') {
                $drug = Drug::find($drug_id);
            } else {
                $output = '
                <tr>
                 <td align="center" colspan="5">لم يتم إيجاد أي نتيجة</td>
                </tr>
                ';
            }
            $output = '
            <tr>
                <td id="drug_id" style="display:none">' . $drug->id . '</td>
                <td>' . $drug->name_arabic . '</td>
                <td class="text-center"><input type="text" class="form-control" id="packages_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="units_number"></td>
                <td class="text-center"><input type="text" class="form-control" id="modified_drug_package_sell_price"></td>
                <td class="text-center"><input type="text" class="form-control" id="modified_drug_unit_sell_price"></td>
            </tr>';
            $data = array(
                'table_data'  => $output
            );

            return json_encode($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all the required data
        $categories = DrugCategory::all();
        $drugs = Drug::all();
        $shapes = DrugShape::all();
        $companies = Company::all();
        return view('drug.create')->with([
            'categories' => $categories,
            'shapes' => $shapes,
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_without_repo()
    {
        // Get all the required data
        $categories = DrugCategory::all();
        $drugs = Drug::all();
        $shapes = DrugShape::all();
        $companies = Company::all();
        return view('drug.create-drug')->with([
            'categories' => $categories,
            'shapes' => $shapes,
            'companies' => $companies,
        ]);
    }

    /**
     * Create a new repo for a certain drug.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_repo($drug_id)
    {
        $drug = Drug::find($drug_id);
        return view('drug.create-drug-repo')->with(['drug' => $drug]);
    }

    /**
     * Store a newly drug repo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_repo(Request $request, $drug_id)
    {
        // Create the new drug entry
        $drug = Drug::find($drug_id);
        $drug_repo = new DrugsRepo;

        // Assign the default unit number for this drug
        $drug_repo->unit_number = $request->input('unit_number') == null ? 1 : $request->input('unit_number');
        // Add the appropriate drugs repo record
        $drug_repo->pro_date = $request->input('pro_date');
        $drug_repo->exp_date = $request->input('exp_date');

        // Check if units are inserted
        if ($request->input('units_number') != null || $request->input('units_number') != "0") {
            $drug_repo->packages_number = (int) ($request->input('units_number') / $drug_repo->unit_number);
            $drug_repo->units_number = $request->input('units_number');
        } else {
            $drug_repo->packages_number = $request->input('packages_number');
            $drug_repo->units_number = $request->input('packages_number') * $drug_repo->unit_number;
        }

        // Set the prices
        $drug_repo->package_sell_price = $request->input('package_sell_price');
        if ($request->input('unit_sell_price') == null || strval($request->input('unit_sell_price')) == "0") {
            $drug_repo->unit_sell_price = (int) $drug_repo->package_sell_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_sell_price = $request->input('unit_sell_price');
        }
        $drug_repo->package_net_price = $request->input('package_net_price');
        if ($request->input('unit_net_price') == null || strval($request->input('unit_net_price')) == "0") {
            $drug_repo->unit_net_price = (int) $drug_repo->package_net_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_net_price = $request->input('unit_net_price');
        }

        // Publish the new attributes to the repo and bind it with the appropriate drug
        $drug_repo->drug()->associate($drug);
        $drug_repo->save();

        // Return the appropriate view
        return redirect()->route('drug.index');
    }

    /**
     * Show the drug repo info.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_repo($id)
    {
        // Get all the required data
        $drug = Drug::find($id);
        return view('drug.show-repo')->with('drug',  $drug);
    }

    /**
     * Edit Drug Repo Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_repo($id)
    {
        // Get all the required data
        $drug_repo = DrugsRepo::find($id);
        return view('drug.edit-repo')->with('drug_repo',  $drug_repo);
    }

    /**
     * Edit Drug Main Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get all the required data
        $drug = Drug::find($id);
        return view('drug.edit')->with('drug',  $drug);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create the new drug entry
        $drug = new Drug;
        $drug_repo = new DrugsRepo;

        // Grab the drug data
        $drug->name_english = $request->input('name_english');
        $drug->name_arabic = $request->input('name_arabic');
        $drug->chemical_composition = $request->input('chemical_composition');
        $drug->volume_unit = $request->input('volume_unit');
        $drug->lic_palte = $request->input('lic_palte');
        $drug->local_barcode = $request->input('local_barcode');
        $drug->global_barcode = $request->input('global_barcode');

        // Associate the foreign keys
        $drug->company()->associate(Company::find($request->input('company_id')));
        $drug->category()->associate(DrugCategory::find($request->input('category_id')));
        $drug->shape()->associate(DrugShape::find($request->input('shape_id')));

        // Save the new drug
        $drug->save();

        // Assign the default unit number for this drug
        $drug_repo->unit_number = $request->input('unit_number') == null ? 1 : $request->input('unit_number');
        // Add the appropriate drugs repo record
        $drug_repo->pro_date = $request->input('pro_date');
        $drug_repo->exp_date = $request->input('exp_date');

        // Check if units are inserted
        if ($request->input('units_number') != null || $request->input('units_number') != "0") {
            $drug_repo->packages_number = (int) ($request->input('units_number') / $drug_repo->unit_number);
            $drug_repo->units_number = $request->input('units_number');
        } else {
            $drug_repo->packages_number = $request->input('packages_number');
            $drug_repo->units_number = $request->input('packages_number') * $drug_repo->unit_number;
        }

        // Set the prices
        $drug_repo->package_sell_price = $request->input('package_sell_price');
        if ($request->input('unit_sell_price') == null || strval($request->input('unit_sell_price')) == "0") {
            $drug_repo->unit_sell_price = (int) $drug_repo->package_sell_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_sell_price = $request->input('unit_sell_price');
        }
        $drug_repo->package_net_price = $request->input('package_net_price');
        if ($request->input('unit_net_price') == null || strval($request->input('unit_net_price')) == "0") {
            $drug_repo->unit_net_price = (int) $drug_repo->package_net_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_net_price = $request->input('unit_net_price');
        }

        // Publish the new attributes to the repo and bind it with the appropriate drug
        $drug_repo->drug()->associate($drug);
        $drug_repo->save();

        // Return the appropriate view
        return redirect()->route('drug.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_without_repo(Request $request)
    {
        // Create the new drug entry
        $drug = new Drug;

        // Grab the drug data
        $drug->name_english = $request->input('name_english');
        $drug->name_arabic = $request->input('name_arabic');
        $drug->chemical_composition = $request->input('chemical_composition');
        $drug->volume_unit = $request->input('volume_unit');
        $drug->lic_palte = $request->input('lic_palte');
        $drug->local_barcode = $request->input('local_barcode');
        $drug->global_barcode = $request->input('global_barcode');

        // Associate the foreign keys
        $drug->company()->associate(Company::find($request->input('company_id')));
        $drug->category()->associate(DrugCategory::find($request->input('category_id')));
        $drug->shape()->associate(DrugShape::find($request->input('shape_id')));

        // Save the new drug
        $drug->save();

        // Return the appropriate view
        return redirect()->route('drug.index');
    }

    /**
     * Update Drug Repo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update_repo(Request $request, $id)
    {
        // Get the targeted Drug
        $drug_repo = DrugsRepo::find($id);

        //Assign the default unit number for this drug
        $drug_repo->unit_number = $request->input('unit_number') == null ? 1 : $request->input('unit_number');
        //Add the appropriate drugs repo record
        $drug_repo->pro_date = $request->input('pro_date');
        $drug_repo->exp_date = $request->input('exp_date');

        // Check if units are inserted
        if ($request->input('units_number') != null || $request->input('units_number') != "0") {
            $drug_repo->packages_number = (int) ($request->input('units_number') / $drug_repo->unit_number);
            $drug_repo->units_number = $request->input('units_number');
        } else {
            $drug_repo->packages_number = $request->input('packages_number');
            $drug_repo->units_number = $request->input('packages_number') * $drug_repo->unit_number;
        }

        // Set the prices
        $drug_repo->package_sell_price = $request->input('package_sell_price');
        if ($request->input('unit_sell_price') == null || strval($request->input('unit_sell_price')) == "0") {
            $drug_repo->unit_sell_price = (int) $drug_repo->package_sell_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_sell_price = $request->input('unit_sell_price');
        }
        $drug_repo->package_net_price = $request->input('package_net_price');
        if ($request->input('unit_net_price') == null || strval($request->input('unit_net_price')) == "0") {
            $drug_repo->unit_net_price = (int) $drug_repo->package_net_price / $drug_repo->unit_number;
        } else {
            $drug_repo->unit_net_price = $request->input('unit_net_price');
        }

        // Publish the new attributes to the repo and bind it with the appropriate drug
        $drug_repo->update();

        // Get all the drugs
        $drug = Drug::find($drug_repo->drug_id);
        // Return the appropriate view
        return view('drug.show-repo')->with('drug',  $drug);
    }

    /**
     * Update Drug Main Details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the targeted drug
        $drug =  Drug::find($id);

        // Grab the drug data
        $drug->name_english = $request->input('name_english');
        $drug->name_arabic = $request->input('name_arabic');
        $drug->chemical_composition = $request->input('chemical_composition');
        $drug->volume_unit = $request->input('volume_unit');
        $drug->lic_palte = $request->input('lic_palte');
        $drug->local_barcode = $request->input('local_barcode');
        $drug->global_barcode = $request->input('global_barcode');

        // Associate the foreign keys
        $drug->company()->associate(Company::find($request->input('company_id')));
        $drug->category()->associate(DrugCategory::find($request->input('category_id')));
        $drug->shape()->associate(DrugShape::find($request->input('shape_id')));

        // Update the drug
        $drug->update();
        // Return the appropriate view
        return redirect()->route('drug.index');
    }


    /**
     * Calculate the net price of the entered drugs info.
     * The drugs information are an array, each element has the following attributes:
     * [Drug ID, Packages number, Units number, New package sell price, New unit sell price]
     *
     * TODO: Be attention when the first available repo is not enough to fullfil the required quantity.
     */
    public function calculate_prices(Request $request)
    {
        if ($request->ajax()) {
            // Get the drugs isds and information
            $drugs_ids = $request->input('drugs.ids.*');
            $drugs_packages_number = $request->input('drugs.packages_number.*');
            $drugs_units_number = $request->input('drugs.units_number.*');
            $modified_drugs_package_sell_price = $request->input('drugs.modified_drugs_package_sell_price.*');
            $modified_drugs_unit_sell_price = $request->input('drugs.modified_drugs_unit_sell_price.*');

            // Drugs info
            // Each element will have the following struture
            // [Drug ID, Packages number, Units number, New package sell price, New unit sell price]
            $drugs_info = array();

            for ($i = 0; $i < count($drugs_ids); $i++) {
                // Create each list entry of the drugs list
                $drug_info = array($drugs_ids[$i], $drugs_packages_number[$i], $drugs_units_number[$i], $modified_drugs_package_sell_price[$i], $modified_drugs_unit_sell_price[$i]);
                array_push($drugs_info, $drug_info);
            }

            $full_net_price = 0;
            $full_sell_price = 0;
            // Loop over each drug
            foreach ($drugs_info as $drug_info) {
                // Grap the required drug information
                $drug_id = $drug_info[0];
                // Get the oldest drug repo
                $drug_repo = DrugsRepo::where([['drug_id', $drug_id], ['isDisposed', false]])->orderBy('exp_date', 'ASC')->first();
                $drug_packages_number = $drug_info[1];
                $drug_units_number = $drug_info[2];
                $drug_package_new_sell_price = $drug_info[3];
                $drug_unit_new_sell_price = $drug_info[4];

                // Manipulate the quantity and the price
                if ($drug_units_number != null || $drug_units_number != '') {
                    $full_net_price += $drug_repo->unit_net_price * $drug_units_number;
                    if ($drug_unit_new_sell_price != null || $drug_unit_new_sell_price != '') {
                        $full_sell_price += $drug_units_number * $drug_unit_new_sell_price;
                    } else {
                        $full_sell_price += $drug_units_number * $drug_repo->unit_sell_price;
                    }
                } else {
                    $full_net_price += $drug_repo->package_net_price * $drug_packages_number;
                    if ($drug_package_new_sell_price != null) {
                        $full_sell_price += $drug_packages_number * $drug_package_new_sell_price;
                    } else {
                        $full_sell_price += $drug_packages_number * $drug_repo->package_sell_price;
                    }
                }
            }

            // Return the final result
            $result = [];
            array_push($result, $full_net_price, $full_sell_price);
            return $result;

            return $result;
        }
    }

    /**
     * Update the repo when a sell invoice is generated.
     * The update will happen on the oldest drug repo (according to the expiration date).
     * The passed drugs info will be a list of lists.
     * Each element of this list contains the following information:
     * [Drug ID, Packages number, Units number, New package sell price, New unit sell price]
     *
     * @return List [Full net price of the selled drugs, Full sell price of the selled drugs]
     */
    public function update_drug_repo_from_sell_invoice($invoice_id, $drugs_info)
    {
        $full_net_price = 0;
        $full_sell_price = 0;
        // Loop over each drug
        foreach ($drugs_info as $drug_info) {
            // Grap the required drug information
            $drug_id = $drug_info[0];
            // Get the oldest drug repo
            $drug_repo = DrugsRepo::where([['drug_id', '=', $drug_id], ['isDisposed', '=', false]])->orderBy('exp_date', 'ASC')->first();
            $drug_packages_number = $drug_info[1];
            $drug_units_number = $drug_info[2];
            $drug_package_new_sell_price = $drug_info[3];
            $drug_unit_new_sell_price = $drug_info[4];

            // Create the drugs invoice records for this sell invoice
            $drugs_invoice = new DrugInvoice;
            $drugs_invoice->drug_id = $drug_id;
            $drugs_invoice->invoice_id = $invoice_id;
            $drugs_invoice->drug_repo_id = $drug_repo->id;

            // Manipulate the quantity and the price
            if ($drug_units_number != null) {
                $drug_repo->packages_number -= (int) ($drug_units_number / $drug_repo->unit_number);
                $drug_repo->units_number -= $drug_units_number;
                $full_net_price += $drug_repo->unit_net_price * $drug_units_number;
                if ($drug_unit_new_sell_price != null) {
                    $full_sell_price += $drug_units_number * $drug_unit_new_sell_price;
                    $drugs_invoice->modified_drug_unit_sell_price = $drug_unit_new_sell_price;
                } else {
                    $drugs_invoice->modified_drug_unit_sell_price = 0;
                    $full_sell_price += $drug_units_number * $drug_repo->unit_sell_price;
                }
                $drugs_invoice->drug_unit_number = $drug_units_number;
                $drugs_invoice->drug_package_number = (int) ($drugs_invoice->drug_unit_number / $drug_repo->unit_number);
                $drugs_invoice->modified_drug_package_sell_price = 0;
            } else {
                $drug_repo->packages_number -= $drug_packages_number;
                $drug_repo->units_number -= $drug_packages_number * $drug_repo->unit_number;
                $full_net_price += $drug_repo->package_net_price * $drug_packages_number;
                if ($drug_package_new_sell_price != null) {
                    $full_sell_price += $drug_packages_number * $drug_package_new_sell_price;
                    $drugs_invoice->modified_drug_package_sell_price = $drug_package_new_sell_price;
                } else {
                    $drugs_invoice->modified_drug_package_sell_price = 0;
                    $full_sell_price += $drug_packages_number * $drug_repo->package_sell_price;
                }
                $drugs_invoice->drug_package_number = $drug_packages_number;
                $drugs_invoice->drug_unit_number = $drugs_invoice->drug_package_number * $drug_repo->unit_number;
                $drugs_invoice->modified_drug_unit_sell_price = 0;
            }

            // Publish the new attributes to the repo
            $drug_repo->save();
            $drugs_invoice->save();
        }

        // Return the final result
        $result = [];
        array_push($result, $full_net_price, $full_sell_price);
        return $result;
    }

    /**
     * Update the repo.
     * This method is used when receiving a buy invoice.
     * The needed information are passed as a list of lists ($drugs_info).
     * Each element of this list contains the following information:
     * [Drug ID, Unit number, Packages number, Units number, Expiration date, Production date, Package Sell price, Package Net price, Unit Sell price, Unit Net price]
     *
     * @return boolean True if storing all the new quantities completed successfully, unhandled exception otherwise
     */
    public function update_drugs_repo_from_incoming_invoice($order_id, $drugs_info)
    {
        // Loop over each drug
        foreach ($drugs_info as $drug_info) {
            // Grap the required drug information
            $drug = Drug::find($drug_info[0]);
            $drug_unit_number = $drug_info[1];
            $drug_packages_number = $drug_info[2];
            $drug_units_number = $drug_info[3];
            $drug_exp_date = $drug_info[4];
            $drug_pro_date = $drug_info[5];
            $drug_package_sell_price = $drug_info[6];
            $drug_package_net_price = $drug_info[7];
            $drug_unit_sell_price = $drug_info[8];
            $drug_unit_net_price = $drug_info[9];

            // Initiate a new drug repo instance
            $drug_repo = new DrugsRepo;
            $drug_repo->pro_date = $drug_pro_date;
            $drug_repo->exp_date = $drug_exp_date;

            // Bind each repo with the appropriate order
            $drug_repo->order_id = $order_id;

            if ($drug_unit_number != null) {
                $drug_repo->unit_number = $drug_unit_number;
            } else {
                $drug_repo->unit_number = 1;
            }

            // Manipulate the quantity and prices
            if ($drug_units_number != null) {
                $drug_repo->packages_number = (int) ($drug_units_number / $drug_repo->unit_number);
                $drug_repo->units_number = $drug_units_number;
            } else {
                $drug_repo->packages_number = $drug_packages_number;
                $drug_repo->units_number = $drug_repo->unit_number * $drug_repo->packages_number;
            }
            // Set the prices
            if ($drug_package_sell_price != null) {
                $drug_repo->package_sell_price = $drug_package_sell_price;
                if ($drug_unit_sell_price == null) {
                    $drug_repo->unit_sell_price = $drug_repo->package_sell_price / $drug_repo->unit_number;
                } else {
                    $drug_repo->unit_sell_price = $drug_unit_sell_price;
                }
            }
            if ($drug_package_net_price != null) {
                $drug_repo->package_net_price = $drug_package_net_price;
                if ($drug_unit_net_price == null) {
                    $drug_repo->unit_net_price = $drug_repo->package_net_price / $drug_repo->unit_number;
                } else {
                    $drug_repo->unit_net_price = $drug_unit_net_price;
                }
            }

            // Publish the new attributes to the repo
            $drug_repo->drug()->associate($drug);
            $drug_repo->save();
        }
        return true;
    }

    /**
     * Update the repo.
     * This method is used when selling a prescription for a special customer.
     * The needed information are passed as a list of lists ($drugs_info).
     * Each element of this list contains the following information:
     * [Drug ID, Packages number, Units number]
     */
    public function update_drugs_repo_from_prescription_invoice($drugs_info)
    {
        // Loop over each drug
        foreach ($drugs_info as $drug_info) {
            // Grap the required drug information
            $drug = Drug::find($drug_info[0]);
            $drug_repo = $drug->repo()->where('isDisposed', false)->orderBy('exp_date', 'ASC')->get()->first();
            $drug_packages_number = $drug_info[1];
            $drug_units_number = $drug_info[2];

            // Manipulate the quantity and the price
            if ($drug_units_number != 0) {
                $drug_repo->packages_number -= (int) ($drug_units_number / $drug_repo->unit_number);
                $drug_repo->units_number -= $drug_units_number;
            } else {
                $drug_repo->packages_number -= $drug_packages_number;
                $drug_repo->units_number -= $drug_packages_number * $drug_repo->unit_number;
            }
            $drug_repo->save();
        }
    }
}
