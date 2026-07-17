<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\Documents;
use App\Models\Role;
use App\Models\RoleLevel;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends BaseController
{
    use ResponseTrait;
    protected $user;
    protected $role;
    protected $document;

    public function __construct()
    {
        $this->user = new User();
        $this->role = new Role();
        $this->document = new Documents();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->user->getUserList($request);
        $response['roleList'] = $this->role->select('id,name')->findAll();
        $response['employerList'] = [];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function view()
    {
        $request = $this->request->getPost();
        $response = null;
        if ($request['type'] == "add") {
            $countries = model(Country::class)->select('id,name')->get()->getResultArray();
            $data = [
                'countries' => $countries,
                'assign_to' => []
            ];
        }
        if ($request['type'] == "edit") {
            $countries = model(Country::class)->select('id,name')->get()->getResultArray();
            $user = model(User::class)
                ->select('user.*,IF(image IS NOT NULL,CONCAT("' . base_url("profile_picture") . '/' . '",user.image),"") AS image,states.name as state_name,cities.name as city_name, countries.name as country_name')
                ->join('countries', 'countries.id = user.country', 'LEFT')
                ->join('states', 'states.id = user.state', 'LEFT')
                ->join('cities', 'cities.id = user.city', 'LEFT')
                ->where('user.id', $request['id'])->get()->getRow();
            if ($user->alternate_mobile_number != null) {
                $user->alternate_mobile_number = explode(",", $user->alternate_mobile_number);
            } else {
                $user->alternate_mobile_number = array();
            }
            if ($user != '') {
                unset($user->password);
            }
            $state = model(State::class)->select('id,name')->where('country_id', $user->country)->get()->getResultArray();
            $city = model(City::class)->select('id,name')->where('state_id', $user->state)->get()->getResultArray();

            $roleID = $user->role_id;
            $roleDetails = $this->role->find($roleID);
            $roleLevel = model(RoleLevel::class)->find($roleDetails['level_id']);
            $getParentLevelRoles = $this->role->where('level_id', $roleLevel['parent_level'])->findColumn('id');
            $assignList = [];
            if ($getParentLevelRoles) {
                $assignList = $this->user->select('id,first_name,last_name')->whereIn('id', $getParentLevelRoles)->findAll();
            }

            $data = [
                'user' => $user,
                'state' => $state,
                'city' => $city,
                'countries' => $countries,
                'assign_to' => $assignList
            ];
        }
        $response = $data;
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $profilePicture = $this->request->getFile('image');
        $documentFiles = $this->request->getFileMultiple('documents');

        $validationRules      = [
            'username'          => ['label' => 'username', 'rules' => 'required|is_unique[user.username]'],
            'first_name'        => ['label' => 'first name', 'rules' => 'required'],
            'last_name'         => ['label' => 'last name', 'rules' => 'required'],
            'email'             => ['label' => 'email', 'rules' => 'required|is_unique[user.email]'],
            'personal_email'    => ['label' => 'personal email', 'rules' => 'required|is_unique[user.personal_email]'],
            'password'          => ['label' => 'password', 'rules' => 'required'],
            'mobile_number'     => ['label' => 'mobile number', 'rules' => 'required'],
            'gender'            => ['label' => 'gender', 'rules' => 'required'],
            'status'            => ['label' => 'status', 'rules' => 'required'],
        ];

        if (isset($profilePicture)) {
            $validationRules      = [
                'image' => ['label' => 'profile picture', 'rules' => 'uploaded[image]|mime_in[image,image/png,image/jpeg,image/jpg]|max_size[image,2048]'],
            ];
        }


        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $mobileNumberEmail = isset($request['alternate_mobile_number']) ? implode(',', $request['alternate_mobile_number']) : '';
            $newData = [
                'username'                  => $request['username'],
                'first_name'                => $request['first_name'],
                'last_name'                 => $request['last_name'],
                'email'                     => $request['email'],
                'personal_email'            => $request['personal_email'],
                'password'                  => $request['password'],
                'mobile_number'             => $request['mobile_number'],
                'alternate_mobile_number'   => $mobileNumberEmail,
                'address'                   => $request['address'],
                'gender'                    => $request['gender'],
                'country'                   => $request['country'],
                'state'                     => $request['state'],
                'city'                      => $request['city'],
                'postcode'                  => $request['postcode'],
                'role_id'                   => $request['role_id'],
                'status'                    => $request['status'],
                'created_at'                => Time::now()
            ];
            if (isset($request['assign_to']) && $request['assign_to'] !== '') {
                $newData['assign_to'] = $request['assign_to'];
            }
            if (isset($logoFile)) {
                $fileName = time() . '.webp';
                \Config\Services::image()
                    ->withFile($profilePicture)
                    ->convert(IMAGETYPE_WEBP)
                    ->save(FCPATH . '/profile_picture/' . $fileName);
                $newData['image'] =  $fileName;
            }
            $this->user->save($newData);

            $userID = $this->user->getInsertID();

            if (isset($documentFiles) && count($documentFiles) > 0) {
                foreach ($documentFiles as $val) {
                    // $newName = $val->getRandomName();
                    $newName = time() . '_' . $val->getName();
                    $val->move(FCPATH . '/user_documents/', $newName);
                    $documentData = [
                        'type' => 'user',
                        'parent_id' => $userID,
                        'document' => $newName,
                        'created_at'  => Time::now(),
                    ];
                    $this->document->save($documentData);
                }
            }
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_USER]);
    }

    public function updateProfile()
    {
        $request = $this->request->getPost();
        $profilePicture = $this->request->getFile('image');
        $validationRules  = [
            "first_name"        =>  ["label" => "first name", "rules" => "required"],
            "last_name"         =>  ["label" => "last name", "rules" => "required"],
            "gender"            =>  ["label" => "gender", "rules" => "required"],
            "address"           =>  ["label" => "address", "rules" => "required"],
            "country"           =>  ["label" => "country", "rules" => "required"],
            "state"             =>  ["label" => "state", "rules" => "required"],
            "city"              =>  ["label" => "city", "rules" => "required"],
            "postcode"          =>  ["label" => "postcode", "rules" => "required"],
        ];

        if (isset($profilePicture)) {
            $validationRules      = [
                'image' => ['label' => 'profile picture', 'rules' => 'uploaded[image]|mime_in[image,image/png,image/jpeg,image/jpg]|max_size[image,2048]'],
            ];

            $getData = $this->user->where('id', $request['id'])->get()->getRow();
            if ($getData && $getData->image != '' && file_exists(FCPATH . '/profile_picture/' . $getData->image)) {
                unlink(FCPATH . '/profile_picture/' . $getData->image);
            }
        }

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $mobileNumberEmail = (isset($request['alternate_mobile_number']) && $request['alternate_mobile_number'] != '') ? implode(',', $request['alternate_mobile_number']) : '';
            $newData = [
                'first_name'                => $request['first_name'],
                'last_name'                 => $request['last_name'],
                'personal_email'            => isset($request['personal_email']) ? $request['personal_email'] : "",
                'alternate_mobile_number'   => $mobileNumberEmail,
                'address'                   => $request['address'],
                'gender'                    => $request['gender'],
                'country'                   => $request['country'],
                'state'                     => $request['state'],
                'city'                      => $request['city'],
                'postcode'                  => $request['postcode'],
                'updated_at'                => Time::now()
            ];

            if (isset($profilePicture)) {

                $fileName = time() . '.webp';
                \Config\Services::image()
                    ->withFile($profilePicture)
                    ->convert(IMAGETYPE_WEBP)
                    ->save(FCPATH . '/profile_picture/' . $fileName);
                $newData['image'] =  $fileName;
            }

            $this->user->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => $ex->getMessage()], '400');
        }
        $this->db->transCommit();
        // Send data to user Response
        $countries = model(Country::class)->select('id,name')->get()->getResultArray();
        $user = model(User::class)
            ->select('user.*,IF(image IS NOT NULL,CONCAT("' . base_url("profile_picture") . '/' . '",user.image),"") AS image,states.name as state_name,cities.name as city_name, countries.name as country_name')
            ->join('countries', 'countries.id = user.country', 'LEFT')
            ->join('states', 'states.id = user.state', 'LEFT')
            ->join('cities', 'cities.id = user.city', 'LEFT')
            ->where('user.id', $request['id'])->get()->getRow();
        if ($user->alternate_mobile_number != null) {
            $user->alternate_mobile_number = explode(",", $user->alternate_mobile_number);
        } else {
            $user->alternate_mobile_number = array();
        }
        if ($user != '') {
            unset($user->password);
        }
        $state = model(State::class)->select('id,name')->where('country_id', $user->country)->get()->getResultArray();
        $city = model(City::class)->select('id,name')->where('state_id', $user->state)->get()->getResultArray();
        $data = [
            'user' => $user,
            'state' => $state,
            'city' => $city,
            'countries' => $countries,
        ];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => USER_PROFILE_UPDATE, 'data' => $data]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $profilePicture = $this->request->getFile('image');
        $documentFiles = $this->request->getFileMultiple('documents');

        $validationRules      = [
            'username'      => ['label' => 'username', 'rules' => 'required|is_unique[user.username,id,{id}]'],
            'first_name'    => ['label' => 'first name', 'rules' => 'required'],
            'last_name'     => ['label' => 'last name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|is_unique[user.email,id,{id}]'],
            // 'password'      => ['label' => 'password', 'rules' => 'required'],
            'mobile_number' => ['label' => 'mobile number', 'rules' => 'required'],
            'gender'        => ['label' => 'gender', 'rules' => 'required'],
            'status'        => ['label' => 'status', 'rules' => 'required'],
        ];

        if (isset($profilePicture)) {
            $validationRules      = [
                'image' => ['label' => 'profile picture', 'rules' => 'uploaded[image]|mime_in[image,image/png,image/jpeg,image/jpg]|max_size[image,2048]'],
            ];

            $getData = $this->user->where('id', $request['id'])->get()->getRow();
            if ($getData && $getData->image != '' && file_exists(FCPATH . '/profile_picture/' . $getData->image)) {
                unlink(FCPATH . '/profile_picture/' . $getData->image);
            }
        }

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $mobileNumberEmail = isset($request['alternate_mobile_number']) ? implode(',', $request['alternate_mobile_number']) : '';
            $newData = [
                'username'                  => $request['username'],
                'first_name'                => $request['first_name'],
                'last_name'                 => $request['last_name'],
                'email'                     => $request['email'],
                'personal_email'            => $request['personal_email'],
                'password'                  => $request['password'],
                'mobile_number'             => $request['mobile_number'],
                'alternate_mobile_number'   => $mobileNumberEmail,
                'address'                   => $request['address'],
                'gender'                    => $request['gender'],
                'country'                   => $request['country'],
                'state'                     => $request['state'],
                'city'                      => $request['city'],
                'postcode'                  => $request['postcode'],
                'role_id'                   => $request['role_id'],
                'status'                    => $request['status'],
                'updated_at'                => Time::now()
            ];
            if (isset($request['assign_to']) && $request['assign_to'] !== '') {
                $newData['assign_to'] = $request['assign_to'];
            }
            !empty($request['password']) && $newData['password'] = $request['password'];

            if (isset($profilePicture)) {

                $fileName = time() . '.webp';
                \Config\Services::image()
                    ->withFile($profilePicture)
                    ->convert(IMAGETYPE_WEBP)
                    ->save(FCPATH . '/profile_picture/' . $fileName);
                $newData['image'] =  $fileName;
            }

            $this->user->update($request['id'], $newData);
            if (!empty($documentFiles)) {
                foreach ($documentFiles as $val) {
                    // $newName = $val->getRandomName();
                    $newName = time() . '_' . $val->getName();
                    $val->move(FCPATH . '/user_documents/', $newName);
                    $documentData = [
                        'type' => 'user',
                        'parent_id' => $request['id'],
                        'document' => $newName,
                        'created_at'  => Time::now(),
                    ];
                    $this->document->save($documentData);
                }
            }
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => $ex->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_USER]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $userData = $this->user->find($request['id']);

        if ($userData) {
            $userID = $request['id'];
            if ($userData && $userData['image'] != '' && file_exists(FCPATH . '/profile_picture/' . $userData['image'])) {
                unlink(FCPATH . '/profile_picture/' . $userData['image']);
            }
            $getAllDocuments = $this->document->where('type', 'user')->where('parent_id', $userID)->get()->getResultArray();
            foreach ($getAllDocuments as $key => $value) {
                if ($value &&  $value['document'] != '' && file_exists(FCPATH . '/user_documents/' . $value['document'])) {
                    unlink(FCPATH . '/user_documents/' . $value['document']);
                }
            }
            $this->document->where('type', 'user')->where('parent_id', $userID)->delete();
            try {
                $this->db->transBegin();
                $this->user->delete($userID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_USER]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => USER_NOT_FOUND], '404');
    }

    public function documentList()
    {
        $request = $this->request->getGet();
        $documents = $this->document->select('id,document,IF(document IS NOT NULL,CONCAT("' . base_url("user_documents") . '/' . '",document),"") AS document_link')->where('parent_id', $request['id'])->get()->getResultArray();
        if (!empty($documents)) {
            foreach ($documents as $key => $value) {
                $image_type = pathinfo(FCPATH . "/user_documents/" . $value['document'], PATHINFO_EXTENSION);
                $getFile = file_get_contents(FCPATH . "/user_documents/" . $value['document']);
                $image_type =  mime_content_type(FCPATH . "/user_documents/" . $value['document']);
                $documents[$key]['document_link'] = 'data:' . $image_type . ';base64,' . base64_encode($getFile);
            }
        }
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $documents]);
    }

    public function uploadDocument()
    {
        $request = $this->request->getPost();
        $document = $this->request->getFile('documents');

        $validationRules      = [
            'documents'      => ['label' => 'documents', 'rules' => 'uploaded[documents]|ext_in[documents,png,jpg,jpeg,webp,gif,bmp,pdf,xls,xlsx,doc,docs,csv,txt]'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {

            // $newName = $document->getRandomName();
            $newName = time() . '_' . $document->getName();
            $document->move(FCPATH . '/user_documents/', $newName);
            $documentData = [
                'type' => 'user',
                'parent_id' => $request['id'],
                'document' => $newName,
                'created_at'  => Time::now(),
            ];
            $this->document->save($documentData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => $ex->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_USER_DOC]);
    }

    public function deleteDocument()
    {
        $request = $this->request->getPost();
        $documentID = $request['id'];
        $document = $this->document->find($documentID);
        if ($document) {
            try {
                $this->db->transBegin();
                $this->document->delete($documentID);
                if ($document &&  $document['document'] != '' && file_exists(FCPATH . '/user_documents/' . $document['document'])) {
                    unlink(FCPATH . '/user_documents/' . $document['document']);
                }
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_USER_DOC]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => USER_DOC_NOT_FOUND], '404');
    }

    // User Profile 
    public function changePassword()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'current_password'      => ['label' => 'current password', 'rules' => 'required'],
            'password'              => ['label' => 'password', 'rules' => 'required']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $userID = getTokenUserID();
        $userData = $this->user->find($userID);
        if ($userData) {
            $checkPassword = password_verify($request['current_password'], $userData['password']);
            if ($checkPassword) {
                try {
                    $this->db->transBegin();
                    $newPassword = [
                        'password' => $request['password'],
                        'updated_at'    => Time::now()
                    ];
                    $this->user->update($userID, $newPassword);
                } catch (\Exception $err) {
                    $this->db->transRollback();
                    return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
                }
                $this->db->transCommit();
                return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => CHANGE_PASSWORD_SUCCESS]);
            }
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => CURRENT_PASSWORD_NOT_MATCH]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 401, 'message' => INVALID_USER], '401');
    }

    # Get Selected Role Users
    public function roleUsers()
    {
        $request = $this->request->getGet();
        $response = [];
        $getParentRoleLevel = $this->role->find($request['id']);
        $getLevel = model(RoleLevel::class)->find($getParentRoleLevel['level_id']);
        $getParentRole = $this->role->where('level_id', $getLevel['parent_level'])->findColumn('id');
        if ($getParentRole) {

            $userList = $this->user->select('id,first_name,last_name')->whereIn('role_id', $getParentRole)->findAll();
            $response = $userList;
        }
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }


    // Export User Data
    public function exportUser()
    {
        $request = $this->request->getPost();
        $users = $this->user->getByFilters($request);

        $fileName = 'user.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Username');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Mobile Number');
        $sheet->setCellValue('F1', 'Gender');
        $sheet->setCellValue('G1', 'Address');

        $rows = 2;
        foreach ($users as $key => $val) :
            $sheet->setCellValue('A' . $rows, $val['username']);
            $sheet->setCellValue('B' . $rows, $val['first_name']);
            $sheet->setCellValue('C' . $rows, $val['last_name']);
            $sheet->setCellValue('D' . $rows, $val['email']);
            $sheet->setCellValue('E' . $rows, $val['mobile_number']);
            $sheet->setCellValue('F' . $rows, $val['gender']);
            $sheet->setCellValue('G' . $rows, $val['address']);
            $rows++;
        endforeach;

        $writer = new Xlsx($spreadsheet);
        $writer->save("uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");

        $filepath = FCPATH . '/uploads/' . $fileName;
        $getFile = file_get_contents($filepath);
        $data = 'data:application/vnd.ms-excel;base64,' . base64_encode($getFile);

        if (file_exists($filepath)) {
            @unlink($filepath);
        }
        $response = [
            'file_name' => $fileName,
            'file_base64' => $data,
        ];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    // Import User Data
    public function importUser()
    {
        $file = $this->request->getFile('file');

        $validationRules      = [
            'file'      => ['label' => 'file', 'rules' => 'uploaded[file]|ext_in[file,xls,xlsx,csv]'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        if ($file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // $newName = $file->getRandomName();
                $newName = time() . '_' . $file->getName();
                $file->move('uploads/', $newName);

                $filepath = FCPATH . '/uploads/' . $newName;

                $arr_file         = explode('.', $newName);
                $extension         = end($arr_file);
                if ('csv' == $extension) {
                    $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet     = $reader->load($filepath);
                $sheet_data     = $spreadsheet->getActiveSheet()->toArray();

                if (file_exists($filepath)) {
                    @unlink($filepath);
                }

                $response['header'] = $sheet_data[0];
                $data = [];
                foreach ($sheet_data as $key => $value) :
                    if ($key !== 0) {
                        $data[] = $value;
                    }
                endforeach;
                $response['data'] = $data;
                $response['roleList'] = $this->role->select('id,name')->whereNotIn('id', [1, 2, 3])->findAll();
                return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
            }
        }
    }

    public function saveImportUser()
    {
        $request = $this->request->getPost();
        $this->db->transBegin();
        try {
            $newData = [];
            foreach ($request['users'] as $key => $value) :
                // $newData[] = $value;
                // $newData[$key]['password'] = $value['mobile_number'];
                // $newData[$key]['user_type'] = 'User';
                // $newData[$key]['status'] = 'Active';
                // $newData[$key]['created_at'] = Time::now();
                $newData = $value;
                $newData['password'] = $value['mobile_number'];
                $newData['user_type'] = 'User';
                $newData['status'] = 'Active';
                $newData['created_at'] = Time::now();
                $this->user->insert($newData);
            endforeach;
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => 'User data import successfully.']);
    }
}
