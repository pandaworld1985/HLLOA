<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contracts extends CI_Controller
{

    protected $mainModel;

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("signin_m");
        $this->load->model("userpart_m");
        $this->load->model("userposition_m");
        $this->load->model("userrank_m");
        $this->load->model("userrole_m");
        $this->load->model("userprice_m");
        $this->load->model("contracts_m");
        $this->load->model("projects_m");
        $this->lang->load('main', $language);
        $this->load->library("pagination");
        $this->load->library("session");

        $this->mainModel = $this->contracts_m;
    }

    public function index()
    {
        if (!$this->checkRole()) {
            redirect(base_url('signin'));
            return;
        }

        $this->data['title'] = '财务管理 ＞ 合同管理';
        $this->data["subscript"] = "settings/script";
        $this->data["subcss"] = "settings/css";
        $this->data['apiRoot'] = $apiRoot = 'contracts/index';
        $this->data['mainModel'] = 'tbl_contracts';

        $this->data['userList'] = $this->users_m->getItems();
        $filter = array();
        $startNo = 0;
        if ($this->uri->segment(3) == '') $this->session->unset_userdata('filter');
        else $startNo = $this->uri->segment(3);
        if ($_POST) {
            $this->session->unset_userdata('filter');
            $filter['queryStr'] = $_POST['search_keyword'];
            $_POST['search_status'] != '' && $filter['tbl_contracts.status'] = $_POST['search_status'];
            $this->session->set_userdata('filter', $filter);
        }
        $this->session->userdata('filter') != '' && $filter = $this->session->userdata('filter');
        $queryStr = $filter['queryStr'] . '';
        unset($filter['queryStr']);
        $this->data['perPage'] = $perPage = 8;
        $this->data['cntPage'] = $cntPage = $this->mainModel->get_count($filter, $queryStr);
        $ret = $this->paginationCompress($apiRoot, $cntPage, $perPage, 3);
        $this->data['curPage'] = $curPage = $ret['pageId'];
        $this->data["list"] = $this->mainModel->getItemsByPage($filter, $ret['pageId'], $ret['cntPerPage'], $queryStr);

        $this->data["tbl_content"] = $this->output_content($this->data['list'], $startNo);

        $this->data["subview"] = $apiRoot;

        if (!$this->checkRole(17)) {
            $this->load->view('_layout_error', $this->data);
        } else {
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function output_content($items, $startNo = 0)
    {
        $userId = $this->session->userdata("_userid");
        $statusStr = ["未签", "已签", "已完成", "终止"];
        $output = '';
        $i = 0;
        foreach ($items as $unit):
            $i++;
            $startNo++;
            $editable = ($unit->progress < 2);
            $output .= '<tr>';
            $output .= '<td>' . sprintf("%02d", $startNo) . '</td>';
            $output .= '<td>' . $unit->no . '</td>';
            $output .= '<td>' . $unit->title . '</td>';
            $output .= '<td>' . $unit->total_price . '</td>';
            $output .= '<td class="paid_price">' . $unit->paid_price . '</td>';
            $output .= '<td>' . $unit->client_name . '</td>';
            $output .= '<td>' . $unit->project . '</td>';
            $output .= '<td>' . $unit->project_worker . '</td>';
            $output .= '<td>' . $unit->expire_date . '</td>';
            $output .= '<td>' . $unit->signed_date . '</td>';
            $output .= '<td>' . $statusStr[$unit->progress] . '</td>';
            $output .= '<td>';
            if (false && $userId != 1 && $unit->id == 1) {

            } else {
                if ($editable) {
                    $output .= '<div class="btn-rect btn-orange" onclick="editItem(this);"'
                        . ' data-id="' . $unit->id . '" '
                        . '>编辑</div>';
                }
                $output .= '<div class="btn-rect btn-green" onclick="viewItem(this);"'
                    . ' data-id="' . $unit->id . '" '
                    . '>查看详情</div>';
            }
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function viewdata($id = 0)
    {
        if (!$this->checkRole()) {
            redirect(base_url('signin'));
            return;
        }

        $this->data["subscript"] = "settings/script";
        $this->data["subcss"] = "settings/css";
        $this->data['apiRoot'] = $apiRoot = 'contracts/viewdata';
        $this->data["subview"] = $apiRoot;
        $this->data['menuId'] = 0;

        $postdata = $this->mainModel->get_where(array('id' => $id));

        $this->data['postdata'] = '';
        if ($postdata) {
            $ext = explode('.', $postdata[0]->data);
            $ext = $ext[count($ext) - 1];
            switch ($ext) {
                case 'pdf':
                    $this->data['postdata'] = base_url() . $postdata[0]->data;
                    break;
                case 'doc':
                case 'docx':
                    $this->data['postdata'] =
                        'https://view.officeapps.live.com/op/embed.aspx?src=' .
                        base_url() . $postdata[0]->data;
                    break;
            }
        }

        if (!$this->checkRole(17)) {
            $this->load->view('_layout_error', $this->data);
        } else {
            $this->load->view('_layout_post', $this->data);
        }
    }


    public function updateItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->checkRole(17)) {
            $ret['data'] = '用户权限错误';
            echo json_encode($ret);
            return;
        }
        $user_id = $this->session->userdata('_userid');
        if ($_POST) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');

            $editArr = array(
                'no' => $this->input->post('no'),
                'planner_id' => $user_id,
                'title' => $this->input->post('title'),
                'total_price' => $this->input->post('total_price'),
                'client_name' => $this->input->post('client_name'),
                'signed_date' => $this->input->post('signed_date'),
                'expire_date' => $this->input->post('expire_date'),
                'progress' => $this->input->post('progress'),
                'status' => 1,
                'description' => $this->input->post('description'),
                'update_time' => date("Y-m-d H:i:s")
            );
            switch ($type) {
                case '0':
                    $editArr['title'] = $this->input->post('title');
                    if ($_FILES["docFile"]["name"] == '') break;
                    if ($id == 0) {
                        $editArr['create_time'] = date("Y-m-d H:i:s");
                        $id = $this->mainModel->add($editArr);
                    }
                    $config['upload_path'] = "./uploads/contracts";
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path']);
                    }
                    $config['allowed_types'] = '*';
                    $filename = 'contract_' . $id;
                    $fileFormat = strtolower($this->input->post('docFileFormat'));
                    $this->load->library('upload', $config);

                    $fileData = '';
                    if ($_FILES["docFile"]["name"] != '') {
                        $nameSuffix = '';
                        $config['file_name'] = $filename . $nameSuffix . '.' . $fileFormat;
                        if (file_exists(substr($config['upload_path'], 2) . '/' . $config['file_name'])) {
                            unlink(substr($config['upload_path'], 2) . '/' . $config['file_name']);
                        }
                        $this->upload->initialize($config, TRUE);
                        switch ($fileFormat) {
                            case 'doc':
                            case 'docx':
                            case 'pdf':
                                ///Image file uploading........
                                if ($this->upload->do_upload('docFile')) {
                                    $data = $this->upload->data();
                                    $fileData = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                                } else {
                                    $ret['data'] = '文档上传错误' . $this->upload->display_errors();
                                    $ret['status'] = 'fail';
                                    echo json_encode($ret);
                                    return;
                                }
                                break;
                        }
                    }
                    if ($fileData) $editArr['data'] = $fileData;
                    break;
                case '1':
                    $editArr['title'] = $this->input->post('title');
                    if ($_FILES["imgFile"]["name"] == '') break;
                    if ($id == 0) {
                        $editArr['create_time'] = date("Y-m-d H:i:s");
                        $id = $this->mainModel->add($editArr);
                    }
                    $config['upload_path'] = "./uploads/posts";
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path']);
                    }
                    $config['allowed_types'] = '*';
                    $filename = 'post_' . $id;
                    $fileFormat = strtolower($this->input->post('imgFileFormat'));
                    $this->load->library('upload', $config);

                    $fileData = '';
                    if ($_FILES["imgFile"]["name"] != '') {
                        $nameSuffix = '';
                        $config['file_name'] = $filename . $nameSuffix . '.' . $fileFormat;
                        if (file_exists(substr($config['upload_path'], 2) . '/' . $config['file_name'])) {
                            unlink(substr($config['upload_path'], 2) . '/' . $config['file_name']);
                        }
                        $this->upload->initialize($config, TRUE);
                        switch ($fileFormat) {
                            case 'gif':
                            case 'png':
                            case 'jpg':
                            case 'jpeg':
                            case 'bmp':
                                ///Image file uploading........
                                if ($this->upload->do_upload('imgFile')) {
                                    $data = $this->upload->data();
                                    $fileData = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                                } else {
                                    $ret['data'] = '封面图片上传错误' . $this->upload->display_errors();
                                    $ret['status'] = 'fail';
                                    echo json_encode($ret);
                                    return;
                                }
                                break;
                        }
                    }
                    if ($fileData) $editArr['data'] = $fileData;
                    break;
            }
            if ($id == 0) {
                $editArr['price_detail'] = '[]';
                $editArr['paid_price'] = 0;
                $editArr['create_time'] = date("Y-m-d H:i:s");
                $result = $this->mainModel->add($editArr);
            } else {
                $result = $this->mainModel->edit($editArr, $id);
            }
            if ($result > 0) {
                $ret['item'] = $this->mainModel->get_where(array('id' => $id));
            }
            $ret['data'] = '操作成功';
            $ret['status'] = 'success';
        }

        echo json_encode($ret);
    }

    public function updatePriceDetail()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->checkRole(17)) {
            $ret['data'] = '用户权限错误';
            echo json_encode($ret);
            return;
        }
        $user_id = $this->session->userdata('_userid');
        if ($_POST) {
            $id = $this->input->post('id');
            $updateItem = $this->mainModel->get_where(array('id' => $id));
            $priceDetail = json_decode($updateItem[0]->price_detail);
            array_push($priceDetail, array(
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'paid' => $this->input->post('paid'),
                'created' => date('Y-m-d H:i:s')
            ));
            $priceDetail = json_decode(json_encode($priceDetail));
            $totalPrice = 0;
            foreach ($priceDetail as $item) {
                $totalPrice += $item->price;
            }

            $priceDetail = json_encode($priceDetail);
            foreach ($updateItem as $item) {
                $this->mainModel->edit(array(
                    'price_detail' => $priceDetail,
                    'paid_price' => $totalPrice,
                ), $item->id);
            }
            $ret['data'] = array('price_detail' => $priceDetail, 'paid_price' => $totalPrice);
            $ret['status'] = 'success';
        }

        echo json_encode($ret);
    }


    public function publishItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->checkRole()) {
            $ret['data'] = '用户权限错误';
            echo json_encode($ret);
            return;
        }
        if ($_POST) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            if ($id < 0) {
                $filter = array();
                $this->session->userdata('filter') != null && $filter = $this->session->userdata('filter');
                $pageId = 0;
                if (isset($_POST['pageId'])) $pageId = $_POST['pageId'];
                $perPage = PERPAGE;
                $lists = $this->mainModel->getItemsByPage($filter, $pageId, $perPage);
                foreach ($lists as $item) $this->mainModel->publish($item->id, $status);
            } else {
                $this->mainModel->publish($id, $status);
            }
            $ret['data'] = $ret['data'] = '操作成功';//$this->output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function deleteItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->checkRole(17)) {
            $ret['data'] = '用户权限错误';
            echo json_encode($ret);
            return;
        }
        if ($_POST) {
            $id = $_POST['id'];
            $user_id = $this->session->userdata('_userid');

            $result = $this->mainModel->delete($id);
            $ret['data'] = '操作成功';
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function checkRole($id = -1)
    {
        if (!$this->signin_m->isloggedin()) return false;

        if ($id == -1) return true;

        $permission = $this->session->userdata('_permission');
        if ($permission != NULL) {
            $permissionData = (array)(json_decode($permission));
            $accessInfo = $permissionData['m' . $id];
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }
}

?>