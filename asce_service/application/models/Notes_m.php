<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notes_m extends CI_Model {

    private $table_name = 'users';   // user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name = 'user_profiles';
    private $notes_tablename = 't_txtnotes'; // Notes

    function __construct() {
        parent::__construct();
    }

    // Insert Notes 
    function addnotes($notesecid, $notes_start, $notes_end, $notes_tagname, $notes_targetid, $notes_content, $notes_chapid, $notes_input_content, $notes_input_gender, $user_id, $cus_book_id, $master_id, $orderid, $email, $node_status, $noteId) {
        if ($master_id == "") {
            $master_id = "0000000";
        }
        if ($email == "") {
            $orderid = "0000000";
            $email = "superadmin";
        }
        if ($email == "superadmin") {
            $orderid = "0000000";
        }
        // $node_status=0;
        // print_r($email.'/fdfdfdfdfdfdfdfdfd/'.$master_id); die;
        $this->db->select('t_txnid,t_txndata,t_txnusrid', 't_txnsecid', 't_txntxtstart', 't_txntxtend', 't_txntagname', 't_txnpgeid', 't_txnusername', 'notedata', 't_txncontent', 't_textstatus', 't_txnchpid', 't_txncus_book_id');
        $this->db->from('t_txtnotes');
        $query = $this->db->get();
        $query->result();
        $this->db->set('t_txnid', $noteId);
        $this->db->set('t_txnsecid', $notesecid);
        $this->db->set('t_txntxtstart', $notes_start);
        $this->db->set('t_txntxtend', $notes_end);
        $this->db->set('t_txntagname', $notes_tagname);
        $this->db->set('t_txnpgeid', $notes_targetid);
        $this->db->set('t_txndata', $notes_content);
        $this->db->set('t_txncontent', $notes_input_content);
        $this->db->set('t_textstatus', $notes_input_gender);

        //$this->db->set('node_status',$node_status);
        $this->db->set('t_txnchpid', $notes_chapid);
        $this->db->set('t_txncus_book_id', $cus_book_id);
        $this->db->set('t_txnusrid', $user_id);
        $this->db->set('t_txncreateddate', 'NOW()', FALSE);
        $this->db->set('t_txnupdateddate', 'NOW()', FALSE);
        $this->db->set('master_id', $master_id);
        $this->db->set('orderid', $orderid);
        $this->db->set('cemail', $email);
        $this->db->set('node_status', $node_status);
        //print_r($this); die;
        $this->db->insert('t_txtnotes', $this);
        //echo $this->db->last_query(); die;
        $note_section['t_txnid'] = $this->db->insert_id();
        $note_section['t_txncontent'] = $notes_input_content;

        return $note_section;
    }

    //retrive Notes
    function retrivenotes($chapId, $user_id, $cus_book_id, $master_id, $orderid, $email, $userinfo) {

        if ($userinfo == 'admin' && $email != 'IPBASED') {

            $this->db->select('t_txnid,master_id,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            $this->db->from('t_txtnotes');
            $this->db->where('t_txnusrid!=1');
            $this->db->order_by("t_txnsecid", "ASC");
            //$this->db->order_by("t_txnchpid", "desc");
            if ($chapId == '') {
                $this->db->where('t_txnusrid= "' . $user_id . '" and t_txncus_book_id="' . $cus_book_id . '" and orderid="' . $orderid . '" and cemail="' . $email . '"');
                //$this->db->or_where(array('node_status'=> 2));
                $this->db->or_where('orderid ="' . $orderid . '" and t_txncus_book_id="' . $cus_book_id . '" and node_status="2"');
            } else {
                $this->db->where(array('t_txnchpid' => $chapId, 't_txncus_book_id' => $cus_book_id, 'orderid' => $orderid, 'node_status' => 2));
            }

            $query = $this->db->get();
            //die('mmmmmmm'.$this->db->last_query());
            return $query->result();
        } else if ($userinfo == 'admin' && $email == 'IPBASED') {
            $this->db->where('t_txnusrid!=1');
            $this->db->select('t_txnid,master_id,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            $this->db->from('t_txtnotes');
            $this->db->order_by("t_txnsecid", "ASC");
            $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 'orderid' => $orderid, 'node_status' => 0));
            $this->db->or_where(array('node_status' => 2));
            $this->db->where(array('orderid' => $orderid, 't_txncus_book_id' => $cus_book_id));
            $query = $this->db->get();
            //die('kkkkkk'.$this->db->last_query());
            return $query->result();
        } else if ($userinfo == 'subuser' && $email != 'IPBASED') {
            //echo "fdfdfdf"; die;
            //$this->db->select('t_txnid,t_txncus_book_id,t_txntagname,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            // $this->db->from('t_txtnotes');
            $this->db->select('t_txnid,master_id,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            $this->db->from('t_txtnotes');
            $this->db->order_by("t_txnsecid", "ASC");
            //$this->db->order_by("t_txnchpid", "desc");
            $this->db->where('t_txnusrid!=1');
            //$this->db->where(array('t_txnusrid' => $user_id,'t_txncus_book_id'=>$cus_book_id,'master_id'=>$master_id,'email'=>$email ));
            if ($chapId == '') {
                $this->db->where('t_txnusrid= "' . $user_id . '" and t_txncus_book_id="' . $cus_book_id . '" and orderid="' . $orderid . '" and cemail="' . $email . '" and node_status="0"');
                //$this->db->or_where(array('node_status'=> 2));
                //$this->db->or_where('orderid ="' . $orderid . '" and t_txncus_book_id="' . $cus_book_id . '" and node_status="2"');




                //$this->db->where(array('node_status'=> 2));
            } else {
                $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 'orderid' => $orderid, 'cemail' => $email, 't_txnchpid' => $chapId, 'node_status' => 0));
                //$this->db->or_where(array('node_status'=> 2));
                //$this->db->or_where(array('orderid' => $orderid, 't_txncus_book_id' => $cus_book_id, 'node_status' => 2));
            }

            $query = $this->db->get();
            $resultValue = $query->result();
            //echo "<pre>QUERY";print_r($this->db->last_query());   die;
            $finalResultWithoutAdmin = array();
            foreach ($resultValue as $ResultObj) {
                if ($ResultObj->master_id == '0000000')
                    continue;
                $finalResultWithoutAdmin[] = $ResultObj;
            }
            return $finalResultWithoutAdmin;
            //return $query->result();
        }



        else if ($userinfo == 'subuser' && $email == 'IPBASED') {

            $this->db->select('t_txnid,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            $this->db->from('t_txtnotes');
            $this->db->order_by("t_txnsecid", "ASC");
            $this->db->where('t_txnusrid!=1');
            if ($chapId == '') {
                $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 'orderid' => $orderid, 'cemail' => $email, 'node_status' => 0));
                $this->db->or_where(array('node_status' => 2));
                $this->db->where(array('orderid' => $orderid, 't_txncus_book_id' => $cus_book_id));
            } else {
                $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 'orderid' => $orderid, 'cemail' => $email, 't_txnchpid' => $chapId, 'node_status' => 0));
                $this->db->or_where(array('node_status' => 2));
                $this->db->where(array('orderid' => $orderid, 't_txncus_book_id' => $cus_book_id));
            }

            $query = $this->db->get();
            //echo 'eeee'.$this->db->last_query(); die;
            return $query->result();
        } else if ($userinfo == 'superadmin' && $email != 'IPBASED') {
            //echo "subuser"; die;
            $this->db->select('t_txnid,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
            $this->db->from('t_txtnotes');
            $this->db->order_by("t_txnsecid", "ASC");
            //$this->db->order_by("t_txnchpid", "desc");
            //$this->db->where(array('t_txnusrid' => $user_id,'t_txnchpid'=>$chapId, 't_txncus_book_id'=>$cus_book_id ));
            if ($chapId == '') {
                $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 'master_id' => $master_id, 'cemail' => $email));
            } else {
                $this->db->where(array('t_txnusrid' => $user_id, 't_txnchpid' => $chapId, 't_txncus_book_id' => $cus_book_id, 'master_id' => $master_id, 'cemail' => $email));
            }

            $query = $this->db->get();
            //echo 'dddd'.$this->db->last_query(); die;
            return $query->result();
        }
    }

    //get all bublic note
    /* function retrivenotesPublic($chapId,$cus_book_id,$master_id)
      {
      $this->db->select('t_txnid,t_txncus_book_id,t_txntagname,t_txnpgeid,t_txnusrid,t_txnsecid,t_txndata,t_txncontent,t_textstatus,t_txnchpid');
      $this->db->from('t_txtnotes');
      $this->db->order_by("t_txnsecid", "desc");
      $this->db->order_by("t_txnchpid", "desc");
      $this->db->where(array('t_txncus_book_id'=>$cus_book_id,'master_id'=>$master_id));
      $this->db->where(array('node_status'=> 2));
      $this->db->where(array('master_id' =>$master_id,'t_txncus_book_id'=>$cus_book_id));
      $query = $this->db->get();
      //print $this->db->last_query(); die;
      return $query->result();
      } */

    //Update Notes

    function updatenotes_get($notes_id, $user_id, $cus_book_id) {
        $notes_id = $this->input->post('note_id');
        $notes_content = $this->input->post('note_content');
        $note_gender = $this->input->post('note_gender');
        $this->db->select('t_txnusrid', 't_txnid', 't_txncontent,t_textstatus,t_txncus_book_id');
        $this->db->from('t_txtnotes');
        $query = $this->db->get();
        $query->result();

        $data = array(
            't_txnusrid' => $user_id,
            't_txnid' => $notes_id,
            't_txncontent' => $notes_content,
            't_textstatus' => $note_gender
        );

        $this->db->where(array('t_txnusrid' => $user_id, 't_txnid' => $notes_id, 't_txncus_book_id' => $cus_book_id));
        $this->db->update('t_txtnotes', $data);

        $noteupdate_section['t_txnid'] = $notes_id;
        $noteupdate_section['t_txncontent'] = $notes_content;

        return $noteupdate_section;
    }

    function getPublicNots_get($parapubNote) {
        //print_r($parapubNote); die;
        $this->db->select('*');
        $this->db->from('asce_para_opration');
        $this->db->where($parapubNote);
        return $this->db->get()->row();
        //print $this->db->last_query(); die;
    }

    //Delete Notes
    function deletenotes($user_id, $cus_book_id, $noteId) {
        //$deletenotes = $this->input->post('notedeleteid');

        $this->db->select('t_txnid');
        $this->db->from('t_txtnotes');
        $this->db->where(array('t_txnusrid' => $user_id, 't_txncus_book_id' => $cus_book_id, 't_txnid' => $noteId));
        $query_result = $this->db->delete('t_txtnotes', array('t_txnid' => $noteId));
        return $noteId;
    }

}
