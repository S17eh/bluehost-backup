<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\Documents;
use App\Models\Employer;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class EmployerController extends BaseController
{
    use ResponseTrait;
    protected $employer;
    protected $user;
    protected $document;

    public function __construct()
    {
        $this->employer = new Employer();
        $this->user     = new User();
        $this->document = new Documents();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->employer->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function downloadDocument()
    {
        $request = $this->request->getPost();
        $fileName = $this->document->where('id', $request['id'])->get()->getRow()->document;

        $getFile = file_get_contents(FCPATH . "/company_documents" . '/' . $fileName);
        $FileMime = mime_content_type(FCPATH . "/company_documents" . '/' . $fileName);
        $filedata = 'data:application/' . $FileMime . ';base64,' . base64_encode($getFile);

        $data = [
            "file_name" => $fileName,
            "content" => $filedata
        ];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $data]);
    }

    public function create()
    {
        $userID = getTokenUserID();
        $request = $this->request->getPost();
        $logoFile = $this->request->getFile('logo');
        $documentFiles = $this->request->getFileMultiple('documents');

        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|is_unique[employer.email]'],
            'mobile_number' => ['label' => 'mobile number', 'rules' => 'required|is_unique[employer.mobile_number]'],
            'website'       => ['label' => 'website', 'rules' => 'required'],
            'rate'          => ['label' => 'rate', 'rules' => 'required']
        ];

        if (isset($logoFile)) {
            $validationRules      = [
                'logo' => ['label' => 'logo', 'rules' => 'uploaded[logo]|mime_in[logo,image/png,image/jpeg,image/jpg]|max_size[logo,2048]'],
            ];
        }


        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $alternateEmail = isset($request['alternate_email']) ? implode(',', $request['alternative_email']) : '';
            $mobileNumberEmail = isset($request['alternate_mobile_number']) ? implode(',', $request['alternate_mobile_number']) : '';
            $employerData = [
                'name'                      => $request['name'],
                'register_name'             => $request['register_name'],
                'gst_no'                    => $request['gst_no'],
                'email'                     => $request['email'],
                'alternate_email'           => $alternateEmail,
                'mobile_number'             => $request['mobile_number'],
                'alternate_mobile_number'   => $mobileNumberEmail,
                'website'                   => $request['website'],
                'address'                   => $request['address'],
                'rate_type'                 => $request['rate_type'],
                'rate'                      => $request['rate'],
                'status'                    => $request['status'],
                'created_at'                => Time::now()
            ];

            if (isset($logoFile)) {
                $fileName = time() . '.webp';
                \Config\Services::image()
                    ->withFile($logoFile)
                    ->convert(IMAGETYPE_WEBP)
                    ->save(FCPATH . '/company_logo/' . $fileName);
                $newData['logo'] =  $fileName;
            }

            $this->employer->save($employerData);
            $employerID = $this->employer->getInsertID();

            if (isset($documentFiles) && sizeof($documentFiles) > 0) {
                foreach ($documentFiles as $val) {
                    // $newName = $val->getRandomName();
                    $newName = time() . '_' . $val->getName();
                    $val->move(FCPATH . '/company_documents/', $newName);
                    $documentData = [
                        'type' => 'employer',
                        'parent_id' => $employerID,
                        'document' => $newName,
                        'created_at'  => Time::now(),
                    ];
                    $this->document->save($documentData);
                }
            }

            model(Notification::class)->setNotification($userID, 'Add Company', $request['name'] . ' , Add new Company');
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_EMPLOYER]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $logoFile = $this->request->getFile('logo');
        $documentFiles = $this->request->getFileMultiple('documents');

        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|is_unique[employer.email,id,{id}]'],
            'mobile_number' => ['label' => 'mobile number', 'rules' => 'required|is_unique[employer.mobile_number,id,{id}]'],
            'website'       => ['label' => 'website', 'rules' => 'required'],
            'rate'          => ['label' => 'rate', 'rules' => 'required']
        ];

        if (isset($logoFile)) {
            $validationRules      = [
                'logo' => ['label' => 'logo', 'rules' => 'uploaded[logo]|mime_in[logo,image/png,image/jpeg,image/jpg,image/webp]|max_size[logo,2048]'],
            ];

            $companySettingList = $this->employer->where('id', $request['id'])->get()->getRow();
            if ($companySettingList &&  $companySettingList->logo != '' && file_exists(FCPATH . '/company_logo/' . $companySettingList->logo)) {
                unlink(FCPATH . '/company_logo/' . $companySettingList->logo);
            }
        }

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {

            $alternateEmail = isset($request['alternate_email']) ? implode(',', $request['alternate_email']) : '';
            $mobileNumberEmail = isset($request['alternate_mobile_number']) ? implode(',', $request['alternate_mobile_number']) : '';

            $newData = [
                'name'                      => $request['name'],
                'register_name'             => $request['register_name'],
                'gst_no'                    => $request['gst_no'],
                'email'                     => $request['email'],
                'alternate_email'           => $alternateEmail,
                'mobile_number'             => $request['mobile_number'],
                'alternate_mobile_number'   => $mobileNumberEmail,
                'website'                   => $request['website'],
                'address'                   => $request['address'],
                'rate_type'                 => $request['rate_type'],
                'rate'                      => $request['rate'],
                'status'                    => $request['status'],
                'updated_at'                => Time::now()
            ];

            if (isset($logoFile)) {
                $fileName = time() . '.webp';
                \Config\Services::image()
                    ->withFile($logoFile)
                    ->convert(IMAGETYPE_WEBP)
                    ->save(FCPATH . '/company_logo/' . $fileName);
                $newData['logo'] =  $fileName;
            }

            $this->employer->update($request['id'], $newData);

            if (isset($documentFiles) && sizeof($documentFiles) > 0) {
                foreach ($documentFiles as $val) {
                    // $newName = $val->getRandomName();
                    $newName = time() . '_' . $val->getName();
                    $val->move(FCPATH . '/company_documents/', $newName);
                    $documentData = [
                        'type' => 'employer',
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
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_EMPLOYER]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $employer = $this->employer->getResource($request, false, true);

        if ($employer) {
            $employerID = $employer['id'];

            if ($employer &&  $employer['logo'] != '' && file_exists(FCPATH . '/company_logo/' . $employer['logo'])) {
                unlink(FCPATH . '/company_logo/' . $employer['logo']);
            }
            $getAllDocuments = $this->document->where('type', 'employer')->where('parent_id', $employerID)->get()->getResultArray();
            foreach ($getAllDocuments as $key => $value) {
                if ($value &&  $value['document'] != '' && file_exists(FCPATH . '/company_documents/' . $value['document'])) {
                    unlink(FCPATH . '/company_documents/' . $value['document']);
                }
            }
            $this->document->where('type', 'employer')->where('parent_id', $employerID)->delete();

            try {
                $this->db->transBegin();
                $this->employer->delete($employerID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_EMPLOYER]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => EMPLOYER_NOT_FOUND], '404');
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
                if ($document &&  $document['document'] != '' && file_exists(FCPATH . '/company_documents/' . $document['document'])) {
                    unlink(FCPATH . '/company_documents/' . $document['document']);
                }
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_EMPLOYER_DOC]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => EMPLOYER_DOC_NOT_FOUND], '404');
    }

    // Add Employer Controller
    public function addUser()
    {
        $request = $this->request->getPost();

        $validationRules      = [
            'username'      => ['label' => 'username', 'rules' => 'required|is_unique[user.username]'],
            'first_name'    => ['label' => 'first name', 'rules' => 'required'],
            'last_name'     => ['label' => 'last name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|is_unique[user.email]'],
            'password'      => ['label' => 'password', 'rules' => 'required'],
            'mobile_number' => ['label' => 'mobile number', 'rules' => 'required'],
            'gender'        => ['label' => 'gender', 'rules' => 'required'],
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'username'      => $request['username'],
                'first_name'    => $request['first_name'],
                'last_name'     => $request['last_name'],
                'email'         => $request['email'],
                'password'      => $request['password'],
                'mobile_number' => $request['mobile_number'],
                'address'       => $request['address'],
                'gender'        => $request['gender'],
                'country'       => $request['country'],
                'state'         => $request['state'],
                'city'          => $request['city'],
                'postcode'      => $request['postcode'],
                'role_id'       => 2,
                'employer_id'   => $request['employer_id'],
                'created_at'    => Time::now()
            ];

            $this->user->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_EMPLOYER_USER]);
    }
}
